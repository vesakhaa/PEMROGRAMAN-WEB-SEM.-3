<?php
session_start();

// Menghapus dan menghancurkan semua data session
session_unset();
session_destroy();

// Memulai session baru sebentar hanya untuk mengirim pesan
session_start();
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Data session berhasil di-reset!'
];

// Kembalikan pengguna ke halaman utama atau halaman sebelumnya
header('Location: index.php');
exit;
?>