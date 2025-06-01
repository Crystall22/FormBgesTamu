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
        // Define credentials for all roles, including the 3 types of management
        $credentials = [
            'receptionist' => ['username' => 'receptionist', 'password' => 'reception123'],
            'secretary' => ['username' => 'secretary', 'password' => 'secretary123'],
            'management_business' => ['username' => 'business', 'password' => '123'],
            'management_government' => ['username' => 'gov', 'password' => '123'],
            'management_enterprise' => ['username' => 'enter', 'password' => '123'],
            'security' => ['username' => 'security', 'password' => 'security123'],
        ];

        $input = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Clear existing session data
        Session::flush();

        // Check each role, including management types
        if ($input['username'] === $credentials['receptionist']['username'] && $input['password'] === $credentials['receptionist']['password']) {
            Session::put('role', 'receptionist');
            return redirect()->route('form.create')->with('success', 'Welcome Receptionist!');
        }

        if ($input['username'] === $credentials['secretary']['username'] && $input['password'] === $credentials['secretary']['password']) {
            Session::put('role', 'secretary');
            return redirect()->route('secretariat.dashboard')->with('success', 'Welcome Secretary!');
        }

        if ($input['username'] === $credentials['management_business']['username'] && $input['password'] === $credentials['management_business']['password']) {
            Session::put('role', 'management');
            Session::put('management_type', 'business');
            return redirect()->route('management.dashboard', 'business')->with('success', 'Welcome Business Management!');
        }

        if ($input['username'] === $credentials['management_government']['username'] && $input['password'] === $credentials['management_government']['password']) {
            Session::put('role', 'management');
            Session::put('management_type', 'government');
            return redirect()->route('management.dashboard', 'government')->with('success', 'Welcome Government Management!');
        }

        if ($input['username'] === $credentials['management_enterprise']['username'] && $input['password'] === $credentials['management_enterprise']['password']) {
            Session::put('role', 'management');
            Session::put('management_type', 'enterprise');
            return redirect()->route('management.dashboard', 'enterprise')->with('success', 'Welcome Enterprise Management!');
        }

        if ($input['username'] === $credentials['security']['username'] && $input['password'] === $credentials['security']['password']) {
            Session::put('role', 'security');
            return redirect()->route('parkings.index')->with('success', 'Welcome Security!');
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
