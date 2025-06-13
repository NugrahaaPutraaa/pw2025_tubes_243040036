<?php
// Mengimpor koneksi database
require_once __DIR__ . '/../koneksi.php';

// Mengambil semua produk kategori "Lukisan" (kategori_id = 1), urut dari terbaru
$lukisan = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id = 1 ORDER BY id DESC");

// Mengambil semua produk kategori "Patung" (kategori_id = 2), urut dari terbaru
$patung = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id = 2 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Metadata dan pemanggilan Bootstrap & Google Fonts -->
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Gaya tampilan halaman -->
    <style>
        /* Styling umum untuk body */
        body {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            font-family: 'Poppins', sans-serif;
        }

        .container {
            padding: 3rem 1.5rem;
        }

        /* Header yang menempel di atas */
        header.sticky-header {
            background: #0f172a;
            color: white;
            padding: 1.2rem 2rem;
            border-radius: 16px;
            margin-bottom: 3rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
        }

        /* Judul kategori */
        .kategori-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.2rem;
            border-left: 5px solid #fbbf24;
            padding-left: 12px;
        }

        /* Gaya kartu produk */
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 230px;
            object-fit: cover;
        }

        .card-body {
            background-color: #ffffff;
            padding: 1.5rem;
            border-top: 1px solid #f1f5f9;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #0f172a;
        }

        .card-text {
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 0.5rem;
            height: 4.2em;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Gaya tombol */
        .btn-warning {
            background-color: #f59e0b;
            border: none;
        }

        .btn-danger {
            background-color: #ef4444;
            border: none;
        }

        .btn {
            font-size: 0.9rem;
            border-radius: 10px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-success {
            background-color: #16a34a;
            border: none;
        }

        .text-muted {
            font-style: italic;
            padding-left: 0.5rem;
        }

        footer {
            text-align: center;
            margin-top: 4rem;
            font-size: 0.85rem;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header halaman berisi judul dan tombol navigasi -->
        <header class="sticky-header d-flex justify-content-between align-items-center">
            <h2>Daftar Produk Galeri</h2>
            <div class="d-flex align-items-center">
                <a href="tambah.php" class="btn btn-success me-2">Tambah Produk</a>
                <a href="#" class="btn btn-outline-light me-2" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </a>
                <a href="../logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </header>
        </header>

        <!-- Konten utama -->
        <main>
            <div class="row">
                <!-- Kolom untuk kategori Lukisan -->
                <div class="col-md-6">
                    <h3 class="kategori-title">Lukisan</h3>
                    <div class="row g-4">
                        <!-- Jika ada data lukisan -->
                        <?php if ($lukisan && mysqli_num_rows($lukisan) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($lukisan)): ?>
                                <div class="col-12">
                                    <div class="card h-100">
                                        <!-- Gambar produk -->
                                        <img src="../uploads/<?= htmlspecialchars($row['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']) ?>">

                                        <!-- Detail produk -->
                                        <div class="card-body d-flex flex-column">
                                            <h3 class="card-title"><?= htmlspecialchars($row['nama']) ?></h3>
                                            <p class="card-text"><?= htmlspecialchars($row['detail']) ?></p>

                                            <!-- Tombol edit dan hapus -->
                                            <div class="mt-auto d-flex justify-content-between">
                                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <!-- Jika tidak ada produk -->
                            <p class="text-muted">Belum ada produk Lukisan.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Kolom untuk kategori Patung -->
                <div class="col-md-6">
                    <h3 class="kategori-title">Patung</h3>
                    <div class="row g-4">
                        <!-- Jika ada data patung -->
                        <?php if ($patung && mysqli_num_rows($patung) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($patung)): ?>
                                <div class="col-12">
                                    <div class="card h-100">
                                        <!-- Gambar produk -->
                                        <img src="../uploads/<?= htmlspecialchars($row['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']) ?>">

                                        <!-- Detail produk -->
                                        <div class="card-body d-flex flex-column">
                                            <h3 class="card-title"><?= htmlspecialchars($row['nama']) ?></h3>
                                            <p class="card-text"><?= htmlspecialchars($row['detail']) ?></p>

                                            <!-- Tombol edit dan hapus -->
                                            <div class="mt-auto d-flex justify-content-between">
                                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <!-- Jika tidak ada produk -->
                            <p class="text-muted">Belum ada produk Patung.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-5">© <?= date("Y") ?> Galeri Seni | RyukaaArt</footer>
    </div>
</body>

</html>