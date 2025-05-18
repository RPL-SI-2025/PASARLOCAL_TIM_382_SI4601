<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\VerificationService;

class AuthController extends Controller
{
    protected $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function showLoginForm()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

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
            'role'     => 'required|in:customer,pedagang,pembeli',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect('/')->with('success', 'Registration successful! Please login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // 1. Khusus untuk admin hardcoded
        if ($request->email === 'pasarlocal382@gmail.com' && $request->password === 'p4sarl0c4l123') {
            if (!$user) {
                // Buat user admin jika belum ada
                $user = User::create([
                    'name'     => 'Admin PasarLocal',
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role'     => 'admin',
                ]);
            }

            Auth::login($user);
            return redirect()->route('admin.manajemen-produk.index');
        }

        // 2. Untuk user biasa
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return $this->redirectBasedOnRole($user->role);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    protected function redirectBasedOnRole($role)
    {
        return match ($role) {
            'admin'    => redirect()->route('admin.manajemen-produk.index'),
            'pedagang' => redirect()->route('pedagang.dashboard'),
            'pembeli', 'customer' => redirect()->route('customer.index'),
            default    => redirect('/'),
        };
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('verification_email');
        return redirect('/');
    }
}
