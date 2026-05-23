<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reffer;
use App\Models\SuperAboutusModel;
use Illuminate\Support\Str;

class RefferController extends Controller
{
    /**
     * Show the referral registration form (direct access).
     */
    public function index()
    {
        $aboutDetails = SuperAboutusModel::get();
        $referrer = null;
        return view('reffer.form', compact('aboutDetails', 'referrer'));
    }

    /**
     * Show the referral registration form with a referrer code.
     */
    public function referredIndex($code)
    {
        $aboutDetails = SuperAboutusModel::get();
        $referrer = Reffer::where('referral_code', $code)->first();

        // If the referral code is invalid, we still render the direct form
        return view('reffer.form', compact('aboutDetails', 'referrer'));
    }

    /**
     * Store a new referral registration.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:reffers,phone',
            'upi' => 'required|string|max:255',
            'medical_card_number' => 'required|string|max:255',
            'profile_screenshot' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'referred_by_code' => 'nullable|string|exists:reffers,referral_code',
        ], [
            'name.required' => 'The full name field is required.',
            'phone.required' => 'The phone number field is required.',
            'phone.numeric' => 'The phone number must be a valid number.',
            'phone.unique' => 'This phone number is already registered in the referral program.',
            'upi.required' => 'The bank details or UPI ID field is required.',
            'medical_card_number.required' => 'The medical card number field is required.',
            'profile_screenshot.required' => 'The profile screenshot is required.',
            'profile_screenshot.image' => 'The profile screenshot must be an image file.',
            'referred_by_code.exists' => 'The referral link used is invalid.',
        ]);

        // Upload Profile Screenshot to storage/screenshots
        $screenshotPath = '';
        if ($request->hasFile('profile_screenshot')) {
            $file = $request->file('profile_screenshot');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/screenshots'), $fileName);
            $screenshotPath = 'screenshots/' . $fileName;
        }

        // Determine parent referrer
        $referredBy = null;
        $reffredStatus = 0;
        if ($request->filled('referred_by_code')) {
            $referrer = Reffer::where('referral_code', $request->referred_by_code)->first();
            if ($referrer) {
                $referredBy = $referrer->id;
                $reffredStatus = 1;
            }
        }

        // Generate a unique referral code
        do {
            $referralCode = 'DRW' . strtoupper(Str::random(6));
        } while (Reffer::where('referral_code', $referralCode)->exists());

        // Create the Reffer record
        $reffer = Reffer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'upi' => $request->upi,
            'medical_card_number' => $request->medical_card_number,
            'profile_screenshot' => $screenshotPath,
            'referral_code' => $referralCode,
            'reffred' => $reffredStatus,
            'referred_by' => $referredBy,
        ]);

        return redirect()->route('reffer.success', ['code' => $reffer->referral_code])
            ->with('success', 'Your registration is complete! You can now share your referral link.');
    }

    /**
     * Show the success and sharing page.
     */
    public function success($code)
    {
        $aboutDetails = SuperAboutusModel::get();
        $reffer = Reffer::where('referral_code', $code)->firstOrFail();

        // Generate the unique referral link
        $referralLink = route('reffer.referred', ['code' => $reffer->referral_code]);

        // Uniform message
        $whatsappMessage = "Doctorwala reffering to get 20 rupees, more reffral more money. Join here: " . $referralLink;

        return view('reffer.index', compact('aboutDetails', 'reffer', 'referralLink', 'whatsappMessage'));
    }
}
