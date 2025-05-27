<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pedagang;
use App\Models\Customer;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'pedagang') {
            $profile = Pedagang::where('email', $user->email)->first();
        } else {
            $profile = Customer::where('email', $user->email)->first();
        }
        
        return view('profile.edit', compact('profile', 'role'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'pedagang') {
            $profile = Pedagang::where('email', $user->email)->first();
            
            $validated = $request->validate([
                'nama_pemilik' => 'required|string|max:100',
                'email' => 'required|email|unique:pedagang,email,' . $profile->id_pedagang . ',id_pedagang',
                'nomor_telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:100',
                'nama_toko' => 'required|string|max:100',
                'profile_image' => 'nullable|image|max:2048',
            ]);
        } else {
            $profile = Customer::where('email', $user->email)->first();
            
            $validated = $request->validate([
                'nama_customer' => 'required|string|max:100',
                'email' => 'required|email|unique:customers,email,' . $profile->id . ',id',
                'nomor_telepon' => 'required|string|max:20',
                'alamat' => 'required|string|max:100',
                'profile_image' => 'nullable|image|max:2048',
            ]);
        }

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $profile->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function show()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'pedagang') {
            $profile = Pedagang::where('email', $user->email)->first();
        } else {
            $profile = Customer::where('email', $user->email)->first();
        }
        
        return view('profile.show', compact('profile', 'role'));
    }
}