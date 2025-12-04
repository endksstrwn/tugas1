<?php
// 1. MEMUAT KONFIGURASI DAN DATA
require_once 'inc/config.php';

$id = $_GET['id'] ?? null;
$bukuModel = new Buku();
$dataBuku = $bukuModel->getById($id);

// Cek jika buku tidak ditemukan
if (!$dataBuku) {
    Utility::redirect('index.php', 'Buku tidak ditemukan.');
}

// Ambil data prefill. Jika tidak ada error dari POST, akan diisi dengan dataBuku.
$prefill = Utility::getPrefill();

// 2. LOGIKA PEMROSESAN FORM (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Logika gambar sama seperti create, tapi default pakai gambar lama
    $gambar = $dataBuku['gambar'];
    $target_dir = "uploads/"; // Pastikan folder ini ada

    // Cek apakah ada file gambar baru yang di-upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $file_ext = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $new_name = time() . '_' . rand(100, 999) . '.' . $file_ext;
        
        // Logika upload
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $new_name)) {
            // Hapus gambar lama jika ada
            if ($dataBuku['gambar'] && file_exists($target_dir . $dataBuku['gambar'])) {
                unlink($target_dir . $dataBuku['gambar']);
            }
            $gambar = $new_name;
        }
    }

    // Siapkan data untuk update
    $updateData = [
        'judul' => $_POST['judul'],
        'penulis' => $_POST['penulis'],
        'kategori' => $_POST['kategori'],
        'harga' => $_POST['harga'],
        'stok' => $_POST['stok'],
        'gambar' => $gambar // Ini bisa berisi nama file baru atau nama file lama
    ];

    if ($bukuModel->update($id, $updateData)) {
        Utility::redirect('index.php', 'Data buku diperbarui.');
    } else {
        // Jika gagal, redirect kembali ke halaman edit dan kirim data input terakhir sebagai prefill
        Utility::redirect("edit.php?id=$id", 'Gagal update data.', $_POST);
    }
}

// 3. TAMPILAN FORM (HTML)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php Utility::showNav(); ?>
    <div class="container">
        <div class="card">
            <h1>✍️ Edit Buku: <?= htmlspecialchars($dataBuku['judul']) ?></h1>
            
            <?php Utility::showFlash(); ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <?php
                $judul_val = $prefill['judul'] ?? $dataBuku['judul'];
                $penulis_val = $prefill['penulis'] ?? $dataBuku['penulis'];
                $kategori_val = $prefill['kategori'] ?? $dataBuku['kategori'];
                $harga_val = $prefill['harga'] ?? $dataBuku['harga'];
                $stok_val = $prefill['stok'] ?? $dataBuku['stok'];
                ?>

                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="<?= htmlspecialchars($judul_val) ?>" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="<?= htmlspecialchars($penulis_val) ?>" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori">
                        <?php $kat = $kategori_val; ?>
                        <option value="Fiksi" <?= $kat == 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
                        <option value="Non-Fiksi" <?= $kat == 'Non-Fiksi' ? 'selected' : '' ?>>Non-Fiksi</option>
                        <option value="Edukasi" <?= $kat == 'Edukasi' ? 'selected' : '' ?>>Edukasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" value="<?= htmlspecialchars($harga_val) ?>" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="<?= htmlspecialchars($stok_val) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Cover (Biarkan kosong jika tidak diganti)</label>
                    <?php if ($dataBuku['gambar']): ?>
                        <div style="margin-bottom: 10px;">
                            <img src="uploads/<?= htmlspecialchars($dataBuku['gambar']) ?>" class="thumb-img" style="width: 100px; height: auto;">
                            <small style="display: block; color: #6b7280;">Cover saat ini</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="gambar">
                </div>
                
                <button type="submit" class="btn btn-primary">Update Data</button>
            </form>
        </div>
    </div>
</body>
</html>