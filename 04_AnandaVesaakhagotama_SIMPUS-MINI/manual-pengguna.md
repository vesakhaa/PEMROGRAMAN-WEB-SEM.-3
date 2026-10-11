# 📖 Manual Pengguna SIMPUS-Mini

Selamat datang di panduan penggunaan Sistem Informasi Perpustakaan Mini (SIMPUS-Mini). Dokumen ini akan membantu Anda memahami alur kerja dan cara menggunakan berbagai fitur yang tersedia di dalam aplikasi.

---

## 1. Otentikasi & Akses Sistem

### 1.1 Login Petugas
Untuk mengakses sistem, petugas perpustakaan harus melakukan login menggunakan kredensial yang valid. Halaman ini dilengkapi dengan pengamanan CSRF untuk mencegah serangan pemalsuan *request*.

![Halaman Login Petugas](assets/images/login.png)

---

## 2. Dasbor (Beranda)

Setelah berhasil login, Anda akan diarahkan ke halaman **Beranda**. Halaman ini menampilkan ringkasan informasi penting perpustakaan secara *real-time*, seperti:
- Total jumlah buku yang terdaftar.
- Total anggota perpustakaan aktif.
- Jumlah buku yang saat ini sedang dipinjam.

![Halaman Beranda](assets/images/beranda.png)

---

## 3. Manajemen Buku

### 3.1 Daftar Buku
Halaman ini menampilkan seluruh koleksi buku yang ada di perpustakaan. Anda dapat melihat informasi detail buku (Kode, Judul, Pengarang, Tahun Terbit) beserta status ketersediaannya (Stok / Dipinjam). Tersedia juga fitur **Pencarian** untuk menemukan buku dengan cepat.

![Halaman Daftar Buku](assets/images/daftar_buku.png)

### 3.2 Tambah Buku
Jika ada koleksi buku baru, petugas dapat menambahkannya melalui form ini. Pastikan untuk mengisi semua kolom wajib seperti Judul, Pengarang, dan Tahun Terbit.

![Halaman Tambah Buku](assets/images/tambah_buku.png)

---

## 4. Manajemen Anggota

### 4.1 Daftar Anggota
Halaman ini digunakan untuk mengelola data keanggotaan. Menampilkan nomor anggota, nama, dan alamat. 

![Halaman Daftar Anggota](assets/images/daftar_anggota.png)

### 4.2 Tambah Anggota
Formulir untuk mendaftarkan anggota baru ke dalam sistem perpustakaan. Nomor Anggota harus unik.

![Halaman Tambah Anggota](assets/images/tambah_anggota.png)

---

## 5. Sirkulasi (Peminjaman & Pengembalian)

### 5.1 Peminjaman Buku Baru
Fitur ini digunakan ketika ada anggota yang ingin meminjam buku. Petugas memilih nama anggota dan buku yang akan dipinjam dari *dropdown*. Sistem akan otomatis memvalidasi apakah stok buku masih tersedia dan memastikan proses berjalan aman menggunakan *Database Transaction*.

![Halaman Peminjaman Buku](assets/images/peminjaman.png)

### 5.2 Pengembalian Buku
Halaman ini menampilkan daftar transaksi peminjaman yang sedang aktif (buku belum dikembalikan). Petugas dapat menekan tombol **Kembalikan** ketika anggota membawa kembali buku tersebut. Sistem akan otomatis mencatat tanggal kembali dan mengembalikan stok buku.

![Halaman Pengembalian Buku](assets/images/pengembalian.png)

---

## 6. Riwayat Peminjaman

### 6.1 Memilih Anggota
Untuk melihat rekam jejak peminjaman, petugas pertama-tama memilih nama anggota dari *dropdown* pada halaman pencarian riwayat.

![Halaman Pilih Riwayat](assets/images/riwayat.png)

### 6.2 Daftar Riwayat Peminjaman Lengkap
Setelah anggota dipilih, sistem akan menampilkan tabel riwayat peminjaman lengkap untuk anggota tersebut, baik buku yang masih dipinjam maupun yang sudah dikembalikan.

![Halaman Daftar Riwayat](assets/images/daftar_riwayat.png)

---
*Dokumentasi ini dibuat sebagai bagian dari penyelesaian Proyek Final SIMPUS-Mini.*