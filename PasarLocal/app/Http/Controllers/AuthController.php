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
            'role' => 'required'
        ]);

        // Jika email dan password adalah admin
        if ($credentials['email'] === 'pasarlocal382@gmail.com' && $credentials['password'] === 'p4sarl0c4l123') {
            // Generate dan kirim kode verifikasi
            $this->verificationService->generateCode($credentials['email']);
            
            // Simpan email ke session
            session(['verification_email' => $credentials['email']]);
            
            // Redirect ke halaman verifikasi
            return redirect()->route('auth.show-verify-code');
        }

        // Untuk user biasa
        if (Auth::attempt($credentials)) {
            // Redirect berdasarkan role
            if ($credentials['role'] === 'pedagang') {
                return redirect()->route('pedagang.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function showVerifyCodeForm()
    {
        // Ambil email dari session
        $email = session('verification_email');
        
        if (!$email) {
            return redirect()->route('auth.login.form')->with('error', 'Sesi verifikasi telah berakhir. Silakan login kembali.');
        }

        return view('auth.verify-code', ['email' => $email]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        if ($this->verificationService->verifyCode($request->email, $request->code)) {
            // Bersihkan session verifikasi
            session()->forget('verification_email');
            
            // Login sebagai admin
            $admin = User::where('email', $request->email)->first();
            if (!$admin) {
                // Jika admin belum ada, buat user admin
                $admin = User::create([
                    'name' => 'Admin PasarLocal',
                    'email' => $request->email,
                    'password' => Hash::make('p4sarl0c4l123'),
                    'role' => 'admin'
                ]);
            }
            
            Auth::login($admin);
            return redirect()->route('admin.manajemen-produk.index');
        }

        return back()->with('error', 'Kode verifikasi tidak valid atau sudah kadaluarsa.');
    }

    public function resendCode(Request $request)
    {
        $email = $request->query('email') ?? session('verification_email');
        
        if (!$email) {
            return redirect()->route('auth.login.form')
                ->with('error', 'Sesi verifikasi telah berakhir. Silakan login kembali.');
        }

        $this->verificationService->generateCode($email);
        return back()->with('success', 'Kode verifikasi baru telah dikirim.');
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('verification_email');
        return redirect('/');
    }
}
