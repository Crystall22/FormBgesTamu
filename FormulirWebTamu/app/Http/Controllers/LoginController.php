<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function loginForm(Request $request)
    {
        return view('auth/login');
    }

    public function authenticate(Request $request)
    {
        $credentials = [
            'receptionist' => ['username' => 'receptionist', 'password' => 'reception123'],
            'secretary' => ['username' => 'secretary', 'password' => 'secretary123'],
            'management' => ['username' => 'management', 'password' => 'management123'],
        ];

        $input = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        Session::flush(); // Clear any existing session data to prevent multiple logins

        if (
            $input['username'] === $credentials['receptionist']['username'] &&
            $input['password'] === $credentials['receptionist']['password']
        ) {
            Session::put('role', 'receptionist');
            return redirect()->route('form.create')->with('success', 'Welcome Receptionist!');
        }

        if (
            $input['username'] === $credentials['secretary']['username'] &&
            $input['password'] === $credentials['secretary']['password']
        ) {
            Session::put('role', 'secretary');
            return redirect()->route('secretary.dashboard')->with('success', 'Welcome Secretary!');
        }

        if (
            $input['username'] === $credentials['management']['username'] &&
            $input['password'] === $credentials['management']['password']
        ) {
            Session::put('role', 'management');
            return redirect()->route('management.dashboard')->with('success', 'Welcome Management!');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
