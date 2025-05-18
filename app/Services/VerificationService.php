<?php

namespace App\Services;

use App\Models\VerificationCode;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class VerificationService
{
    public function generateCode($email)
    {
        // Hapus kode lama jika ada
        VerificationCode::where('email', $email)->delete();

        // Generate kode baru
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Simpan kode baru
        VerificationCode::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Kirim email
        $this->sendVerificationEmail($email, $code);

        return $code;
    }

    public function verifyCode($email, $code)
    {
        $verificationCode = VerificationCode::where('email', $email)
            ->where('code', $code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$verificationCode) {
            return false;
        }

        // Hapus kode setelah digunakan
        $verificationCode->delete();

        return true;
    }

    private function sendVerificationEmail($email, $code)
    {
        $data = ['code' => $code];
        
        Mail::send('emails.verification-code', $data, function($message) use ($email) {
            $message->to($email)
                    ->subject('Kode Verifikasi PasarLocal');
        });
    }
} 