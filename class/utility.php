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
     public static function redirect($url, $msg = '', $prefill = []) {
        if (!empty($prefill)) {
            $_SESSION['prefill'] = $prefill;
        }
        if ($msg) {
            $_SESSION['flash']['message'] = $msg;
        }
        header("Location: " . BASE_URL . $url);
        exit();
    }

    // Menampilkan pesan flash (sukses/gagal)
    public static function showFlash() {
        if (isset($_SESSION['flash'])) {
            echo '<div style="background:#d1fae5; color:#065f46; padding:1rem; margin-bottom:1rem; border-radius:0.375rem;">';
            echo $_SESSION['flash']['message'];
            echo '</div>';
            unset($_SESSION['flash']);
        }
    }

    // Mengambil data input sebelumnya (agar user tidak mengetik ulang saat error)
    public static function getPrefill() {
        $data = $_SESSION['prefill'] ?? [];
        // Hapus prefill setelah diambil agar tidak muncul terus
        if (isset($_SESSION['prefill'])) {
            unset($_SESSION['prefill']);
        }
        return $data;
    }
}