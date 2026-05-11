<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Auth;
use App\Models\DwUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisterWelcomeMail;

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
        $request->validate([
            'user_name'     => 'required|string|max:255',
            'user_mobile'   => 'required|digits:10|unique:dw_user_models,user_mobile',
            'user_city'     => 'required|string|max:255',
            'user_email'    => 'required|email|max:255|unique:dw_user_models,user_email',
            'user_password' => 'required|string|min:8',
        ], [
            'user_name.required'     => 'Full name is required.',
            'user_name.max'          => 'Name must not exceed 255 characters.',
            'user_mobile.required'   => 'Mobile number is required.',
            'user_mobile.digits'     => 'Mobile number must be exactly 10 digits.',
            'user_mobile.unique'     => 'This mobile number is already registered.',
            'user_city.required'     => 'City is required.',
            'user_email.required'    => 'Email address is required.',
            'user_email.email'       => 'Please enter a valid email address.',
            'user_email.unique'      => 'This email is already registered. Please login or use a different email.',
            'user_password.required' => 'Password is required.',
            'user_password.min'      => 'Password must be at least 8 characters.',
        ]);

        try {
            $currentYear      = now()->format('Y');
            $currentYearShort = now()->format('y');

            // Find the last memberid for this year to get the next serial number
            $lastUser = DwUserModel::where('memberid', 'like', "DW-$currentYear-%")
                ->orderBy('memberid', 'desc')
                ->first();

            $serial = 1;
            if ($lastUser && $lastUser->memberid) {
                $parts = explode('-', $lastUser->memberid);
                $lastSerialNum = end($parts);
                if (is_numeric($lastSerialNum)) {
                    $serial = (int)$lastSerialNum + 1;
                }
            }

            $paddedSerial = str_pad($serial, 3, '0', STR_PAD_LEFT);
            $memberId     = 'DW-' . $currentYear . '-' . $paddedSerial;

            $last4Mobile   = substr(preg_replace('/\D/', '', $request->user_mobile), -4);
            $cardSerial    = str_pad($serial, 2, '0', STR_PAD_LEFT);
            $medicalCardNo = 'DW' . $currentYearShort . ' ' . $last4Mobile . ' ' . $cardSerial;

            $dwuser                  = new DwUserModel($request->only(['user_name', 'user_mobile', 'user_city', 'user_email']));
            $dwuser->user_password   = bcrypt($request->user_password);
            $dwuser->memberid        = $memberId;
            $dwuser->medical_card_no = $medicalCardNo;

            $dwuser->save();

            // Send Welcome Email
            try {
                Mail::to($dwuser->user_email)->send(new UserRegisterWelcomeMail($dwuser));
            } catch (\Exception $e) {
                // Log the error or ignore it so registration still succeeds
                \Log::error('Registration Email Error: ' . $e->getMessage());
            }

            return redirect()->route('dw.user-auth')
                ->with('success', 'Registration successful! Your Medical Card ID is ' . $memberId . '. Please log in.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Registration failed: This email, mobile, or Medical ID is already in use.');
        } catch (\Exception $e) {
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
        $request->validate([
            'user_email'    => 'required|email',
            'user_password' => 'required|string',
        ], [
            'user_email.required'    => 'Email address is required.',
            'user_email.email'       => 'Please enter a valid email address.',
            'user_password.required' => 'Password is required.',
        ]);

        $credentials = [
            'user_email' => $request->user_email,
            'password'   => $request->user_password,
        ];

        if (Auth::guard('dwuser')->attempt($credentials)) {
            $request->session()->regenerate();
            $intended = session()->pull('url.intended');

            if ($intended && str_starts_with(parse_url($intended, PHP_URL_PATH), '/dw/')) {
                return redirect($intended)->with('success', 'Login successful! Welcome back.');
            }

            return redirect()->route('dw.opd')->with('success', 'Login successful! Welcome back.');
        }

        return back()->withErrors([
            'user_email' => 'Invalid email or password. Please try again.',
        ])->withInput($request->only('user_email'));
    }

    public function userlogout(Request $request)
    {
        Auth::guard('dwuser')->logout();
        // $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
