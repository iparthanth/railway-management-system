<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SmsService;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $smsService;
    protected $otpService;

    public function __construct(SmsService $smsService, OtpService $otpService)
    {
        $this->smsService = $smsService;
        $this->otpService = $otpService;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'mobile' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean'
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['mobile' => $credentials['mobile'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'mobile' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|unique:users|regex:/^01[3-9]\d{8}$/',
            'nid_number' => 'required|string|unique:users|regex:/^\d{10}$||\d{13}$|\d{17}$/',
            'date_of_birth' => 'required|date|before:today',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'nid_number' => $request->nid_number,
            'date_of_birth' => $request->date_of_birth,
            'nid_verified' => true, // In real app, this would require verification
        ]);

        return view('auth.register-complete', compact('user'));
    }

    public function completeRegistration(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email|unique:users',
            'address' => 'required|string',
            'post_code' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::find($request->user_id);
        $user->update([
            'email' => $request->email,
            'address' => $request->address,
            'post_code' => $request->post_code,
            'password' => $request->password,
        ]);

        // Generate and send OTP
        $otp = $user->generateOtp();
        
        // Send OTP via SMS
        $this->smsService->sendOtp($user->mobile, $otp);
        
        session(['registration_otp' => $otp, 'user_id' => $user->id]);

        return view('auth.verify-otp', compact('user'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:4',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        
        if ($user->verifyOtp($request->otp)) {
            Auth::login($user);
            return redirect('/dashboard')->with('success', 'Registration completed successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
    }

    public function resendOtp(Request $request)
    {
        $user = User::find($request->user_id);
        $otp = $user->generateOtp();
        
        // Send OTP via SMS
        $this->smsService->sendOtp($user->mobile, $otp);
        
        session(['registration_otp' => $otp]);

        return back()->with('success', 'OTP resent successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $recentBookings = $user->bookings()
            ->with(['train', 'fromStation', 'toStation'])
            ->latest()
            ->limit(5)
            ->get();

        return view('auth.dashboard', compact('user', 'recentBookings'));
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required|string',
            'post_code' => 'required|string',
        ]);

        $user->update($request->only(['name', 'email', 'address', 'post_code']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function purchaseHistory()
    {
        $bookings = Auth::user()->bookings()
            ->with(['train', 'fromStation', 'toStation', 'payment'])
            ->latest()
            ->paginate(10);

        return view('auth.purchase-history', compact('bookings'));
    }

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => $request->password]);

        return back()->with('success', 'Password changed successfully!');
    }

    // Password Reset Functionality
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendPasswordResetOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string|exists:users,mobile'
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        
        if (!$this->otpService->canRequestOtp($user, 'password_reset')) {
            return back()->withErrors(['mobile' => 'Please wait before requesting another OTP.']);
        }

        $this->otpService->sendOtp($user, 'password_reset');
        
        session(['password_reset_user_id' => $user->id]);

        return view('auth.reset-password-otp', compact('user'));
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset-password-otp');
    }

    public function verifyPasswordResetOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);
        
        if ($this->otpService->verifyOtp($user, $request->otp, 'password_reset')) {
            // Clear OTP and redirect to new password form
            $this->otpService->clearOtp($user, 'password_reset');
            
            // Generate a secure token for password reset
            $token = Str::random(60);
            session(['password_reset_token' => $token, 'password_reset_user_id' => $user->id]);
            
            return view('auth.new-password', compact('user', 'token'));
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
            'token' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        // Verify the token
        if (session('password_reset_token') !== $request->token || 
            session('password_reset_user_id') != $request->user_id) {
            return redirect()->route('login')->withErrors(['token' => 'Invalid reset token.']);
        }

        $user = User::find($request->user_id);
        $user->update(['password' => $request->password]);
        
        // Clear session data
        session()->forget(['password_reset_token', 'password_reset_user_id']);
        
        // Send notification SMS
        $this->smsService->sendPasswordResetNotification($user->mobile);

        return redirect()->route('login')->with('success', 'Password reset successfully! Please login with your new password.');
    }

    public function resendPasswordResetOtp(Request $request)
    {
        $userId = session('password_reset_user_id');
        if (!$userId) {
            return redirect()->route('forgot.password');
        }

        $user = User::find($userId);
        
        if (!$this->otpService->canRequestOtp($user, 'password_reset')) {
            return back()->withErrors(['otp' => 'Please wait before requesting another OTP.']);
        }

        $this->otpService->sendOtp($user, 'password_reset');

        return back()->with('success', 'OTP resent successfully!');
    }

    // Profile Image Upload
    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();
        
        // Delete old profile image if exists
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image
        $imagePath = $request->file('profile_image')->store('profile-images', 'public');
        
        $user->update(['profile_image' => $imagePath]);

        return back()->with('success', 'Profile image updated successfully!');
    }

    public function deleteProfileImage()
    {
        $user = Auth::user();
        
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->update(['profile_image' => null]);

        return back()->with('success', 'Profile image deleted successfully!');
    }

    // Mobile Verification
    public function showVerifyMobile()
    {
        $user = Auth::user();
        
        if ($user->mobile_verified) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.verify-mobile', compact('user'));
    }

    public function sendMobileVerificationOtp(Request $request)
    {
        $user = Auth::user();
        
        if (!$this->otpService->canRequestOtp($user, 'mobile_verification')) {
            return back()->withErrors(['mobile' => 'Please wait before requesting another OTP.']);
        }

        $this->otpService->sendOtp($user, 'mobile_verification');

        return back()->with('success', 'OTP sent to your mobile number!');
    }

    public function verifyMobileOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $user = Auth::user();
        
        if ($this->otpService->verifyOtp($user, $request->otp, 'mobile_verification')) {
            $this->smsService->sendAccountVerificationSuccess($user->mobile);
            return redirect()->route('dashboard')->with('success', 'Mobile number verified successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
    }

    public function resendMobileVerificationOtp(Request $request)
    {
        $user = Auth::user();
        
        if (!$this->otpService->canRequestOtp($user, 'mobile_verification')) {
            return back()->withErrors(['otp' => 'Please wait before requesting another OTP.']);
        }

        $this->otpService->sendOtp($user, 'mobile_verification');

        return back()->with('success', 'OTP resent successfully!');
    }
}
