<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Models\PartnerDoctorContactModel;
use App\Models\PartnerPatientInquiry;
use App\Models\Wallet;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentPaymentController extends Controller
{
    protected RazorpayService $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    /**
     * Helper to resolve partner model from id or partner_id string
     */
    protected function resolvePartner($partnerIdInput)
    {
        if (empty($partnerIdInput)) return null;

        return DwPartnerModel::where('id', $partnerIdInput)
            ->orWhere('partner_id', $partnerIdInput)
            ->first();
    }

    /**
     * Determine consultation fee for a doctor/others partner
     */
    protected function getDoctorFee($partner, $doctorId = null, $requestedFee = null): float
    {
        if (!empty($requestedFee) && is_numeric($requestedFee) && (float) $requestedFee > 0) {
            return (float) $requestedFee;
        }

        if ($partner) {
            $partnerIds = array_filter([$partner->id, $partner->partner_id]);
            $docContact = PartnerDoctorContactModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();
            if ($docContact && !empty($docContact->partner_doctor_fees) && is_numeric($docContact->partner_doctor_fees)) {
                return (float) $docContact->partner_doctor_fees;
            }
        }

        return 500.00; // default consultation fee fallback
    }

    /**
     * Create Razorpay Order for Doctor / Others Appointment Booking
     */
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currently_loggedin_partner_id' => 'required',
            'clinic_type' => 'required|string',
            'user_name' => 'required|string',
            'user_mobile' => 'required|string',
            'user_email' => 'nullable|email',
            'amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $partner = $this->resolvePartner($request->currently_loggedin_partner_id);

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Partner not found.',
            ], 404);
        }

        // Check if partner is Doctor or Others
        $regTypes = $partner->registration_type;
        if (is_string($regTypes)) {
            $regTypes = json_decode($regTypes, true) ?: explode(',', $regTypes);
        }
        $regTypes = is_array($regTypes) ? $regTypes : [];
        $isDoctorOrOthers = in_array('Doctor', $regTypes) || in_array('Others', $regTypes)
            || in_array(strtolower($request->clinic_type), ['doctor', 'others']);

        if (!$isDoctorOrOthers) {
            return response()->json([
                'status' => false,
                'message' => 'Online payment is only applicable for Doctor and Physiotherapy / Allied Care appointments.',
            ], 400);
        }

        $fee = $this->getDoctorFee($partner, $request->doctor_id, $request->amount);

        $receipt = 'RCPT_' . time() . '_' . mt_rand(100, 999);

        $notes = [
            'partner_id' => (string) $partner->id,
            'partner_code' => (string) ($partner->partner_id ?? ''),
            'clinic_name' => (string) ($request->clinic_name ?? $partner->partner_clinic_name ?? 'Doctor Clinic'),
            'patient_name' => (string) $request->user_name,
            'patient_mobile' => (string) $request->user_mobile,
            'clinic_type' => (string) $request->clinic_type,
        ];

        $orderResult = $this->razorpay->createOrder($fee, $receipt, $notes);

        if (!$orderResult['success']) {
            return response()->json([
                'status' => false,
                'message' => $orderResult['message'] ?? 'Failed to initialize payment gateway order.',
            ], 500);
        }

        $order = $orderResult['order'];

        return response()->json([
            'status' => true,
            'key' => $this->razorpay->getKeyId(),
            'order_id' => $order['id'],
            'amount' => $order['amount'], // in paise
            'amount_in_rupees' => $fee,
            'currency' => $order['currency'] ?? 'INR',
            'receipt' => $receipt,
            'partner_id' => $partner->id,
            'clinic_name' => $request->clinic_name ?? $partner->partner_clinic_name ?? 'Doctor Clinic',
            'user_name' => $request->user_name,
            'user_mobile' => $request->user_mobile,
            'user_email' => $request->user_email,
        ]);
    }

    /**
     * Verify Payment and Confirm Appointment Booking + Credit Partner Wallet
     */
    public function verifyPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'currently_loggedin_partner_id' => 'required',
            'clinic_type' => 'required|string',
            'user_name' => 'required|string',
            'user_mobile' => 'required|string',
            'user_inquiry' => 'nullable|string',
            'booking_date' => 'nullable',
            'booking_time' => 'nullable',
            'visit_mode' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $orderId = $request->razorpay_order_id;
        $paymentId = $request->razorpay_payment_id;
        $signature = $request->razorpay_signature;

        // 1. Signature Verification
        $isValid = $this->razorpay->verifySignature($orderId, $paymentId, $signature);

        if (!$isValid) {
            Log::warning("Razorpay Signature Mismatch: Order={$orderId}, Payment={$paymentId}");
            return response()->json([
                'status' => false,
                'message' => 'Payment signature verification failed. Please contact support.',
            ], 400);
        }

        $partner = $this->resolvePartner($request->currently_loggedin_partner_id);

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Partner record not found.',
            ], 404);
        }

        // Determine fee paid (either from payment gateway or requested amount)
        $paymentDetails = $this->razorpay->fetchPayment($paymentId);
        $amountPaid = $paymentDetails && isset($paymentDetails['amount'])
            ? (float) ($paymentDetails['amount'] / 100)
            : $this->getDoctorFee($partner, $request->doctor_id, $request->amount);

        // Determine visit mode
        $clinicType = strtolower($request->clinic_type ?? '');
        $visitMode = $request->visit_mode;
        if ($clinicType === 'doctor') {
            $visitMode = 'online';
        } elseif ($clinicType === 'others') {
            $visitMode = in_array(strtolower($visitMode ?? ''), ['online', 'offline']) ? strtolower($visitMode) : 'offline';
        } else {
            $visitMode = 'offline';
        }

        // 2. Database Transaction: Create Inquiry + Credit Partner Wallet
        try {
            $result = DB::transaction(function () use ($request, $partner, $orderId, $paymentId, $signature, $amountPaid, $visitMode, $clinicType) {
                // Create Appointment Inquiry
                $inquiry = PartnerPatientInquiry::create([
                    'currently_loggedin_partner_id' => $partner->id,
                    'clinic_type' => $request->clinic_type ?? 'Doctor',
                    'clinic_name' => $request->clinic_name ?? $partner->partner_clinic_name ?? 'Doctor Clinic',
                    'dw_user_id' => $request->dw_user_id,
                    'doctor_id' => $request->doctor_id,
                    'user_name' => $request->user_name,
                    'user_mobile' => $request->user_mobile,
                    'user_email' => $request->user_email,
                    'user_inquiry' => $request->user_inquiry ?? 'Consultation Appointment',
                    'booking_date' => $request->booking_date,
                    'booking_time' => $request->booking_time,
                    'visit_mode' => $visitMode,
                    'is_video' => $visitMode === 'online',
                    'status' => 'Confirmed',
                    'payment_status' => 'paid',
                    'payment_amount' => $amountPaid,
                    'razorpay_order_id' => $orderId,
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                ]);

                // Ensure video channel if online
                if ($visitMode === 'online') {
                    $inquiry->ensureVideoChannel();
                }

                // Credit Partner Wallet
                $wallet = Wallet::firstOrCreate(
                    ['dw_partner_id' => $partner->id],
                    [
                        'balance' => 0.00,
                        'currency' => 'INR',
                        'status' => 'active',
                    ]
                );

                $description = "Consultation fee from {$inquiry->user_name} ({$inquiry->clinic_name})";

                $transaction = $wallet->credit(
                    $amountPaid,
                    'consultation',
                    $paymentId,
                    $description,
                    'pending', // settlement_status default pending as requested
                    $inquiry->id,
                    $paymentId,
                    $orderId
                );

                return [
                    'inquiry' => $inquiry,
                    'transaction' => $transaction,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Payment successful! Your appointment has been booked.',
                'appointment' => $result['inquiry'],
                'transaction_id' => $result['transaction']->id,
                'payment_id' => $paymentId,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Payment Booking Transaction Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Payment received but failed to record appointment: ' . $e->getMessage(),
            ], 500);
        }
    }
}
