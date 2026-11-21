<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Models\PartnerDoctorBannerModel;
use App\Models\PartnerDoctorContactModel;
use App\Exports\OthersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;

class SuperAllOthersHandleController extends Controller
{
    /**
     * Display a listing of Physiotherapy & Allied Care (Others) partners.
     */
    public function othersView(Request $request)
    {
        $query = PartnerDoctorContactModel::where('clinic_registration_type', 'Others');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('partner_doctor_name', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_specialist', 'like', "%{$search}%")
                  ->orWhere('partner_doctor_designation', 'like', "%{$search}%")
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

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $others = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        foreach ($others as $item) {
            $partner = DwPartnerModel::find($item->currently_loggedin_partner_id);

            $item->pid = $partner->id ?? null;
            $item->partner_id = $partner->partner_id ?? null;
            $item->partner_clinic_name = $partner->partner_clinic_name ?? null;
            $item->partner_mobile_number = $partner->partner_mobile_number ?? null;
            $item->partner_contact_person_name = $partner->partner_contact_person_name ?? null;
        }

        return view('superadmin.others.index', compact('others'));
    }

    /**
     * Update status (Active/Inactive) of a Physiotherapist / Allied Care record.
     */
    public function statusEdit(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Active,Inactive',
        ]);

        $item = PartnerDoctorContactModel::find($id);

        if (!$item) {
            return back()->withErrors(['error' => 'Profile details not found']);
        }

        $item->status = $request->status;
        $item->save();

        return back()->with('success', 'Status updated successfully!');
    }

    /**
     * Show edit form for Physiotherapist / Allied Care profile.
     */
    public function othersEditPageView($id)
    {
        $doc = PartnerDoctorContactModel::where('clinic_registration_type', 'Others')->findOrFail($id);

        return view('superadmin.others.edit', compact('doc'));
    }

    /**
     * Update Physiotherapist / Allied Care contact details & profile.
     */
    public function updateOthersContactDetails(Request $request, $id)
    {
        $request->validate([
            'partner_doctor_name' => 'required|string|max:255',
            'partner_doctor_specialist' => 'required|string|max:255',
            'partner_doctor_designation' => 'required|string|max:100',
            'partner_doctor_fees' => 'required|string|max:50',
            'partner_doctor_mobile' => 'required|string|max:15',
            'partner_doctor_email' => 'required|email|max:255',
            'partner_doctor_landmark' => 'nullable|string|max:255',
            'partner_doctor_pincode' => 'required|string|max:10',
            'partner_doctor_google_map_link' => 'nullable|url',
            'partner_doctor_state' => 'required|string|max:100',
            'partner_doctor_city' => 'required|string|max:100',
            'partner_doctor_address' => 'required|string',
        ]);

        $item = PartnerDoctorContactModel::where('clinic_registration_type', 'Others')->findOrFail($id);

        $item->update($request->only([
            'partner_doctor_name',
            'partner_doctor_specialist',
            'partner_doctor_designation',
            'partner_doctor_fees',
            'partner_doctor_mobile',
            'partner_doctor_email',
            'partner_doctor_landmark',
            'partner_doctor_pincode',
            'partner_doctor_google_map_link',
            'partner_doctor_state',
            'partner_doctor_city',
            'partner_doctor_address',
        ]));

        return redirect()->back()->with('success', 'Physiotherapist / Allied Care profile updated successfully.');
    }

    /**
     * Delete Physiotherapist / Allied Care contact details.
     */
    public function deleteOthersContactDetails($id)
    {
        $item = PartnerDoctorContactModel::where('clinic_registration_type', 'Others')->find($id);

        if (!$item) {
            return redirect()->back()->with('error', 'Profile details not found.');
        }

        $item->delete();

        return redirect()->back()->with('success', 'Profile details deleted successfully.');
    }

    /**
     * Show banner upload page for Physiotherapist / Allied Care partner.
     */
    public function addOthersBannerPageView($pid)
    {
        $docBanner = PartnerDoctorBannerModel::where('currently_loggedin_partner_id', $pid)->first();

        return view('superadmin.others.add-banner', compact('pid', 'docBanner'));
    }

    /**
     * Upload or update banner for Physiotherapist / Allied Care partner.
     */
    public function addOthersBanner(Request $request)
    {
        $validated = $request->validate([
            'currently_loggedin_partner_id' => 'required|numeric',
            'doctorbanner' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $docBannerPath = $this->uploadBanner($request);
        $this->updateOrCreateBanner($validated['currently_loggedin_partner_id'], $docBannerPath);

        return redirect()->back()->with('success', 'Banner uploaded/updated successfully.');
    }

    /**
     * Handle upload & compression of banner.
     */
    private function uploadBanner(Request $request)
    {
        if ($request->hasFile('doctorbanner')) {
            return ImageCompressionService::compressAndStore(
                $request->file('doctorbanner'),
                'partner-doctor-profile',
                'public',
                1920,
                1080,
                80
            );
        }

        return null;
    }

    /**
     * Update or create the banner record.
     */
    private function updateOrCreateBanner(int $partnerId, ?string $docBannerPath)
    {
        $banner = PartnerDoctorBannerModel::firstOrNew(['currently_loggedin_partner_id' => $partnerId]);

        if ($docBannerPath) {
            $banner->doctorbanner = $docBannerPath;
        }

        $banner->save();
    }

    /**
     * Export Physiotherapy & Allied Care providers to Excel.
     */
    public function exportAsExcel(Request $request)
    {
        return Excel::download(new OthersExport, 'Physiotherapy_Allied_details.xlsx');
    }
}
