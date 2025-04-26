<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .code {
            text-align: center;
            font-size: 32px;
            letter-spacing: 5px;
            background: #f5f5f5;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Kode Verifikasi PasarLocal</h2>
        </div>

        <p>Halo,</p>
        
        <p>Berikut adalah kode verifikasi Anda:</p>

        <div class="code">
            {{ $code }}
        </div>

        <p>Kode ini akan kadaluarsa dalam 10 menit.</p>
        
        <p>Jika Anda tidak meminta kode verifikasi ini, Anda dapat mengabaikan email ini.</p>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} PasarLocal. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 