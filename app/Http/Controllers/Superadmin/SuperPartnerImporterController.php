<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\DwPartnerModel;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyContactModel;
use App\Models\SuperCouponModel;
use App\Models\CouponHolderModel;
use App\Services\TwilioWhatsAppService;

class SuperPartnerImporterController extends Controller
{
    public function index()
    {
        return view('superadmin.importer.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('csv_file');
        
        $handle = fopen($file->getRealPath(), "r");
        if ($handle === false) {
            return back()->with('error', 'Unable to read the CSV file.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            return back()->with('error', 'CSV file is empty or improperly formatted.');
        }

        // Remove BOM from the first header column if it exists
        $header[0] = preg_replace('/[\xef\xbb\xbf]/', '', $header[0]);

        $couponCode = 'DWCPNFREE01';
        $coupon = SuperCouponModel::where('coupon_code', $couponCode)->first();
        if (!$coupon) {
            return back()->with('error', 'Required Coupon (' . $couponCode . ') not found in the database. Please create it first.');
        }

        $successCount = 0;
        $duplicateCount = 0;
        $errorCount = 0;
        $results = []; // To store row-by-row status
        $rowIndex = 1; // Starting from row 1 (after header)

        $twilioService = new TwilioWhatsAppService();

        while (($row = fgetcsv($handle)) !== false) {
            $rowIndex++;
            // Check if row matches header length
            if (count($row) !== count($header)) {
                $errorCount++;
                $results[] = ['row' => $rowIndex, 'clinic' => 'Unknown', 'status' => 'Error', 'message' => 'Column count does not match header count.'];
                continue;
            }

            $data = array_combine($header, $row);
            $clinicName = $data['clinic_name'] ?? 'Unknown Clinic';

            // Required fields check
            if (empty($data['mobile_number']) || empty($data['email']) || empty($data['clinic_name']) || empty($data['registration_type'])) {
                $errorCount++;
                $results[] = ['row' => $rowIndex, 'clinic' => $clinicName, 'status' => 'Error', 'message' => 'Missing required fields (mobile_number, email, clinic_name, or registration_type).'];
                continue;
            }

            // Check duplicates
            $exists = DwPartnerModel::where('partner_mobile_number', $data['mobile_number'])
                ->orWhere('partner_email', $data['email'])
                ->exists();

            if ($exists) {
                $duplicateCount++;
                $results[] = ['row' => $rowIndex, 'clinic' => $clinicName, 'status' => 'Warning', 'message' => 'Skipped: Duplicate mobile number or email.'];
                continue;
            }

            try {
                // Determine Registration Type
                $type = trim($data['registration_type']); // Expected: "OPD", "Pathology", "Both"
                $regTypes = [];
                if (strtolower($type) === 'both') {
                    $regTypes = ['OPD', 'Pathology'];
                } elseif (strtolower($type) === 'opd') {
                    $regTypes = ['OPD'];
                } elseif (strtolower($type) === 'pathology') {
                    $regTypes = ['Pathology'];
                } else {
                    // Fallback
                    $regTypes = [$type];
                }

                // Create Partner
                $dwuser = new DwPartnerModel();
                $dwuser->partner_clinic_name = $data['clinic_name'];
                $dwuser->partner_contact_person_name = $data['contact_person'];
                $dwuser->partner_mobile_number = $data['mobile_number'];
                $dwuser->partner_email = $data['email'];
                $dwuser->partner_state = $data['state'] ?? '';
                $dwuser->partner_city = $data['city'] ?? '';
                $dwuser->partner_pincode = $data['pincode'] ?? '';
                $dwuser->partner_landmark = $data['landmark'] ?? '';
                $dwuser->clinic_google_map_link = $data['google_map_link'] ?? '';
                $dwuser->partner_address = $data['address'] ?? '';
                $dwuser->partner_password = bcrypt('12345678');
                $dwuser->registration_type = json_encode($regTypes);
                $dwuser->status = 'Active';
                $dwuser->partner_id = 'TMP_' . uniqid();
                $dwuser->save();

                $dwuser->partner_id = 'DWPTR' . $dwuser->id;
                $dwuser->save();

                // Create Contact Models
                if (in_array('OPD', $regTypes)) {
                    PartnerOPDContactModel::create([
                        'currently_loggedin_partner_id' => $dwuser->id,
                        'clinic_registration_type' => 'OPD',
                        'clinic_contact_person_name' => $dwuser->partner_contact_person_name,
                        'clinic_name' => $dwuser->partner_clinic_name,
                        'clinic_mobile_number' => $dwuser->partner_mobile_number,
                        'clinic_email' => $dwuser->partner_email,
                        'clinic_landmark' => $dwuser->partner_landmark,
                        'clinic_pincode' => $dwuser->partner_pincode,
                        'clinic_state' => $dwuser->partner_state,
                        'clinic_city' => $dwuser->partner_city,
                        'clinic_google_map_link' => $dwuser->clinic_google_map_link,
                        'clinic_address' => $dwuser->partner_address,
                        'status' => 'Active',
                    ]);
                }

                if (in_array('Pathology', $regTypes)) {
                    PartnerPathologyContactModel::create([
                        'currently_loggedin_partner_id' => $dwuser->id,
                        'clinic_registration_type' => 'Pathology',
                        'clinic_contact_person_name' => $dwuser->partner_contact_person_name,
                        'clinic_name' => $dwuser->partner_clinic_name,
                        'clinic_mobile_number' => $dwuser->partner_mobile_number,
                        'clinic_email' => $dwuser->partner_email,
                        'clinic_landmark' => $dwuser->partner_landmark,
                        'clinic_pincode' => $dwuser->partner_pincode,
                        'clinic_state' => $dwuser->partner_state,
                        'clinic_city' => $dwuser->partner_city,
                        'clinic_google_map_link' => $dwuser->clinic_google_map_link,
                        'clinic_address' => $dwuser->partner_address,
                        'status' => 'Active',
                    ]);
                }

                // Add Coupon
                CouponHolderModel::create([
                    'currently_loggedin_partner_id' => $dwuser->id,
                    'coupon_code' => $coupon->coupon_code,
                    'coupon_amount' => $coupon->coupon_amount,
                    'coupon_start_date' => $coupon->coupon_start_date ?? date('Y-m-d'),
                    'coupon_end_date' => $coupon->coupon_end_date ?? date('Y-m-d', strtotime('+1 year')),
                ]);

                // Send WhatsApp Welcome
                if ($dwuser->partner_mobile_number) {
                    $clinicType = implode(', ', $regTypes);
                    $twilioService->sendPartnerWelcome(
                        $dwuser->partner_mobile_number,
                        $dwuser->partner_contact_person_name,
                        $dwuser->partner_clinic_name,
                        $clinicType
                    );
                }

                $successCount++;
                $results[] = ['row' => $rowIndex, 'clinic' => $clinicName, 'status' => 'Success', 'message' => 'Partner successfully registered and activated.'];
            } catch (\Exception $e) {
                Log::error('Partner CSV Import Error on Row: ' . json_encode($data) . ' Error: ' . $e->getMessage());
                $errorCount++;
                $results[] = ['row' => $rowIndex, 'clinic' => $clinicName, 'status' => 'Error', 'message' => 'Exception occurred: ' . $e->getMessage()];
            }
        }

        fclose($handle);

        $msg = "Import completed! Successfully imported: {$successCount}. Duplicates skipped: {$duplicateCount}. Errors: {$errorCount}.";
        return back()->with('success', $msg)->with('results', $results);
    }

    public function downloadTemplate()
    {
        $headers = [
            'clinic_name',
            'contact_person',
            'mobile_number',
            'email',
            'state',
            'city',
            'pincode',
            'landmark',
            'address',
            'google_map_link',
            'registration_type'
        ];

        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fputcsv($file, [
                'Test Clinic', 
                'John Doe', 
                '9876543210', 
                'test@example.com', 
                'West Bengal', 
                'Kolkata', 
                '700001', 
                'Near Station', 
                '123 Street Name', 
                'https://maps.google.com/...', 
                'Both'
            ]);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=partner_import_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ]);
    }
}
