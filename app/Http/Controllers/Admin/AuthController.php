<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    /**
     * Max failed attempts before account lockout.
     */
    protected int $maxAttempts = 5;

    /**
     * Lockout duration in minutes.
     */
    protected int $lockoutMinutes = 30;

    /**
     * Show admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login-standalone');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if account is locked
        if ($user && $user->locked_until && $user->locked_until->isFuture()) {
            $minutes = (int) ceil(now()->diffInMinutes($user->locked_until));

            return back()->withErrors([
                'email' => 'Akun Anda terkunci. Silakan coba lagi dalam ' . $minutes . ' menit.',
            ])->withInput($request->only('email'));
        }

        // Attempt authentication
        if (Auth::guard('admin')->attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        )) {
            // Login success: reset attempts
            if ($user) {
                $user->forceFill([
                    'login_attempts' => 0,
                    'locked_until' => null,
                ])->save();
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Login failed: increment attempts for known user
        if ($user) {
            $user->increment('login_attempts');

            if ($user->login_attempts >= $this->maxAttempts) {
                $user->forceFill([
                    'locked_until' => now()->addMinutes($this->lockoutMinutes),
                ])->save();

                return back()->withErrors([
                    'email' => 'Akun Anda terkunci karena ' . $this->maxAttempts
                        . ' kali percobaan gagal. Silakan coba lagi dalam '
                        . $this->lockoutMinutes . ' menit.',
                ])->withInput($request->only('email'));
            }

            $remaining = $this->maxAttempts - $user->login_attempts;

            return back()->withErrors([
                'email' => 'Email atau password salah. Sisa ' . $remaining . ' percobaan lagi.',
            ])->withInput($request->only('email'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
