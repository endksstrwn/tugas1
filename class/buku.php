<?php
class Buku {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        $sql = "SELECT * FROM buku ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM buku WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO buku (judul, penulis, kategori, harga, stok, gambar) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['judul'], 
            $data['penulis'], 
            $data['kategori'], 
            $data['harga'], 
            $data['stok'], 
            $data['gambar']
        ];
        return $this->db->query($sql, $params);
    }

    public function update($id, $data) {
        if (!empty($data['gambar'])) {
            $sql = "UPDATE buku SET judul=?, penulis=?, kategori=?, harga=?, stok=?, gambar=? WHERE id=?";
            $params = [
                $data['judul'], $data['penulis'], $data['kategori'], 
                $data['harga'], $data['stok'], $data['gambar'], $id
            ];
        } else {
            $sql = "UPDATE buku SET judul=?, penulis=?, kategori=?, harga=?, stok=? WHERE id=?";
            $params = [
                $data['judul'], $data['penulis'], $data['kategori'], 
                $data['harga'], $data['stok'], $id
            ];
        }
        return $this->db->query($sql, $params);
    }

    public function delete($id) {
        $sql = "DELETE FROM buku WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
}