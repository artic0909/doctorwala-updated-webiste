<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use App\Models\PartnerAllPathologyTestModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerOPDBannerModel;
use App\Models\PartnerPathologyBannerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerAllPathologyInfoController extends Controller
{
    protected $guard = 'partner';



    public function index()
    {
        $partnerId = Auth::guard('partner')->id();
        $opdBanner = PartnerOPDBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $pathologyBanner = PartnerPathologyBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();
        $doctorBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $partnerId)->first();

        $allpaths = PartnerAllPathologyTestModel::where('currently_loggedin_partner_id', $partnerId)->count();

        $partner = Auth::guard('partner')->user();
        $registrationTypes = $partner->registration_type;

        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }


        $registrationTypess = $partner->registration_type; // Automatically casted as an array if set in the model
        $contactDetails = PartnerAllPathologyTestModel::where('currently_loggedin_partner_id', $partnerId)->first();

        return view('partnerpanel.pathology.upload', compact('contactDetails', 'registrationTypes', 'registrationTypess', 'opdBanner', 'pathologyBanner', 'doctorBanner', 'allpaths'));
    }







    public function store(Request $request)
    {
        $partnerId = Auth::guard('partner')->id();

        // Validate the input
        $request->validate([
            'test_name' => 'required|string',
            'test_type' => 'required|string',
            'test_price' => 'required|numeric',
            'test_day' => 'nullable|array',
            'test_day.*' => 'nullable|string|max:255',
            'test_start_time' => 'nullable|array',
            'test_start_time.*' => 'nullable|date_format:H:i',
            'test_end_time' => 'nullable|array',
            'test_end_time.*' => 'nullable|date_format:H:i',
        ]);

        // Prepare visit day and time data
        $testDayTime = [];
        foreach ($request->test_day as $index => $day) {
            $testDayTime[] = [
                'day' => $day,
                'start_time' => $request->test_start_time[$index],
                'end_time' => $request->test_end_time[$index],
            ];
        }

        // Prepare the data to be stored
        $data = [
            'currently_loggedin_partner_id' => $partnerId, // Always store the partner ID
            'test_name' => $request->test_name,
            'test_type' => $request->test_type,
            'test_price' => $request->test_price,
            'test_day_time' => json_encode($testDayTime), // Ensure it's stored as JSON
        ];

        // Store new data for the partner without overwriting existing records
        PartnerAllPathologyTestModel::create($data);

        return redirect()->back()->with('success', 'Pathology test details added successfully!');
    }




    public function showStoredData(Request $request)
    {
        $partner = Auth::guard('partner')->user();
        $partnerId = $partner->id;
        $partnerIds = array_values(array_filter([$partner->id, $partner->partner_id]));

        $opdBanner = PartnerOPDBannerModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();
        $pathologyBanner = PartnerPathologyBannerModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();
        $doctorBanner = PartnerDoctorBannerModel::whereIn('currently_loggedin_partner_id', $partnerIds)->first();

        $query = PartnerAllPathologyTestModel::whereIn('currently_loggedin_partner_id', $partnerIds);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('test_name', 'like', "%{$search}%")
                  ->orWhere('test_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $storedData = $query->latest('updated_at')->paginate(15)->withQueryString();
        $allpaths = PartnerAllPathologyTestModel::whereIn('currently_loggedin_partner_id', $partnerIds)->count();
        $availablePaths = PartnerAllPathologyTestModel::whereIn('currently_loggedin_partner_id', $partnerIds)->where('status', 'Available')->count();

        foreach ($storedData as $data) {
            if (is_string($data->test_day_time)) {
                $data->test_day_time = json_decode($data->test_day_time, true) ?? [];
            } elseif (!is_array($data->test_day_time)) {
                $data->test_day_time = [];
            }
        }

        $registrationTypes = $partner->registration_type;

        if (is_string($registrationTypes)) {
            $registrationTypes = json_decode($registrationTypes, true);
        }

        return view('partnerpanel.pathology.index', compact('opdBanner', 'pathologyBanner', 'doctorBanner', 'storedData', 'registrationTypes', 'allpaths', 'availablePaths'));
    }





    public function updateStoredData(Request $request, $id)
    {
        // Get the partner ID from the currently authenticated partner
        $partnerId = Auth::guard('partner')->id();

        // Validate the input
        $request->validate([
            'test_name' => 'string|max:255',
            'test_type' => 'string|max:255',
            'test_price' => 'numeric',
            'test_day' => 'nullable|array',
            'test_day.*' => 'nullable|string|max:255',
            'test_start_time' => 'nullable|array',
            'test_start_time.*' => 'nullable|date_format:H:i',
            'test_end_time' => 'nullable|array',
            'test_end_time.*' => 'nullable|date_format:H:i',
            'status' => 'string|max:255',
        ]);

        // Fetch the specific record for the given $id and $partnerId
        $pathologyTest = PartnerAllPathologyTestModel::where('id', $id)
            ->where('currently_loggedin_partner_id', $partnerId)
            ->first();

        if (!$pathologyTest) {
            return redirect()->back()->with('error', 'Pathology test details not found.');
        }

        // Prepare day and time data
        $testDayTime = [];
        if ($request->has('test_day')) {
            foreach ($request->test_day as $index => $day) {
                $testDayTime[] = [
                    'day' => $day,
                    'start_time' => $request->test_start_time[$index] ?? null,
                    'end_time' => $request->test_end_time[$index] ?? null,
                ];
            }
        }

        // Prepare the data to update
        $data = [
            'test_name' => $request->test_name,
            'test_type' => $request->test_type,
            'test_price' => $request->test_price,
            'status' => $request->status,
            'test_day_time' => json_encode($testDayTime), // Serialize to JSON
        ];

        // Update the record
        $pathologyTest->update($data);

        return redirect()->back()->with('success', 'Pathology test details updated successfully!');
    }






    public function destroy(Request $request, $id)
    {

        $partnerId = Auth::guard('partner')->id();

        $opdDoctor = PartnerAllPathologyTestModel::where('id', $id)
            ->where('currently_loggedin_partner_id', $partnerId)
            ->first();

        if (!$opdDoctor) {
            return redirect()->back()->with('error', 'Pathology test details not found.');
        }


        $opdDoctor->delete();

        return redirect()->back()->with('success', 'Pathology test details deleted successfully!');
    }
}
