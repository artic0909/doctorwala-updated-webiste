<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Models\PartnerAllOPDDoctorModel;
use App\Models\PartnerAllPathologyTestModel;
use App\Models\PartnerDoctorContactModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyBannerModel;
use App\Models\PartnerPathologyContactModel;
use App\Exports\Partners;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SuperPartnerHandleController extends Controller
{
    public function addPartnerView()
    {

        return view('superadmin.partners.create');
    }




    public function addPartners(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'partner_clinic_name' => 'required|string|max:255',
            'partner_contact_person_name' => 'required|string|max:255',
            'partner_mobile_number' => 'required|string|max:15',
            'partner_email' => 'required|string|email|max:255',
            'partner_state' => 'required|string',
            'partner_city' => 'required|string',
            'partner_pincode' => 'required|string',
            'partner_landmark' => 'required|string',
            'partner_address' => 'required|string',
            'partner_password' => 'required|string',
            'registration_type' => 'required|array',
            'registration_type.*' => 'string',
        ]);

        // Normalize registration_type (supports physiotherapist -> Others, etc.)
        if (is_array($request->registration_type)) {
            $mappedTypes = [];
            foreach ($request->registration_type as $type) {
                $t = strtolower(trim($type));
                if ($t === 'doctor' || $t === 'specialist') {
                    $mappedTypes[] = 'Doctor';
                } elseif ($t === 'physiotherapist' || $t === 'physiotherapy' || $t === 'allied' || $t === 'others') {
                    $mappedTypes[] = 'Others';
                } elseif ($t === 'opd' || $t === 'clinic') {
                    $mappedTypes[] = 'OPD';
                } elseif ($t === 'pathology' || $t === 'path' || $t === 'lab') {
                    $mappedTypes[] = 'Pathology';
                } elseif ($t === 'both') {
                    $mappedTypes[] = 'OPD';
                    $mappedTypes[] = 'Pathology';
                } else {
                    $mappedTypes[] = $type;
                }
            }
            $cleanTypes = array_values(array_unique($mappedTypes));
            $request->merge(['registration_type' => $cleanTypes]);
            $validated['registration_type'] = $cleanTypes;
        }

        // Generate partner ID
        // $partnerCount = DwPartnerModel::count();
        // $partnerId = 'DWPTR' . ($partnerCount + 1);
        $partnerId = 'DWPTR' . (DwPartnerModel::max('id') + 1);

        // Create new partner record
        $dwuser = new DwPartnerModel($validated);
        $dwuser->partner_id = $partnerId;
        $dwuser->partner_password = bcrypt($request->partner_password);
        $dwuser->registration_type = json_encode($request->registration_type);
        $dwuser->status = 'Active';

        // Save partner
        $dwuser->save();

        // Check if OPD is selected
        if (in_array('OPD', $request->registration_type)) {
            PartnerOPDContactModel::create([
                'currently_loggedin_partner_id' => $dwuser->id,
                'clinic_registration_type' => 'OPD',
                'clinic_contact_person_name' => $dwuser->partner_contact_person_name,
                'clinic_name' => $dwuser->partner_clinic_name,
                'clinic_gstin' => null,
                'clinic_mobile_number' => $dwuser->partner_mobile_number,
                'clinic_email' => $dwuser->partner_email,
                'clinic_landmark' => $dwuser->partner_landmark,
                'clinic_pincode' => $dwuser->partner_pincode,
                'clinic_state' => $dwuser->partner_state,
                'clinic_city' => $dwuser->partner_city,
                'clinic_google_map_link' => 'https://www.google.com/maps',
                'clinic_address' => $dwuser->partner_address,
                'status' => 'Active',
            ]);
        }

        // Check if Pathology is selected
        if (in_array('Pathology', $request->registration_type)) {
            PartnerPathologyContactModel::create([
                'currently_loggedin_partner_id' => $dwuser->id,
                'clinic_registration_type' => 'Pathology',
                'clinic_contact_person_name' => $dwuser->partner_contact_person_name,
                'clinic_name' => $dwuser->partner_clinic_name,
                'clinic_gstin' => null,
                'clinic_mobile_number' => $dwuser->partner_mobile_number,
                'clinic_email' => $dwuser->partner_email,
                'clinic_landmark' => $dwuser->partner_landmark,
                'clinic_pincode' => $dwuser->partner_pincode,
                'clinic_state' => $dwuser->partner_state,
                'clinic_city' => $dwuser->partner_city,
                'clinic_google_map_link' => 'https://www.google.com/maps',
                'clinic_address' => $dwuser->partner_address,
                'status' => 'Active',
            ]);
        }

        // Check if Doctor or Others is selected as a registration type
        if (in_array('Doctor', $request->registration_type) || in_array('Others', $request->registration_type)) {
            $isOthers = in_array('Others', $request->registration_type);
            PartnerDoctorContactModel::create([
                'currently_loggedin_partner_id' => $dwuser->id,
                'clinic_registration_type' => $isOthers ? 'Others' : 'Doctor',
                'partner_doctor_name' => $dwuser->partner_contact_person_name,
                'partner_doctor_specialist' => $isOthers ? 'Physiotherapist' : 'General Physician',
                'partner_doctor_designation' => $isOthers ? 'Physiotherapist' : 'Doctor',
                'partner_doctor_fees' => '500',
                'partner_doctor_mobile' => $dwuser->partner_mobile_number,
                'partner_doctor_email' => $dwuser->partner_email,
                'partner_doctor_landmark' => $dwuser->partner_landmark,
                'partner_doctor_pincode' => $dwuser->partner_pincode,
                'partner_doctor_google_map_link' => 'https://www.google.com/maps',
                'partner_doctor_state' => $dwuser->partner_state,
                'partner_doctor_city' => $dwuser->partner_city,
                'partner_doctor_address' => $dwuser->partner_address,
                'visit_day_time' => json_encode([]),
                'status' => 'Active',
            ]);
        }

        // Redirect back with success message
        return redirect()->route('superadmin.super-all-partner.get')->with('success', 'Partner registered and activated successfully!');
    }







    public function editPartnerDetails(Request $request, $id)
    {
        // Find the partner record
        $partner = DwPartnerModel::findOrFail($id);

        // Get the old registration types
        $oldRegistrationTypes = is_array($partner->registration_type)
            ? $partner->registration_type
            : (json_decode($partner->registration_type, true) ?? []);
        if (!is_array($oldRegistrationTypes)) {
            $oldRegistrationTypes = [];
        }

        // Validate the incoming request
        $validated = $request->validate([
            'partner_clinic_name' => 'required|string|max:255',
            'partner_contact_person_name' => 'required|string|max:255',
            'partner_mobile_number' => 'required|string|max:15',
            'partner_email' => 'required|string|email|max:255',
            'partner_state' => 'required|string',
            'partner_city' => 'required|string',
            'partner_pincode' => 'required|string',
            'partner_landmark' => 'required|string',
            'partner_address' => 'required|string',
            'registration_type' => 'required|array',
            'registration_type.*' => 'string',
        ]);

        // Normalize registration_type (supports physiotherapist -> Others, etc.)
        if (is_array($request->registration_type)) {
            $mappedTypes = [];
            foreach ($request->registration_type as $type) {
                $t = strtolower(trim($type));
                if ($t === 'doctor' || $t === 'specialist') {
                    $mappedTypes[] = 'Doctor';
                } elseif ($t === 'physiotherapist' || $t === 'physiotherapy' || $t === 'allied' || $t === 'others') {
                    $mappedTypes[] = 'Others';
                } elseif ($t === 'opd' || $t === 'clinic') {
                    $mappedTypes[] = 'OPD';
                } elseif ($t === 'pathology' || $t === 'path' || $t === 'lab') {
                    $mappedTypes[] = 'Pathology';
                } elseif ($t === 'both') {
                    $mappedTypes[] = 'OPD';
                    $mappedTypes[] = 'Pathology';
                } else {
                    $mappedTypes[] = $type;
                }
            }
            $cleanTypes = array_values(array_unique($mappedTypes));
            $request->merge(['registration_type' => $cleanTypes]);
            $validated['registration_type'] = $cleanTypes;
        }

        // Get the new registration types
        $newRegistrationTypes = $validated['registration_type'];

        // Find removed types
        $removedTypes = array_diff($oldRegistrationTypes, $newRegistrationTypes);

        // Handle deletions based on removed types
        if (in_array('OPD', $removedTypes)) {
            PartnerOPDContactModel::where('currently_loggedin_partner_id', $partner->id)->delete();
            PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partner->id)->delete();
            PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partner->id)->delete();
        }

        if (in_array('Pathology', $removedTypes)) {
            PartnerPathologyContactModel::where('currently_loggedin_partner_id', $partner->id)->delete();
            PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partner->id)->delete();
            PartnerAllPathologyTestModel::where('currently_loggedin_partner_id', $partner->id)->delete();
        }

        if (in_array('Doctor', $removedTypes) || in_array('Others', $removedTypes)) {
            // Only delete if neither Doctor nor Others is present in new types
            if (!in_array('Doctor', $newRegistrationTypes) && !in_array('Others', $newRegistrationTypes)) {
                PartnerDoctorContactModel::where('currently_loggedin_partner_id', $partner->id)->delete();
                PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partner->id)->delete();
            }
        }

        // Handle addition of new registration types
        $addedTypes = array_diff($newRegistrationTypes, $oldRegistrationTypes);

        // Add records for newly added types
        foreach ($addedTypes as $type) {
            if ($type == 'OPD') {
                $existingOpd = PartnerOPDContactModel::where('currently_loggedin_partner_id', $partner->id)->first();
                if (!$existingOpd) {
                    PartnerOPDContactModel::create([
                        'currently_loggedin_partner_id' => $partner->id,
                        'clinic_registration_type' => 'OPD',
                        'clinic_contact_person_name' => $validated['partner_contact_person_name'],
                        'clinic_name' => $validated['partner_clinic_name'],
                        'clinic_gstin' => null,
                        'clinic_mobile_number' => $validated['partner_mobile_number'],
                        'clinic_email' => $validated['partner_email'],
                        'clinic_landmark' => $validated['partner_landmark'],
                        'clinic_pincode' => $validated['partner_pincode'],
                        'clinic_state' => $validated['partner_state'],
                        'clinic_city' => $validated['partner_city'],
                        'clinic_google_map_link' => $partner->clinic_google_map_link ?? 'https://www.google.com/maps',
                        'clinic_address' => $validated['partner_address'],
                        'status' => $partner->status ?? 'Active',
                    ]);
                }
            }

            if ($type == 'Pathology') {
                $existingPath = PartnerPathologyContactModel::where('currently_loggedin_partner_id', $partner->id)->first();
                if (!$existingPath) {
                    PartnerPathologyContactModel::create([
                        'currently_loggedin_partner_id' => $partner->id,
                        'clinic_registration_type' => 'Pathology',
                        'clinic_contact_person_name' => $validated['partner_contact_person_name'],
                        'clinic_name' => $validated['partner_clinic_name'],
                        'clinic_gstin' => null,
                        'clinic_mobile_number' => $validated['partner_mobile_number'],
                        'clinic_email' => $validated['partner_email'],
                        'clinic_landmark' => $validated['partner_landmark'],
                        'clinic_pincode' => $validated['partner_pincode'],
                        'clinic_state' => $validated['partner_state'],
                        'clinic_city' => $validated['partner_city'],
                        'clinic_google_map_link' => $partner->clinic_google_map_link ?? 'https://www.google.com/maps',
                        'clinic_address' => $validated['partner_address'],
                        'status' => $partner->status ?? 'Active',
                    ]);
                }
            }

            if ($type == 'Doctor' || $type == 'Others') {
                $existingDoc = PartnerDoctorContactModel::where('currently_loggedin_partner_id', $partner->id)->first();
                if (!$existingDoc) {
                    $isOthers = ($type == 'Others');
                    PartnerDoctorContactModel::create([
                        'currently_loggedin_partner_id' => $partner->id,
                        'clinic_registration_type' => $isOthers ? 'Others' : 'Doctor',
                        'partner_doctor_name' => $validated['partner_contact_person_name'],
                        'partner_doctor_specialist' => $isOthers ? 'Physiotherapist' : 'General Physician',
                        'partner_doctor_designation' => $isOthers ? 'Physiotherapist' : 'Doctor',
                        'partner_doctor_fees' => '1000',
                        'partner_doctor_mobile' => $validated['partner_mobile_number'],
                        'partner_doctor_email' => $validated['partner_email'],
                        'partner_doctor_landmark' => $validated['partner_landmark'],
                        'partner_doctor_pincode' => $validated['partner_pincode'],
                        'partner_doctor_google_map_link' => $partner->clinic_google_map_link ?? 'https://www.google.com/maps',
                        'partner_doctor_state' => $validated['partner_state'],
                        'partner_doctor_city' => $validated['partner_city'],
                        'partner_doctor_address' => $validated['partner_address'],
                        'visit_day_time' => json_encode([]),
                        'status' => $partner->status ?? 'Active',
                    ]);
                }
            }
        }

        // Update partner details
        $partner->partner_clinic_name = $validated['partner_clinic_name'];
        $partner->partner_contact_person_name = $validated['partner_contact_person_name'];
        // $partner->clinic_name = $validated['clinic_name'];
        $partner->partner_mobile_number = $validated['partner_mobile_number'];
        $partner->partner_email = $validated['partner_email'];
        $partner->partner_state = $validated['partner_state'];
        $partner->partner_city = $validated['partner_city'];
        $partner->partner_pincode = $validated['partner_pincode'];
        $partner->partner_landmark = $validated['partner_landmark'];
        $partner->partner_address = $validated['partner_address'];
        $partner->registration_type = $newRegistrationTypes;

        // Save changes
        $partner->save();

        // Redirect back with success message
        return redirect()->route('superadmin.super-all-partner.get')
            ->with('success', 'Partner details updated successfully!');
    }








    public function allPartnersShow(Request $request)
    {
        $partners = DwPartnerModel::withCount('followups');
        $cities = DwPartnerModel::select('partner_city')->whereNotNull('partner_city')->where('partner_city', '!=', '')->distinct()->orderBy('partner_city')->pluck('partner_city');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $partners->where(function ($query) use ($search) {
                $query->where('partner_clinic_name', 'like', "%{$search}%")
                    ->orWhere('partner_contact_person_name', 'like', "%{$search}%")
                    ->orWhere('partner_email', 'like', "%{$search}%")
                    ->orWhere('partner_mobile_number', 'like', "%{$search}%")
                    ->orWhere('partner_state', 'like', "%{$search}%")
                    ->orWhere('partner_city', 'like', "%{$search}%")
                    ->orWhere('partner_id', 'like', "%{$search}%")
                    ->orWhere('registration_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $partners->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $partners->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('date')) {
            $partners->whereDate('created_at', $request->date);
        }

        if ($request->filled('city')) {
            $partners->where('partner_city', $request->city);
        }

        if ($request->filled('status')) {
            $partners->where('status', $request->status);
        }

        $sort = $request->get('sort', 'newest');
        if ($sort == 'oldest') {
            $partners->orderBy('created_at', 'asc');
        } else {
            $partners->orderBy('created_at', 'desc');
        }

        $partners = $partners->paginate(15)->withQueryString();

        foreach ($partners as $partner) {
            $partner->registration_type = is_string($partner->registration_type)
                ? json_decode($partner->registration_type, true) // For JSON string
                : (is_null($partner->registration_type) ? [] : $partner->registration_type); // Default empty array
        }

        return view('superadmin.partners.index', compact('partners', 'cities'));
    }









    public function statusEdit(Request $request, $id)
    {

        $validated = $request->validate([
            'status' => 'string|nullable',
        ]);

        $partner = DwPartnerModel::find($id);

        if (!$partner) {
            return back()->withErrors(['error' => 'Partner not found']);
        }

        if ($request->has('status')) {
            $partner->status = $request->status;
        }

        $partner->save();

        return back()->with('success', 'Updated successfully!');
    }



    public function deletePartner($id)
    {
        $partnerInfo = DwPartnerModel::find($id);

        $partnerInfo->delete();

        return back()->with('success', 'deleted successfully!');
    }


    public function exportAsExel(Request $request)
    {
        return Excel::download(new Partners($request->all()), 'partner_details.xlsx');
    }

    public function partnerView($id)
    {
        $partner = DwPartnerModel::with(['ep', 'followups'])->findOrFail($id);

        $partner->registration_type = is_string($partner->registration_type)
            ? json_decode($partner->registration_type, true)
            : (is_null($partner->registration_type) ? [] : $partner->registration_type);

        $opd = PartnerOPDContactModel::with('banner', 'doctors')->where('currently_loggedin_partner_id', $partner->id)->first();
        $pathology = PartnerPathologyContactModel::with('banner', 'tests')->where('currently_loggedin_partner_id', $partner->id)->first();
        $doctor = PartnerDoctorContactModel::with('banner')->where('currently_loggedin_partner_id', $partner->id)->first();
        $inquiriesCount = \App\Models\PartnerPatientInquiry::where('currently_loggedin_partner_id', $partner->id)->count();

        return view('superadmin.partners.view', compact('partner', 'opd', 'pathology', 'doctor', 'inquiriesCount'));
    }

    public function loginAsPartner($id)
    {
        $partner = DwPartnerModel::findOrFail($id);

        \Illuminate\Support\Facades\Auth::guard('partner')->loginUsingId($partner->id);

        return redirect()->route('partnerpanel.partner-dashboard')->with('success', 'Logged in as partner: ' . ($partner->partner_clinic_name ?: $partner->partner_contact_person_name));
    }
}
