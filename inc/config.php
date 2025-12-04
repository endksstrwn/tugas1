<?php
// Pastikan session dimulai agar Flash Message & Login bisa jalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);


const BASE_URL = 'http://localhost:8000/';

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'komangendik35'; 
const DB_NAME = 'toko_buku_db';

spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../class/' . $class_name . '.php';
});

function formatRupiah($angka){
    return "Rp " . number_format($angka,0,',','.');
}