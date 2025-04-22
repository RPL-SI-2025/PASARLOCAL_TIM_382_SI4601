<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:customer',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect('/auth/login')->with('success', 'Registration successful! Please login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,customer,pedagang'
        ]);

        // Check if user exists with the given email and role
        $user = User::where('email', $request->email)
                    ->where('role', $request->role)
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records for the selected role.',
            ])->onlyInput('email');
        }

        // Attempt to log in with credentials
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on role
            switch($request->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'pedagang':
                    return redirect()->intended('/pedagang/dashboard');
                default:
                    return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login.form');
    }
}
