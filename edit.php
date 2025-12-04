<?php
require_once 'inc/config.php';

$id = $_GET['id'] ?? null;
$bukuModel = new Buku();
$dataBuku = $bukuModel->getById($id);

if (!$dataBuku) {
    Utility::redirect('index.php', 'Buku tidak ditemukan.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Logika gambar sama seperti create, tapi default pakai gambar lama
    $gambar = $dataBuku['gambar'];
    
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "uploads/";
        $file_ext = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $new_name = time() . '_' . rand(100, 999) . '.' . $file_ext;
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $new_name)) {
            // Hapus gambar lama jika ada (opsional)
            if ($dataBuku['gambar'] && file_exists($target_dir . $dataBuku['gambar'])) {
                unlink($target_dir . $dataBuku['gambar']);
            }
            $gambar = $new_name;
        }
    }

    $updateData = [
        'judul' => $_POST['judul'],
        'penulis' => $_POST['penulis'],
        'kategori' => $_POST['kategori'],
        'harga' => $_POST['harga'],
        'stok' => $_POST['stok'],
        'gambar' => $gambar
    ];

    if ($bukuModel->update($id, $updateData)) {
        Utility::redirect('index.php', 'Data buku diperbarui.');
    } else {
        Utility::redirect("edit.php?id=$id", 'Gagal update data.');
    }
}
?>