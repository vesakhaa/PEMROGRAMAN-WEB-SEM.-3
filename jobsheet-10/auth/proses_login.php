<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SESSION['login_attempts'] >= 3) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anda telah gagal login 3 kali. Tutup browser atau tunggu sesi di-reset.'];
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['login_attempts'] = 0;
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    if (isset($_POST['remember'])) {
        setcookie('remember_username', $user['username'], time() + (86400 * 30), "/"); //berlaku selama 30 hari
    }

    header('Location: ../index.php');
    exit;
}

$_SESSION['login_attempts']++;

if ($_SESSION['login_attempts'] >= 3) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anda telah gagal login 3 kali. Silakan tutup browser dan coba lagi nanti.'];
} else {
    $sisa = 3 - $_SESSION['login_attempts'];
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Username atau password salah. (Sisa percobaan: $sisa)"];
}

header('Location: login.php');
exit;