<?php
// Mengimpor file koneksi database
require_once __DIR__ . '/../koneksi.php';

// Mengecek apakah request berasal dari form POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mengamankan input pengguna dari XSS
    $nama = htmlspecialchars($_POST['nama']);
    $detail = htmlspecialchars($_POST['detail']);
    $kategori_id = intval($_POST['kategori_id']);

    // Mengambil informasi file yang diupload
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $path = "../uploads/" . basename($foto);

    // Memindahkan file ke folder uploads jika berhasil diupload
    if (move_uploaded_file($tmp, $path)) {
        // Menyimpan data produk ke database
        mysqli_query($conn, "INSERT INTO produk (kategori_id, nama, foto, detail) 
            VALUES ($kategori_id, '$nama', '$foto', '$detail')");
        // Redirect ke halaman index setelah berhasil
        header("Location: index.php");
        exit;
    } else {
        // Menampilkan pesan error jika upload gagal
        echo "<div class='alert alert-danger'>Gagal upload gambar.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata dan referensi CSS -->
    <meta charset="UTF-8" />
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Gaya halaman form */
        body {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-container {
            background: #fff;
            border-radius: 15px;
            padding: 2.5rem;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
        }

        h3 {
            color: #4a4a4a;
            margin-bottom: 1.5rem;
            font-weight: 700;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #555;
        }

        input.form-control,
        textarea.form-control {
            border-radius: 12px;
            box-shadow: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input.form-control:focus,
        textarea.form-control:focus {
            border-color: #5a67d8;
            box-shadow: 0 0 8px rgba(90, 103, 216, 0.5);
        }

        button.btn-primary {
            background-color: #5a67d8;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            box-shadow: 0 5px 15px rgba(90, 103, 216, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button.btn-primary:hover {
            background-color: #434190;
            box-shadow: 0 8px 20px rgba(67, 65, 144, 0.7);
        }
    </style>
</head>

<body>
    <!-- Form untuk menambah produk baru -->
    <form method="POST" enctype="multipart/form-data" class="form-container shadow-sm">
        <h3>Tambah Produk</h3>

        <!-- Input nama produk -->
        <div class="mb-4">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama produk" required />
        </div>

        <!-- Input deskripsi produk -->
        <div class="mb-4">
            <label for="detail" class="form-label">Deskripsi</label>
            <textarea name="detail" id="detail" class="form-control" rows="4" placeholder="Masukkan deskripsi produk" required></textarea>
        </div>

        <!-- Input kategori ID -->
        <div class="mb-4">
            <label for="kategori_id" class="form-label">Kategori ID</label>
            <input type="number" name="kategori_id" id="kategori_id" class="form-control" placeholder="Masukkan kategori ID" required />
        </div>

        <!-- Input upload gambar produk -->
        <div class="mb-4">
            <label for="foto" class="form-label">Gambar Produk</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required />
        </div>

        <!-- Tombol submit -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Simpan Produk</button>
        </div>
    </form>
</body>

</html>