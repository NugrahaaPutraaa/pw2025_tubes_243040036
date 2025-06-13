<?php
// Mengimpor file koneksi ke database
require_once __DIR__ . '/../koneksi.php';

// Mengambil ID produk dari parameter URL
$id = $_GET['id'];

// Mengambil data produk dari database berdasarkan ID
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id = $id"));

// Jika data produk ditemukan
if ($data) {
    // Jika produk memiliki foto, hapus file foto dari folder uploads
    if ($data['foto']) {
        unlink("../uploads/" . $data['foto']);
    }

    // Hapus data produk dari database
    mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
}

// Redirect ke halaman index setelah proses penghapusan
header("Location: index.php");
