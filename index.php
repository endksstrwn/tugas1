<?php
require_once 'inc/config.php';

$bukuModel = new Buku();
$daftar_buku = $bukuModel->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <?php Utility::showNav(); ?>
    <div class="container">
        <div class="card">
            <h1>📦 Stok Buku</h1>
            
            <?php Utility::showFlash(); ?>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Info Buku</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($daftar_buku as $row): ?>
                        <tr>
                            <td>
                                <?php if($row['gambar']): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="thumb-img">
                                <?php else: ?>
                                    <span class="badge">No IMG</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($row['judul']) ?></strong><br>
                                <small><?= htmlspecialchars($row['penulis']) ?></small>
                            </td>
                            <td><span class="badge badge-in"><?= htmlspecialchars($row['kategori']) ?></span></td>
                            <td><?= formatRupiah($row['harga']) ?></td>
                            <td><?= $row['stok'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Hapus buku ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>