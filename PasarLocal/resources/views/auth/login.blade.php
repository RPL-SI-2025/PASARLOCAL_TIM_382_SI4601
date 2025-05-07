<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PasarLocal</title>
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

        .login-container {
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

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: white;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="PasarLocal">
    </div>

    <div class="login-container">
        <h1>LOGIN</h1>

        @if (session('success'))
            <div style="background-color: #4BB543; color: white; padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.login') }}">
            @csrf

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <select name="role" required style="width: 100%; padding: 12px; border: none; border-radius: 25px; font-size: 16px; background-color: white;" dusk="role-select">
                    <option value="">-- Login Sebagai --</option>
                    <option value="customer">Customer</option>
                    <option value="pedagang">Pedagang</option>
                </select>
                @error('role')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-btn" dusk='login'>Log in</button>

            <div class="register-link">
                <a href="{{ route('auth.register.form') }}">Don't have an account? Register here</a>
            </div>
        </form>
    </div>
</body>
</html>
