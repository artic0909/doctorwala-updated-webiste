<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Auth;
use App\Models\DwUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;

class DwUserController extends Controller
{
    protected $guard = 'dwuser';

    public function viewUserLogForm()
    {
        // return view('authentication');
        $captcha = $this->generateCaptcha();
        session(['captcha_text' => $captcha]);

        return view('authentication', compact('captcha'));
    }

    private function generateCaptcha()
    {
        $chars = 'ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789';
        $captcha = '';
        for ($i = 0; $i < 6; $i++) {
            $captcha .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $captcha;
    }

    public function userRegForm(Request $request)
    {
        $validated = $request->validate([
            'user_name'     => 'required|string|max:255',
            'user_mobile'   => 'required|string|max:255',
            'user_city'     => 'required|string|max:255',
            'user_email'    => 'required|string|email|max:255',
            'user_password' => 'required|string',
        ]);

        try {

            // ── Serial number: count users registered in current year ──────────
            $currentYear      = now()->format('Y');   // e.g. 2026
            $currentYearShort = now()->format('y');   // e.g. 26

            $serial = DwUserModel::whereYear('created_at', $currentYear)->count() + 1;

            // ── 1. memberid  →  DW-2026-001 / DW-2026-010 / DW-2026-100 ───────
            $paddedSerial = str_pad($serial, 3, '0', STR_PAD_LEFT);
            $memberId     = 'DW-' . $currentYear . '-' . $paddedSerial;

            // ── 2. medical_card_no  →  DW26 4866 01 ────────────────────────────
            $last4Mobile   = substr(preg_replace('/\D/', '', $request->user_mobile), -4);
            $cardSerial    = str_pad($serial, 2, '0', STR_PAD_LEFT);
            $medicalCardNo = 'DW' . $currentYearShort . ' ' . $last4Mobile . ' ' . $cardSerial;

            // ── Save ────────────────────────────────────────────────────────────
            $dwuser                  = new DwUserModel($validated);
            $dwuser->user_password   = bcrypt($request->user_password);
            $dwuser->memberid        = $memberId;
            $dwuser->medical_card_no = $medicalCardNo;

            $dwuser->save();

            return redirect()->route('dw.user-auth')
                ->with('success', 'Registration successful! Please log in.');
        } catch (\Illuminate\Database\QueryException $e) {

            // Duplicate email / mobile or any DB constraint violation
            return redirect()->back()
                ->withInput()
                ->with('error', 'This email or mobile number is already registered. Please try again.');
        } catch (\Exception $e) {

            // Any other unexpected error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function generateMedicalCard()
    {
        try {

            $user = Auth::guard('dwuser')->user();

            // Already has card — no need to regenerate
            if ($user->medical_card_no && $user->memberid) {
                return back()->with('info', 'Medical card already exists.');
            }

            $currentYear      = now()->format('Y');
            $currentYearShort = now()->format('y');

            // Serial: count users of this year who already have a card
            $serial = DwUserModel::whereYear('created_at', $currentYear)
                ->whereNotNull('medical_card_no')
                ->count() + 1;

            // ── 1. memberid  →  DW-2026-001 ───────────────────────────────────
            $memberId = 'DW-' . $currentYear . '-' . str_pad($serial, 3, '0', STR_PAD_LEFT);

            // ── 2. medical_card_no  →  DW26 4866 01 ───────────────────────────
            $last4Mobile   = substr(preg_replace('/\D/', '', $user->user_mobile), -4);
            $medicalCardNo = 'DW' . $currentYearShort . ' ' . $last4Mobile . ' ' . str_pad($serial, 2, '0', STR_PAD_LEFT);

            // ── Save ───────────────────────────────────────────────────────────
            DB::table('dw_user_models')
                ->where('id', $user->id)
                ->update([
                    'memberid'        => $memberId,
                    'medical_card_no' => $medicalCardNo,
                ]);

            return back()->with('success', 'Medical card created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function userLogin(Request $request)
    {
        // Validate the login credentials
        $validated = $request->validate([
            'user_email' => 'required|email',
            'user_password' => 'required',
        ]);

        // Check if captcha matches the one in session
        if ($request->captcha !== session('captcha_text')) {
            return back()->withErrors(['captcha' => 'Captcha is incorrect.'])->withInput();
        }

        // Prepare credentials array
        $credentials = [
            'user_email' => $request->user_email,
            'password' => $request->user_password, // Must use 'password' key for Auth
        ];

        // Attempt login using the dwuser guard
        if (Auth::guard('dwuser')->attempt($credentials)) {
            // Login successful
            $request->session()->regenerate();
            $intended = session()->pull('url.intended');

            // Only honour it if it starts with /dw/
            if ($intended && str_starts_with(parse_url($intended, PHP_URL_PATH), '/dw/')) {
                return redirect($intended)->with('success', 'Login successful! You are now logged in.');
            }

            return redirect()->route('dw.opd')->with('success', 'Login successful! You are now logged in.');
        }

        // Login failed
        return back()->withErrors([
            'user_email' => 'Invalid credentials. Please try again.',
        ]);
    }

    public function userlogout(Request $request)
    {
        Auth::guard('dwuser')->logout();
        // $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
