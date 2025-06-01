<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
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

        if ($user->role === 'customer') {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'nomor_telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string|max:255',
                'kecamatan' => 'required|string|max:100',
                'profile_image' => 'nullable|image|max:2048',
            ]);
        } elseif ($user->role === 'pedagang') {
            $validated = $request->validate([
                'nama_pemilik' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'nomor_telepon' => 'nullable|string|max:20',
                'alamat' => 'nullable|string|max:255',
                'nama_toko' => 'nullable|string|max:255',
                'profile_image' => 'nullable|image|max:2048',
            ]);
        } else {
            abort(403, 'Unauthorized access');
        }

        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
    public function show()
    {
        $user = auth()->user();
        if ($user->role === 'customer') {
            return view('customer.profile.show');
        } elseif ($user->role === 'pedagang') {
            return view('pedagang.profile.show');
        }
        return redirect('/')->with('error', 'Halaman profil hanya untuk customer atau pedagang.');
    }

}