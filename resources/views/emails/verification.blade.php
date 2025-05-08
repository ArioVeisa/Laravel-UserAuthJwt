<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email OrderIt</title>
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
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
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
        <h1>Verifikasi Email OrderIt</h1>
    </div>
    
    <div class="content">
        <h2>Halo {{ $user->name }},</h2>
        <p>Terima kasih telah mendaftar di OrderIt. Untuk menyelesaikan proses pendaftaran, silakan verifikasi email Anda dengan mengklik tombol di bawah ini:</p>
        
        <div style="text-align: center;">
            <a href="{{ url('/verify-email/' . $token) }}" class="button">Verifikasi Email</a>
        </div>
        
        <p>Atau Anda dapat menyalin dan menempelkan link berikut di browser Anda:</p>
        <p style="word-break: break-all;">{{ url('/verify-email/' . $token) }}</p>
        
        <p><strong>Catatan:</strong> Link ini akan kadaluarsa dalam 24 jam.</p>
    </div>
    
    <div class="footer">
        <p>Jika Anda tidak merasa mendaftar di OrderIt, Anda dapat mengabaikan email ini.</p>
        <p>Terima kasih,<br>Tim OrderIt</p>
    </div>
</body>
</html> 