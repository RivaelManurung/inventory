<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #f8fafc;
            color: #2d3748;
            text-align: center;
            padding: 10rem 0;
        }
        h1 {
            font-size: 5rem;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        a {
            color: #4299e1;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Halaman yang Anda cari tidak ditemukan</p>
        <a href="{{ url('/') }}">Kembali ke Beranda</a>
    </div>
</body>
</html>