<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PasarLocal</title>
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

        .register-container {
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
        }

        .divider {
            text-align: center;
            color: white;
            margin: 20px 0;
            font-size: 14px;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .social-btn {
            background: white;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .social-btn img {
            height: 24px;
        }

        .login-btn {
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
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="PasarLocal">
    </div>

    <div class="register-container">
        <h1>REGISTER</h1>

        <form method="POST" action="{{ route('auth.register') }}">
            @csrf

            {{-- Nama --}}
            <div class="form-group">
                <input type="text" name="name" placeholder="Username" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="form-group">
                <input type="text" name="alamat" placeholder="Alamat" required>
                @error('alamat')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="form-group">
                <input type="text" name="nomor_telepon" placeholder="nomor_telepon" required>
                @error('nomor_telepon')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <input type="password" name="password" placeholder="Password Baru" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Masukkan Ulang Password Baru" required>
            </div>

            <button type="submit" class="login-btn">Register</button>
        </form>
    </div>
</body>
</html>
