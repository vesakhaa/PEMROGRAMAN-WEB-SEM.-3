<?php
// Mengambil konfigurasi dinamis dari config.php
$config = require __DIR__ . '/config.php';

try {
    $dsn = sprintf(
        "pgsql:host=%s;port=%s;dbname=%s",
        $config['db_host'],
        $config['db_port'],
        $config['db_name']
    );

    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}