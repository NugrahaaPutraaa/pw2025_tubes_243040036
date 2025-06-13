<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Akun</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font dari Google  -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        /* Gaya dasar body: kasih font kece + gradasi warna yang mencolok */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, rgb(36, 238, 245), rgb(241, 24, 234));
            color: #333;
            margin: 0;
        }

        /* Biar form register ada di tengah layar */
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Box buat form-nya, kasih padding & bayangan */
        .register-box {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgb(10, 10, 220);
            width: 100%;
            max-width: 480px;
            animation: fadeIn 1s ease;
            /* Animasi masuk */
        }

        /* Efek animasi pas form muncul */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Judul form */
        h3 {
            font-weight: 600;
            margin-bottom: 25px;
            color: #4b6cb7;
        }

        /* Label input biar jelas */
        .form-label {
            font-weight: 500;
            color: #333;
        }

        /* Style input form */
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            font-size: 15px;
        }

        /* Tombol daftar yang warna-warni */
        .btn-primary {
            background: linear-gradient(to right, rgb(240, 31, 248), rgb(42, 249, 242));
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        /* Tombol ke halaman login */
        .btn-outline-secondary {
            border-radius: 10px;
            margin-top: 10px;
        }

        /* Style alert kalau ada error */
        .alert {
            border-radius: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <!-- Container utama buat form register -->
    <div class="container register-container">
        <div class="register-box">
            <h3 class="text-center">Daftar Akun Baru</h3>

            <!-- Ini muncul kalau ada error dari PHP -->
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Form register -->
            <form action="" method="post">
                <!-- Input username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Nama Pengguna</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <!-- Input password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <!-- Ulangi password buat verifikasi -->
                <div class="mb-3">
                    <label for="password2" class="form-label">Ulangi Kata Sandi</label>
                    <input type="password" name="password2" id="password2" class="form-control" required>
                </div>

                <!-- Tombol daftar -->
                <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>

                <!-- Link buat balik ke halaman login -->
                <a href="login.php" class="btn btn-outline-secondary w-100">Sudah punya akun? Login</a>
            </form>
        </div>
    </div>

</body>

</html>