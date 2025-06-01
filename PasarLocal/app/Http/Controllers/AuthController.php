<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedagang;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\VerificationService;
use Illuminate\Support\Facades\Log;

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
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:6|confirmed',
            'alamat'         => 'required|string|max:100',
            'nomor_telepon'  => 'required|string|max:100',
            'kecamatan'      => 'required|string|max:100',
        ]);

        try {
            // Buat user dulu, simpan ke variabel agar dapat id-nya
            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'role'          => 'customer',
                'alamat'        => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
            ]);

            // Buat customer dengan foreign key user_id mengacu ke $user->id
            Customer::create([
                'user_id'       => $user->id, // ini foreign key ke users.id
                'nama_customer' => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'alamat'        => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
                'kecamatan'     => $request->kecamatan,
            ]);

            return redirect('/')->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            return back()->withErrors(['name' => 'The name is already taken. Please choose a different name.'])->withInput();
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        // Check for admin login
        if ($request->email === 'pasarlocal382@gmail.com') {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'     => 'Admin PasarLocal',
                    'email'    => $request->email,
                    'password' => Hash::make('p4sarl0c4l123'),
                    'role'     => 'admin',
                ]);
            }

            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect()->route('admin.manajemen-produk.index');
            }
        }

        // Check for pedagang login
        $pedagang = Pedagang::where('nama_pemilik', $request->email)
                          ->orWhere('email', $request->email)
                          ->first();

        if ($pedagang) {
            // Check if user exists in users table
            $user = User::where('email', $pedagang->email)->first();

            if (!$user) {
                // Create user account for pedagang if doesn't exist
                $user = User::create([
                    'name'     => $pedagang->nama_pemilik,
                    'email'    => $pedagang->email,
                    'password' => Hash::make($pedagang->password), // Hash the password
                    'role'     => 'pedagang',
                ]);
            }

            // Check password directly since it's not bcrypt
            if ($request->password === $pedagang->password) {
                Auth::login($user);
                return redirect()->route('pedagang.manajemen_produk.index');
            }
        }

        // Check for customer login
        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            // Check if user exists in users table
            $user = User::where('email', $customer->email)->first();

            if (!$user) {
                // Create user account for customer if doesn't exist
                $user = User::create([
                    'name'     => $customer->nama_customer,
                    'email'    => $customer->email,
                    'password' => Hash::make($customer->password), // Hash the password for users table
                    'role'     => 'customer',
                ]);
            }

            // Check password directly since it's not hashed in customers table
            if ($request->password === $customer->password) {
                Auth::login($user);
                return redirect()->route('customer.index');
            }

            if (Auth::check()) {
                Log::info('Middleware jalan untuk user ID: ' . Auth::id());

                Auth::user()->update([
                    'last_seen_at' => Carbon::now(),
                ]);
            } else {
                Log::warning('Auth::check() gagal di middleware');
            }
        }

        // Regular user login
        $user = User::where('email', $request->email)->first();
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
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.manajemen-produk.index');
            case 'pedagang':
                return redirect()->route('pedagang.manajemen_produk.index');
            case 'customer':
                return redirect()->route('customer.index');
            default:
                return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
