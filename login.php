<?php
// Mulai session, biar bisa simpan data login
session_start();

// Include file koneksi ke database
require "koneksi.php";

// Variabel buat nampung pesan error
$error_msg = '';

// Cek apakah tombol login diklik
if (isset($_POST['loginbtn'])) {
    // Ambil data dari form dan amankan dengan htmlspecialchars
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Cek ke database apakah usernya ada
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $countdata = mysqli_num_rows($query); // Hitung berapa datanya
    $data = mysqli_fetch_array($query); // Ambil datanya

    // Kalau user ditemukan
    if ($countdata > 0) {
        // Cek password-nya bener nggak
        if (password_verify($password, $data['password'])) {
            // Kalau cocok, simpan data ke session
            $_SESSION['username'] = $data['username'];
            $_SESSION['login'] = true;

            // Cek role-nya, biar diarahkan ke halaman yang sesuai
            if ($data['role'] === 'admin') {
                header('Location: adminpanel/index.php'); // Kalau admin
                exit;
            } else {
                header('Location: userpanel/index.php'); // Kalau user biasa
                exit;
            }
        } else {
            // Password salah
            $error_msg = "Password salah";
        }
    } else {
        // Username nggak ditemukan
        $error_msg = "Akun tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Set karakter dan skala tampilan supaya responsif -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Judul tab -->
    <title>Login</title>

    <!-- Pakai Bootstrap buat styling cepat -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Import font dari Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        /* Styling dasar biar layoutnya rapi dan konsisten */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
        }

        /* Background overlay gelap di atas video biar form-nya kebaca */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        /* Container utama buat posisi login box di tengah */
        .login-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Box tempat form login */
        .login-box {
            background: transparent;
            padding: 35px 30px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 340px;
            text-align: center;
            transition: transform 0.4s ease;
            border: 2px solid transparent;
        }

        /* Efek hover biar tampil lebih interaktif */
        .login-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(118, 75, 162, 0.6);
            border-color: rgb(53, 122, 122);
        }

        /* Video background yang nempel di layar */
        #bg-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
            object-position: center;
            filter: brightness(1);
        }

        /* Judul di login form */
        h3 {
            font-weight: 800;
            color: rgb(28, 219, 191);
            margin-bottom: 25px;
            font-size: 2rem;
            letter-spacing: 1.5px;
            text-shadow: 0 1px 4px rgba(28, 225, 239, 0.6);
        }

        /* Label form */
        .form-label {
            font-weight: 600;
            color: #f5f5f5;
            font-size: 1rem;
            text-align: left;
            display: block;
        }

        /* Input styling */
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 1rem;
            border: 2px solid #ccc;
            transition: 0.3s ease;
        }

        .form-control:focus {
            border-color: #764ba2;
            box-shadow: 0 0 12px #764ba2;
            outline: none;
        }

        /* Tombol login */
        .btn-success {
            background: linear-gradient(45deg, rgb(65, 190, 221), #9b59b6);
            border: none;
            font-weight: 700;
            padding: 12px;
            border-radius: 15px;
            font-size: 1.05rem;
            box-shadow: 0 8px 20px rgba(118, 75, 162, 0.6);
            transition: 0.4s ease;
            letter-spacing: 0.05em;
        }

        .btn-success:hover {
            background: linear-gradient(45deg, #5a357a, rgb(48, 216, 214));
            box-shadow: 0 10px 25px rgba(90, 53, 122, 0.75);
        }

        /* Tombol register */
        .btn-outline-primary {
            border-radius: 15px;
            font-weight: 700;
            padding: 10px;
            font-size: 1rem;
            transition: 0.4s ease;
            border: 2px solid rgb(29, 206, 219);
            color: rgb(242, 6, 211);
        }

        .btn-outline-primary:hover {
            background-color: rgb(17, 211, 225);
            color: #fff;
            border-color: rgb(39, 225, 235);
        }

        /* Tampilan alert error */
        .alert {
            border-radius: 15px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 5px 20px rgba(255, 0, 0, 0.15);
            max-width: 320px;
            margin: 25px auto 0 auto;
            background-color: #ffe3e3;
            color: #b30000;
            border: 1.5px solid #b30000;
            letter-spacing: 0.02em;
        }

        /* Responsive buat HP */
        @media (max-width: 480px) {
            .login-box {
                padding: 25px 20px;
            }

            h3 {
                font-size: 1.75rem;
            }

            .btn-success,
            .btn-outline-primary {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Video background -->
    <video autoplay muted loop id="bg-video">
        <source src="L.mp4" type="video/mp4">
        <!-- Buat jaga-jaga kalau browser nggak support video -->
        Browser Anda tidak mendukung video tag.
    </video>

    <!-- Kontainer utama buat form login -->
    <div class="login-container">
        <div class="login-box shadow-sm">
            <h3>Login</h3>
            <!-- Form login -->
            <form action="" method="post" novalidate>
                <!-- Input username -->
                <div class="mb-4 text-start">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus
                        placeholder="Enter your username" />
                </div>
                <!-- Input password -->
                <div class="mb-4 text-start">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required
                        placeholder="Enter your password" />
                </div>
                <!-- Tombol login -->
                <button class="btn btn-success w-100 mb-3" type="submit" name="loginbtn">Login</button>
                <!-- Link ke halaman register -->
                <a href="register.php" class="btn btn-outline-primary w-100">Register</a>
            </form>

            <!-- Tampilkan pesan error kalau ada -->
            <?php if ($error_msg): ?>
                <div class="alert alert-warning mt-4" role="alert"><?= htmlspecialchars($error_msg) ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>