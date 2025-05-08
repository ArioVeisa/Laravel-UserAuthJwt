<!DOCTYPE html>
<html>
<head>
    <title>Login Berhasil - OrderIt</title>
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
            text-align: center;
            padding: 20px 0;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-box {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Login Berhasil</h1>
    </div>
    
    <div class="content">
        <h2>Halo {{ $user->name }},</h2>
        <p>Kami mendeteksi login baru ke akun OrderIt Anda.</p>
        
        <div class="info-box">
            <p><strong>Detail Login:</strong></p>
            <p>Waktu: {{ $time }}</p>
            <p>IP Address: {{ $ip }}</p>
        </div>
        
        <p>Jika ini adalah Anda, Anda dapat mengabaikan email ini.</p>
        
        <p>Jika Anda tidak melakukan login ini, segera hubungi tim dukungan kami untuk bantuan lebih lanjut.</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        <p>Terima kasih,<br>Tim OrderIt</p>
    </div>
</body>
</html> 