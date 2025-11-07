<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .info-box {
            background-color: white;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
        }
        .info-row {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 150px;
        }
        .value {
            color: #333;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Selamat Datang!</h1>
    </div>
    
    <div class="content">
        <h2>Halo, {{ $user['name']}}!</h2>
        <p>Terima kasih telah mendaftar di aplikasi kami. Akun Anda telah berhasil dibuat.</p>
        
        <div class="info-box">
            <h3>Informasi Akun Anda:</h3>
            
            <div class="info-row">
                <span class="label">Nama:</span>
                <span class="value">{{ $user['name'] }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">{{ $user['email'] }}</span>
            </div>
            
            @if(isset($user['username']))
            <div class="info-row">
                <span class="label">Username:</span>
                <span class="value">{{ $user['username'] }}</span>
            </div>
            @endif
            
            @if(isset($user['phone']))
            <div class="info-row">
                <span class="label">No. Telepon:</span>
                <span class="value">{{ $user['phone'] }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Tanggal Registrasi:</span>
                <span class="value">{{ date('d F Y, H:i') }}</span>
            </div>
        </div>
        
        <p>Anda sekarang dapat login ke aplikasi menggunakan email dan password yang telah Anda daftarkan.</p>
        
        <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami.</p>
        
        <p>Salam hangat,<br>
        <strong>Tim Aplikasi</strong></p>
    </div>
    
    <div class="footer">
        <p>&copy; 2024 Aplikasi Web. All rights reserved.</p>
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>