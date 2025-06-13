<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Set karakter dan supaya tampilannya responsif di semua device -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Judul halaman di tab browser -->
    <title>Landing Pages</title>

    <style>
        /* Import font Montserrat dari Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap');

        /* Reset default styling biar nggak aneh-aneh */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Set body supaya full screen dan pakai font yang udah di-import */
        html,
        body {
            height: 100%;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
            overflow: hidden;
            /* Supaya nggak bisa scroll */
            position: relative;
        }

        /* Video background di-set full layar dan di belakang semua elemen */
        #bg-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
            object-position: center;
            filter: brightness(0.4);
            /* Biar teks di atasnya tetap jelas */
        }

        /* Konten utama yang ditampilkan di atas video */
        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #fff;
            padding: 20px;
            z-index: 1;
        }

        /* Judul utama */
        h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        }

        /* Paragraf pengantar */
        p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            color: #eee;
            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.7);
        }

        /* Tombol login */
        a {
            background: linear-gradient(90deg, #f39c12, #e74c3c);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.6);
            transition: all 0.3s ease;
        }

        /* Efek saat hover tombol */
        a:hover {
            background: linear-gradient(90deg, #e74c3c, #f39c12);
            box-shadow: 0 8px 20px rgba(243, 156, 18, 0.8);
            transform: scale(1.05);
        }

        /* Responsive layout untuk layar kecil */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }

            a {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Video sebagai background -->
    <video autoplay muted loop id="bg-video">
        <source src="j.mp4" type="video/mp4">
        <!-- Fallback kalau browser nggak support video -->
        Browser Anda tidak mendukung video tag.
    </video>

    <!-- Konten yang muncul di atas video -->
    <div class="content">
        <h1>Selamat datang di Website RyukaaArt!</h1>
        <p>Silakan login untuk melanjutkan.</p>
        <a href="login.php">Masuk / Login</a>
    </div>
</body>

</html>