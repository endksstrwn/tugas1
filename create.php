<?php
require_once 'inc/config.php';

// Ambil data prefill (jika ada error sebelumnya)
$prefill = Utility::getPrefill();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Logika Upload Gambar
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        
        $file_ext = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $valid_extensions = ['jpg', 'jpeg', 'png'];
        
        if (in_array($file_ext, $valid_extensions)) {
            $new_name = time() . '_' . rand(100, 999) . '.' . $file_ext;
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $new_name)) {
                $gambar = $new_name;
            }
        } else {
            // GAGAL: Redirect balik bawa inputan user + pesan error
            Utility::redirect('create.php', 'Format gambar harus JPG/PNG!', $_POST);
        }
    }

    // Simpan Data
    $bukuModel = new Buku();
    $data = [
        'judul' => $judul, 'penulis' => $penulis, 'kategori' => $kategori,
        'harga' => $harga, 'stok' => $stok, 'gambar' => $gambar
    ];
    
    if ($bukuModel->create($data)) {
        // SUKSES: Balik ke index
        Utility::redirect('index.php', 'Buku berhasil ditambahkan!');
    } else {
        // GAGAL: Balik ke create
        Utility::redirect('create.php', 'Gagal menyimpan database.', $_POST);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php Utility::showNav(); ?>
    <div class="container">
        <div class="card">
            <h1>➕ Tambah Buku</h1>
            
            <?php Utility::showFlash(); ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="<?= htmlspecialchars($prefill['judul'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="<?= htmlspecialchars($prefill['penulis'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori">
                        <?php $kat = $prefill['kategori'] ?? ''; ?>
                        <option value="Fiksi" <?= $kat == 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
                        <option value="Non-Fiksi" <?= $kat == 'Non-Fiksi' ? 'selected' : '' ?>>Non-Fiksi</option>
                        <option value="Edukasi" <?= $kat == 'Edukasi' ? 'selected' : '' ?>>Edukasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" value="<?= htmlspecialchars($prefill['harga'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="<?= htmlspecialchars($prefill['stok'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Cover</label>
                    <input type="file" name="gambar">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>