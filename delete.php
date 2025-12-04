<?php
require_once 'inc/config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $bukuModel = new Buku();
    
    $data = $bukuModel->getById($id);
    if ($data && $data['gambar']) {
        $file_path = "uploads/" . $data['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    $bukuModel->delete($id);
}

header("Location: index.php");
exit;