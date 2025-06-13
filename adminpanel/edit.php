<?php
// Mengimpor koneksi database dari file koneksi.php
require_once __DIR__ . '/../koneksi.php';

// Mengambil ID produk dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Mengambil data produk berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// Jika data produk tidak ditemukan, tampilkan pesan error
if (!$data) {
    die("Produk tidak ditemukan.");
}

// Cek jika form disubmit melalui metode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mengamankan input dari user
    $nama = htmlspecialchars($_POST['nama']);
    $detail = htmlspecialchars($_POST['detail']);
    $kategori_id = intval($_POST['kategori_id']);

    // Jika user mengunggah file foto baru
    if (!empty($_FILES['foto']['name'])) {
        $foto = basename($_FILES['foto']['name']);
        $path = "../uploads/" . $foto;

        // Pindahkan file ke folder uploads
        move_uploaded_file($_FILES['foto']['tmp_name'], $path);

        // Hapus foto lama jika ada
        if (!empty($data['foto'])) {
            @unlink("../uploads/" . $data['foto']);
        }

        // Query untuk update data produk beserta foto
        $sql = "UPDATE produk SET 
                    nama = '$nama', 
                    detail = '$detail', 
                    kategori_id = $kategori_id, 
                    foto = '$foto' 
                WHERE id = $id";
    } else {
        // Query untuk update data produk tanpa mengganti foto
        $sql = "UPDATE produk SET 
                    nama = '$nama', 
                    detail = '$detail', 
                    kategori_id = $kategori_id
                WHERE id = $id";
    }

    // Eksekusi query update
    $result = mysqli_query($conn, $sql);

    // Redirect ke halaman index jika berhasil
    if ($result) {
        header("Location: index.php");
        exit;
    } else {
        // Tampilkan error jika update gagal
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>

    <!-- Import Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style tambahan untuk mempercantik tampilan form -->
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-wrapper {
            max-width: 720px;
            margin: auto;
            background: #fff;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s;
        }

        .form-wrapper:hover {
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        input:focus,
        textarea:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #86b7fe;
        }

        .btn-primary {
            background: #5a67d8;
            border: none;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #434190;
        }

        .preview-wrapper {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
        }

        img.preview {
            width: 100%;
            height: auto;
            max-height: 300px;
            border-radius: 10px;
            object-fit: contain;
            background-color: #f0f0f0;
            padding: 10px;
        }

        h3 {
            color: #2d3748;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="form-wrapper">
            <h3 class="mb-4 text-center">Edit Produk</h3>

            <!-- Form untuk mengedit data produk -->
            <form method="POST" enctype="multipart/form-data">

                <!-- Input untuk nama produk -->
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                </div>

                <!-- Input untuk deskripsi/detail produk -->
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="detail" class="form-control" rows="4" required><?= $data['detail']; ?></textarea>
                </div>

                <!-- Input untuk kategori produk -->
                <div class="mb-3">
                    <label class="form-label">Kategori ID</label>
                    <input type="number" name="kategori_id" class="form-control" value="<?= $data['kategori_id']; ?>" required>
                </div>

                <!-- Menampilkan foto produk saat ini -->
                <div class="mb-3 preview-wrapper">
                    <label class="form-label">Foto Saat Ini</label><br>
                    <?php if ($data['foto']) : ?>
                        <img src="../uploads/<?= $data['foto']; ?>" alt="Foto Produk" class="preview">
                    <?php else : ?>
                        <p class="text-muted mt-2">Belum ada foto produk</p>
                    <?php endif; ?>
                </div>

                <!-- Input untuk mengganti foto produk -->
                <div class="mb-3">
                    <label class="form-label">Ganti Foto (opsional)</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <!-- Tombol untuk menyimpan perubahan -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>