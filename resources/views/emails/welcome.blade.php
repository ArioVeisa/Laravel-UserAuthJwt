<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang di OrderIt</title>
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
        <h1>Selamat Datang di OrderIt!</h1>
    </div>
    
    <div class="content">
        <h2>Halo {{ $user->name }},</h2>
        <p>Terima kasih telah bergabung dengan OrderIt. Akun Anda telah berhasil dibuat dengan email: {{ $user->email }}</p>
        
        <p>Dengan OrderIt, Anda dapat:</p>
        <ul>
            <li>Memesan makanan dengan mudah</li>
            <li>Melacak pesanan Anda</li>
            <li>Melihat riwayat pesanan</li>
            <li>Dan banyak lagi!</li>
        </ul>
        
        <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim dukungan kami.</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        <p>Terima kasih,<br>Tim OrderIt</p>
    </div>
</body>
</html> 