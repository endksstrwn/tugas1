<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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