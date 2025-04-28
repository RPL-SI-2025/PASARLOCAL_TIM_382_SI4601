<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode - PasarLocal</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .logo img {
            height: 40px;
        }

        .verification-container {
            background-color: #4CAF50;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            box-sizing: border-box;
            font-size: 16px;
            text-align: center;
            letter-spacing: 8px;
            font-size: 24px;
        }

        .verify-btn {
            width: 100%;
            padding: 12px;
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .error-message {
            color: white;
            font-size: 14px;
            margin-top: 5px;
            padding-left: 15px;
        }

        .info-text {
            color: white;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .resend-link {
            text-align: center;
            margin-top: 20px;
        }

        .resend-link a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .resend-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="PasarLocal">
    </div>

    <div class="verification-container">
        <h1>VERIFIKASI KODE</h1>

        <div class="info-text">
            Kode verifikasi telah dikirim ke email Anda.<br>
            Silakan cek email dan masukkan kode di bawah ini.
        </div>

        @if (session('error'))
            <div style="background-color: #ff4444; color: white; padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.verify-code') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="form-group">
                <input type="text" name="code" placeholder="000000" maxlength="6" required 
                       pattern="[0-9]*" inputmode="numeric" autocomplete="off">
                @error('code')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="verify-btn">Verifikasi</button>

            <div class="resend-link">
                <a href="{{ route('auth.resend-code', ['email' => $email]) }}">Kirim ulang kode</a>
            </div>
        </form>
    </div>
</body>
</html> 