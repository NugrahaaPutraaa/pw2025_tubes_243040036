<?php
// Konfigurasi koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "art";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil parameter kategori dari URL, default 'all'
$kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : 'all';

// Query data produk berdasarkan kategori
if ($kategori_id == 'all') {
    $sql = "SELECT * FROM produk ORDER BY kategori_id ASC, id DESC";
    $result = $conn->query($sql);
} else {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE kategori_id = ? ORDER BY id DESC");
    $stmt->bind_param("s", $kategori_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard Produk</title>

    <!-- Import font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        /* Gaya global dan layout */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1f2937, #111827);
            margin: 0;
            padding: 30px 20px;
            color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Header dan form filter kategori */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1100px;
            width: 100%;
            margin-bottom: 40px;
            padding: 0 15px;
            gap: 15px;
        }

        .kategori-filter {
            flex: 1;
        }

        .kategori-filter label {
            font-weight: 700;
            margin-right: 12px;
            font-size: 1.1rem;
            color: #facc15;
        }

        .kategori-filter select {
            padding: 8px 14px;
            border-radius: 12px;
            border: 2px solid #facc15;
            font-size: 1.1rem;
            background-color: white;
            color: #1e293b;
        }

        .header h1 {
            flex: 1;
            text-align: center;
            font-weight: 900;
            font-size: 2.5rem;
            color: #facc15;
        }

        a.logout-btn {
            background: #ef4444;
            color: white;
            padding: 12px 22px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
        }

        /* Tampilan kategori dan produk */
        .kategori-row {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            width: 100%;
            max-width: 1100px;
            justify-content: center;
            margin-bottom: 60px;
        }

        .kategori-col {
            flex: 1;
            min-width: 320px;
        }

        .kategori-title {
            font-size: 1.8rem;
            font-weight: 900;
            color: #facc15;
            margin-bottom: 20px;
            border-bottom: 3px solid #facc15;
        }

        .produk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .produk-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .produk-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .produk-image {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-bottom: 3px solid #facc15;
            transition: transform 0.4s ease;
            cursor: zoom-in;
        }

        .produk-card:hover .produk-image {
            transform: scale(1.07);
        }

        .produk-info {
            padding: 20px 25px;
        }

        .produk-nama {
            font-size: 1.35rem;
            font-weight: 800;
            color: #fcd34d;
            margin-bottom: 10px;
        }

        .produk-detail {
            font-size: 1rem;
            color: #e5e7eb;
            line-height: 1.5;
            max-height: 4.5em;
            overflow: hidden;
            cursor: pointer;
        }

        .no-produk {
            text-align: center;
            color: #94a3b8;
            font-style: italic;
            font-size: 1.2rem;
            padding: 40px 20px;
        }

        /* Modal tampilan gambar dan detail */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-content {
            max-width: 95vw;
            max-height: 95vh;
            background: transparent;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .modal-content img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 10px;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .modal-description {
            margin-top: 15px;
            padding: 12px 16px;
            background-color: rgba(0, 0, 0, 0.85);
            color: #f1f5f9;
            font-size: 1rem;
            line-height: 1.6;
            border-radius: 10px;
            max-height: 150px;
            overflow-y: auto;
            width: 100%;
            max-width: 700px;
            text-align: center;
        }

        .modal-close {
            position: absolute;
            top: 12px;
            right: 15px;
            font-size: 2rem;
            color: white;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.4);
            padding: 6px 12px;
            border-radius: 10px;
            z-index: 10000;
        }
    </style>
</head>

<body>
    <!-- Bagian Header dan filter -->
    <header class="header">
        <div class="kategori-filter">
            <form method="GET" action="">
                <label for="kategori_id">Pilih Kategori:</label>
                <select name="kategori_id" id="kategori_id" onchange="this.form.submit()">
                    <option value="all" <?= $kategori_id == 'all' ? 'selected' : '' ?>>Semua</option>
                    <option value="1" <?= $kategori_id == '1' ? 'selected' : '' ?>>Lukisan</option>
                    <option value="2" <?= $kategori_id == '2' ? 'selected' : '' ?>>Patung</option>
                </select>
            </form>
        </div>
        <h1>Ryukaaa Art</h1>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </header>

    <!-- Menampilkan produk berdasarkan kategori -->
    <?php
    if ($result && $result->num_rows > 0) {
        $produk_by_kategori = ['1' => [], '2' => []];
        while ($row = $result->fetch_assoc()) {
            $produk_by_kategori[$row['kategori_id']][] = $row;
        }

        $nama_kategori = ['1' => 'Lukisan', '2' => 'Patung'];
        echo "<div class='kategori-row'>";
        foreach ($produk_by_kategori as $kategori => $daftar_produk) {
            if (!empty($daftar_produk)) {
                echo "<div class='kategori-col'>";
                echo "<h2 class='kategori-title'>{$nama_kategori[$kategori]}</h2>";
                echo "<div class='produk-grid'>";
                foreach ($daftar_produk as $row) {
                    $icon = $kategori == '1' ? '🖼️' : '🗿';
    ?>
                    <div class="produk-card">
                        <img src="../uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="produk-image" onclick="openModal('../uploads/<?= htmlspecialchars($row['foto']) ?>', `<?= htmlspecialchars($row['detail'], ENT_QUOTES) ?>`)">
                        <div class="produk-info">
                            <div class="produk-nama"><?= $icon . ' ' . htmlspecialchars($row['nama']) ?></div>
                            <div class="produk-detail" onclick="openModal(null, `<?= htmlspecialchars($row['detail'], ENT_QUOTES) ?>`)"><?= htmlspecialchars($row['detail']) ?></div>
                        </div>
                    </div>
    <?php
                }
                echo "</div></div>";
            }
        }
        echo "</div>";
    } else {
        echo "<p class='no-produk'>Produk tidak ditemukan untuk kategori ini.</p>";
    }
    ?>

    <!-- Modal untuk gambar dan deskripsi -->
    <div class="modal-overlay" id="imageModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <img src="" alt="Preview Produk" id="modalImage">
            <div id="modalDetail" class="modal-description"></div>
        </div>
    </div>

    <!-- Script untuk modal interaktif -->
    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalDetail = document.getElementById('modalDetail');

        function openModal(src = null, detail = '') {
            modal.style.display = 'flex';
            if (src) {
                modalImg.src = src;
                modalImg.style.display = 'block';
            } else {
                modalImg.style.display = 'none';
                modalImg.src = '';
            }
            modalDetail.textContent = detail;
        }

        function closeModal() {
            modal.style.display = 'none';
            modalImg.src = '';
            modalImg.style.display = 'block';
            modalDetail.textContent = '';
        }

        window.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
    </script>

    <!-- Footer -->
    <footer style="margin-top: 60px;">© <?= date("Y") ?> Galeri Seni | RyukaaArt</footer>
</body>

</html>

<?php
// Tutup koneksi database
$conn->close();
?>