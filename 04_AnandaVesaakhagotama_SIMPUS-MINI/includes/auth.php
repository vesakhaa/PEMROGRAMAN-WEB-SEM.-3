<?php
// Guard clause: di-include di baris paling atas setiap halaman yang
// membutuhkan login (sebelum header.php mengeluarkan output apa pun),
// agar header('Location: ...') masih bisa dipanggil.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Cek apakah user memiliki cookie 'remember_username'
    if (isset($_COOKIE['remember_username'])) {
        // Panggil koneksi database untuk mengambil data user berdasarkan username di cookie
        require_once __DIR__ . '/koneksi.php';
        
        $username = $_COOKIE['remember_username'];
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Jika user ditemukan, set ulang session agar user kembali "login"
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];
        } else {
            // Jika cookie ada tapi user tidak ditemukan di DB (tidak valid), hapus cookie dan lempar ke login
            setcookie('remember_username', '', time() - 3600, "/");
            header('Location: ../auth/login.php');
            exit;
        }
    } else {
        // Jika session tidak ada dan cookie juga tidak ada, lempar ke login
        header('Location: ../auth/login.php');
        exit;
    }
}