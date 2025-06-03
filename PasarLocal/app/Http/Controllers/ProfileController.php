<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if authenticated user is a valid User model instance
        if (!($user instanceof \App\Models\User)) {
            abort(403, 'Invalid user object'); // Provide a slightly different error for clarity
        }

        if ($user->role === 'customer') {
            return view('customer.profile.edit', compact('user'));
        } elseif ($user->role === 'pedagang') {
            return view('pedagang.profile.edit', compact('user'));
        }
        return redirect('/')->with('error', 'Halaman edit profil hanya untuk customer atau pedagang.');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user || !($user instanceof \App\Models\User)) {
            abort(403, 'Unauthorized access');
        }

        if ($user->role === 'customer') {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'nomor_telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string|max:255',
                'kecamatan' => 'required|string|max:100',
                'profile_image' => 'nullable|image|max:2048',
            ]);
        } elseif ($user->role === 'pedagang') {
            $validated = $request->validate([
                'nama_pemilik' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'nomor_telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string|max:255',
                'nama_toko' => 'nullable|string|max:255',
                'profile_image' => 'nullable|image|max:2048',
            ]);
        } else {
            abort(403, 'Unauthorized access');
        }

        // Update user data based on role
        if ($user->role === 'customer') {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->nomor_telepon = $validated['nomor_telepon'] ?? null;
            $user->alamat = $validated['alamat'] ?? null;
            $user->kecamatan = $validated['kecamatan'];

            // Handle password update if provided
            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            // Handle profile image update if provided for customer
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image && file_exists(public_path('profil_customer/' . $user->profile_image))) {
                    unlink(public_path('profil_customer/' . $user->profile_image));
                }
                $image = $request->file('profile_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profil_customer'), $imageName);
                $user->profile_image = $imageName;
            }

        } elseif ($user->role === 'pedagang') {
            $user->nama_pemilik = $validated['nama_pemilik'];
            $user->email = $validated['email'];
            $user->nomor_telepon = $validated['nomor_telepon'] ?? null;
            $user->alamat = $validated['alamat'] ?? null;
            $user->nama_toko = $validated['nama_toko'] ?? null;

            // Handle password update if provided
            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            // Handle profile image update if provided for pedagang
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image && file_exists(public_path('profil_pedagang/' . $user->profile_image))) {
                    unlink(public_path('profil_pedagang/' . $user->profile_image));
                }
                $image = $request->file('profile_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profil_pedagang'), $imageName);
                $user->profile_image = $imageName;
            }
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($user->role === 'customer') {
            return view('customer.profile.show', compact('user'));
        } elseif ($user->role === 'pedagang') {
            return view('pedagang.profile.show', compact('user'));
        }
        return redirect('/')->with('error', 'Halaman profil hanya untuk customer atau pedagang.');
    }

}