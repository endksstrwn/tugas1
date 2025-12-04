<?php
class Utility {
    public static function showNav() {
        echo '<header class="top-nav">';
        echo '<div class="logo">🛒 Bookstore Admin</div>';
        echo '<nav>';
        echo '<a href="index.php">📦 Inventory</a>';
        echo '<a href="create.php" class="btn-add">+ Tambah Produk</a>';
        echo '</nav>';
        echo '</header>';
    }
}