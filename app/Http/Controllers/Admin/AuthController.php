<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || $user->role !== 'admin') {
            return back()->withErrors(['email' => __('admin.invalid_credentials')])->withInput();
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', __('admin.welcome_back'));
        }

        return back()->withErrors(['email' => __('admin.invalid_credentials')])->withInput();
    }

    /**
     * Show password reset request form
     */
    public function showPasswordResetForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->where('role', 'admin')->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No admin account found with this email.'])->withInput();
        }

        // Generate token and store it
        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // In production, send email here with reset link
        // For now, we'll return the token in the response (remove this in production!)
        $resetUrl = route('admin.password.reset', ['token' => $token, 'email' => $request->email]);
        
        // TODO: Send email with $resetUrl
        // Mail::to($user->email)->send(new AdminPasswordResetMail($resetUrl));
        
        return back()->with('success', __('admin.password_reset_link_generated', ['url' => $resetUrl]));
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request, $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->where('role', 'admin')->first();

        if (!$user) {
            return back()->withErrors(['email' => __('admin.no_admin_account')])->withInput();
        }

        // Check if token exists and is valid
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.'])->withInput();
        }

        // Check if token matches
        $tokenValid = Hash::check($request->token, $passwordReset->token);

        if (!$tokenValid) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.'])->withInput();
        }

        // Check if token is not expired (60 minutes)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return back()->withErrors(['email' => 'Reset token has expired. Please request a new one.'])->withInput();
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('admin.login')->with('success', __('admin.password_reset_success'));
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', __('admin.logged_out'));
    }
}
