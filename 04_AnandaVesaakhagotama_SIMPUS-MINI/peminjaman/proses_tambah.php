<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$anggotaId = $_POST['anggota_id'] ?? '';
$bukuId = $_POST['buku_id'] ?? '';

if ($anggotaId === '' || $bukuId === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota dan buku wajib dipilih.'];
    header('Location: tambah.php');
    exit;
}

$stmtCekTerlambat = $pdo->prepare("
    SELECT COUNT(*) FROM peminjaman 
    WHERE anggota_id = :anggota_id 
    AND tanggal_kembali IS NULL 
    AND (CURRENT_DATE - tanggal_pinjam) > 14
");
$stmtCekTerlambat->execute(['anggota_id' => $_POST['anggota_id']]);
$jumlahTerlambat = $stmtCekTerlambat->fetchColumn();

if ($jumlahTerlambat > 0) {
    $_SESSION['flash_error'] = "Peminjaman ditolak! Anggota ini memiliki buku yang terlambat dikembalikan lebih dari 14 hari.";
    header("Location: tambah.php"); 
    exit;
}

try {
    $pdo->beginTransaction();

    $cekTerlambat = $pdo->prepare("
        SELECT COUNT(*) 
        FROM peminjaman 
        WHERE anggota_id = :anggota_id 
          AND status = 'dipinjam' 
          AND (CURRENT_DATE - tanggal_pinjam) > 14
    ");
    $cekTerlambat->execute(['anggota_id' => $anggotaId]);
    $jumlahTerlambat = $cekTerlambat->fetchColumn();

    if ($jumlahTerlambat > 0) {
        throw new Exception('Peminjaman ditolak: Anggota masih memiliki tanggungan buku yang terlambat lebih dari 14 hari.');
    }
   
    // Kunci baris buku (FOR UPDATE) agar stok tidak berubah oleh transaksi lain
    // di tengah proses ini — mencegah stok menjadi negatif akibat race condition.
    $cek = $pdo->prepare("SELECT stok FROM buku WHERE id = :id FOR UPDATE");
    $cek->execute(['id' => $bukuId]);
    $buku = $cek->fetch(PDO::FETCH_ASSOC);

    if (!$buku || $buku['stok'] < 1) {
        throw new Exception('Stok buku tidak tersedia.');
    }

    $insert = $pdo->prepare(
        "INSERT INTO peminjaman (buku_id, anggota_id, tanggal_pinjam, status)
         VALUES (:buku_id, :anggota_id, CURRENT_DATE, 'dipinjam')"
    );
    $insert->execute(['buku_id' => $bukuId, 'anggota_id' => $anggotaId]);

    $update = $pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id = :id");
    $update->execute(['id' => $bukuId]);

    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Peminjaman berhasil dicatat.'];
    header('Location: ../index.php');
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mencatat peminjaman: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}