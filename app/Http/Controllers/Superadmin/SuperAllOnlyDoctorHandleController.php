<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerDoctorContactModel;
use App\Exports\DocExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SuperAllOnlyDoctorHandleController extends Controller
{



    public function docView(Request $request)
    {
        $query = PartnerDoctorContactModel::orderBy('created_at', 'desc');
    
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
    
            $query->where(function ($q) use ($search) {
                $q->where('partner_doctor_name', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_specialist', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_fees', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_email', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_landmark', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_mobile', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_pincode', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_state', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_address', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_city', 'like', "%{$search}%");
            });
        }
    
        $docs = $query->paginate(4);
    
        foreach ($docs as $doc) {
            $partner = DwPartnerModel::find($doc->currently_loggedin_partner_id);
    
            $doc->pid = $partner->id ?? null;
            $doc->partner_id = $partner->partner_id ?? null;
            $doc->partner_clinic_name = $partner->partner_clinic_name ?? null;
            $doc->partner_mobile_number = $partner->partner_mobile_number ?? null;
            $doc->partner_contact_person_name = $partner->partner_contact_person_name ?? null;
        }
    
        return view('superadmin.super-all-doctors', compact('docs'));
    }





    public function statusEdit(Request $request, $id)
    {

        $validated = $request->validate([
            'status' => 'string|nullable',
        ]);

        $doc = PartnerDoctorContactModel::find($id);

        if (!$doc) {
            return back()->withErrors(['error' => 'Doctor Details not found']);
        }

        if ($request->has('status')) {
            $doc->status = $request->status;
        }

        $doc->save();

        return back()->with('success', 'Updated successfully!');
    }





    public function docEditPageView($id)
    {

        $doc = PartnerDoctorContactModel::findOrFail($id);

        return view('superadmin.super-edit-doctors-details', compact('doc'));
    }




    public function updateDocContactDetails(Request $request, $id)
    {

        $request->validate([
            'clinic_registration_type' => 'string',
            'partner_doctor_name' => 'string',
            'partner_doctor_specialist' => 'string',
            'partner_doctor_designation' => 'string',
            'partner_doctor_fees' => 'string',
            'partner_doctor_mobile' => 'string|max:15',
            'partner_doctor_email' => 'email',
            'partner_doctor_landmark' => 'string',
            'partner_doctor_pincode' => 'string|max:10',
            'partner_doctor_google_map_link' => 'nullable|url',
            'partner_doctor_state' => 'string',
            'partner_doctor_city' => 'string',
            'partner_doctor_address' => 'string',
        ]);


        $contactDetails = PartnerDoctorContactModel::find($id);


        if (!$contactDetails) {
            return redirect()->back()->with('error', 'Contact details not found.');
        }


        $contactDetails->update($request->all());

        return redirect()->back()->with('success', 'Contact details updated successfully.');
    }




    public function deleteDocContactDetails($id)
    {

        $contactDetails = PartnerDoctorContactModel::find($id);

        if (!$contactDetails) {
            return redirect()->back()->with('error', 'Contact details not found.');
        }

        $contactDetails->delete();

        return redirect()->back()->with('success', 'Contact details deleted successfully.');
    }






    public function addDoctorPageView($pid)
    {

        $docBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $pid)->first();


        return view('superadmin.super-adddoc-banner', compact('pid', 'docBanner'));
    }




    public function adddocBanner(Request $request)
    {

        $validated = $request->validate([
            'currently_loggedin_partner_id' => 'required|numeric',
            'doctorbanner' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);


        $docBannerPath = $this->uploadpathBanner($request);


        $this->updateOrCreatepathBanner($validated['currently_loggedin_partner_id'], $docBannerPath);


        return redirect()->back()->with('success', 'Docotr Banner uploaded/updated successfully.');
    }

    /**
     * Handles the upload of the OPD banner file.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    private function uploadpathBanner(Request $request)
    {
        if ($request->hasFile('doctorbanner')) {
            return $request->file('doctorbanner')->store('partner-doctor-profile', 'public');
        }

        return null;
    }

    /**
     * Updates or creates the OPD banner record for the partner.
     *
     * @param int $partnerId
     * @param string|null $docBannerPath
     * @return void
     */
    private function updateOrCreatepathBanner(int $partnerId, ?string $docBannerPath)
    {
        $pathBanner = PartnerDoctorBannerModel::firstOrNew(['currently_loggedin_partner_id' => $partnerId]);

        if ($docBannerPath) {
            $pathBanner->doctorbanner = $docBannerPath;
        }

        $pathBanner->save();
    }




    public function exportAsExel(Request $request){
        return Excel::download(new DocExport, 'Doc_details.xlsx');
    }
}
