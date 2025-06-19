<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function loginForm(Request $request)
    {
        return view('auth/login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            // Redirect sesuai role
            if ($user->role === 'receptionist') {
                return redirect()->route('form.create');
            }
            if ($user->role === 'secretary') {
                return redirect()->route('secretary.dashboard');
            }
            if (str_starts_with($user->role, 'management')) {
                // Ambil tipe management dari role, misal: management-business
                $type = explode('-', $user->role)[1] ?? 'business';
                return redirect()->route('management.dashboard', $type);
            }
            if ($user->role === 'security') {
                return redirect()->route('parkings.index');
            }
            return redirect()->route('dashboard');
            if ($user->role === 'customer_service') {
                return redirect()->route('customerservice.index');
            }
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
