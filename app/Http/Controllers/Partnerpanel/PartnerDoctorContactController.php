<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use App\Models\PartnerDoctorContactModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerPathologyBannerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerDoctorContactController extends Controller
{
    protected $guard = 'partner';

    /**
     * Display the partner's doctor contact details.
     */
    public function index()
    {
        $partnerId = Auth::guard('partner')->id();

        
        $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
    
      
        $partner = Auth::guard('partner')->user();
    

        $registrationTypes = $partner->registration_type;
        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true) ?: []; 
        }
    
     
        $contactDetails = PartnerDoctorContactModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $contactCount = PartnerDoctorContactModel::where('currently_loggedin_partner_id', $partnerId)->count();
    
   
        return view('partnerpanel.doctors.index', [
            'opdBanner' => $opdBanner,
            'pathologyBanner' => $pathologyBanner,
            'doctorBanner' => $doctorBanner,
            'contactDetails' => $contactDetails ?? null,
            'registrationTypes' => $registrationTypes,
            'contactCount' => $contactCount,
            'partner' => $partner,
        ]);
    }
    

    /**
     * Store or update the doctor's contact details.
     */
    public function store(Request $request)
    {
        $partnerId = Auth::guard('partner')->id();
        $partnerStatus = Auth::guard('partner')->user()->status;
        
        $validatedData = $request->validate([
            'clinic_registration_type' => 'required|string',
            'partner_doctor_name' => 'required|string',
            'partner_doctor_specialist' => 'required|string',
            'partner_doctor_designation' => 'required|string',
            'partner_doctor_fees' => 'required|string',
            'partner_doctor_mobile' => 'required|string|max:15',
            'partner_doctor_email' => 'required|email',
            'partner_doctor_landmark' => 'nullable|string',
            'partner_doctor_pincode' => 'required|string|max:10',
            'partner_doctor_google_map_link' => 'nullable|url',
            'partner_doctor_state' => 'required|string',
            'partner_doctor_city' => 'required|string',
            'partner_doctor_address' => 'required|string',
            'partner_doctor_visit_day' => 'nullable|array',
            'partner_doctor_visit_day.*' => 'nullable|string',
            'partner_doctor_visit_start_time' => 'nullable|array',
            'partner_doctor_visit_start_time.*' => 'nullable|string',
            'partner_doctor_visit_end_time' => 'nullable|array',
            'partner_doctor_visit_end_time.*' => 'nullable|string',
        ]);

        
        $visitDayTime = [];

        // 1. Check if raw schedule JSON is sent
        if ($request->filled('schedule_data_json')) {
            $decoded = json_decode($request->schedule_data_json, true);
            if (is_array($decoded)) {
                $visitDayTime = PartnerDoctorContactModel::normalizeSchedule($decoded);
            }
        }

        // 2. If not sent via JSON, check structured form arrays
        if (empty($visitDayTime) && $request->has('schedule_type') && is_array($request->schedule_type)) {
            foreach ($request->schedule_type as $index => $type) {
                $day = $request->schedule_day[$index] ?? null;
                $date = $request->schedule_date[$index] ?? null;
                if ($type === 'date' && !empty($date)) {
                    try { $day = \Carbon\Carbon::parse($date)->format('l'); } catch (\Exception $e) {}
                }
                if (empty($day) && empty($date)) continue;

                $morningEnabled = !empty($request->morning_enabled[$index]);
                $afternoonEnabled = !empty($request->afternoon_enabled[$index]);
                $eveningEnabled = !empty($request->evening_enabled[$index]);

                $morningStart = $request->morning_start[$index] ?? null;
                $morningEnd = $request->morning_end[$index] ?? null;
                $afternoonStart = $request->afternoon_start[$index] ?? null;
                $afternoonEnd = $request->afternoon_end[$index] ?? null;
                $eveningStart = $request->evening_start[$index] ?? null;
                $eveningEnd = $request->evening_end[$index] ?? null;

                $allStarts = array_filter([$morningEnabled ? $morningStart : null, $afternoonEnabled ? $afternoonStart : null, $eveningEnabled ? $eveningStart : null]);
                $allEnds = array_filter([$morningEnabled ? $morningEnd : null, $afternoonEnabled ? $afternoonEnd : null, $eveningEnabled ? $eveningEnd : null]);
                sort($allStarts);
                rsort($allEnds);

                $visitDayTime[] = [
                    'type' => $type ?: 'day',
                    'day' => $day ?? 'Monday',
                    'date' => $date,
                    'morning_enabled' => (bool)$morningEnabled,
                    'morning_start' => $morningStart,
                    'morning_end' => $morningEnd,
                    'afternoon_enabled' => (bool)$afternoonEnabled,
                    'afternoon_start' => $afternoonStart,
                    'afternoon_end' => $afternoonEnd,
                    'evening_enabled' => (bool)$eveningEnabled,
                    'evening_start' => $eveningStart,
                    'evening_end' => $eveningEnd,
                    'start_time' => !empty($allStarts) ? reset($allStarts) : ($morningStart ?: '09:00'),
                    'end_time' => !empty($allEnds) ? reset($allEnds) : ($eveningEnd ?: '20:00'),
                ];
            }
        }

        // 3. Fallback for legacy simple day array
        if (empty($visitDayTime) && is_array($request->partner_doctor_visit_day)) {
            $legacyItems = [];
            foreach ($request->partner_doctor_visit_day as $index => $day) {
                if (!empty($day)) {
                    $legacyItems[] = [
                        'day' => $day,
                        'start_time' => $request->partner_doctor_visit_start_time[$index] ?? null,
                        'end_time' => $request->partner_doctor_visit_end_time[$index] ?? null,
                    ];
                }
            }
            $visitDayTime = PartnerDoctorContactModel::normalizeSchedule($legacyItems);
        }

        // Clean up unneeded form keys from validated data
        unset($validatedData['partner_doctor_visit_day']);
        unset($validatedData['partner_doctor_visit_start_time']);
        unset($validatedData['partner_doctor_visit_end_time']);

        $validatedData['visit_day_time'] = $visitDayTime;
        $validatedData['currently_loggedin_partner_id'] = $partnerId;
        $validatedData['status'] = $partnerStatus;
        
        PartnerDoctorContactModel::updateOrCreate(
            ['currently_loggedin_partner_id' => $partnerId],
            $validatedData
        );

        session()->flash('data_added', true);

        return redirect()->back()->with('success', 'Doctor contact saved successfully!');
    }
}
