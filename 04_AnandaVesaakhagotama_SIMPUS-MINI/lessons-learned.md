# Lessons Learned: Perjalanan Membangun SIMPUS-Mini

Dari 13 jobsheet yang telah dikerjakan, saya menyadari bahwa membangun aplikasi web bukan sekadar membuat halaman HTML yang bisa diklik. Ada banyak lapisan kompleksitas di baliknya.

**Tantangan Terbesar: Keamanan dan Arsitektur Konfigurasi**
Bagian yang paling menantang bagi saya adalah transisi dari kode prosedural dasar menuju praktik standar industri, khususnya pada Jobsheet 11 (Keamanan XSS & CSRF) dan Jobsheet 13 (Environment Variables). 

Pada awalnya, saya terbiasa menulis kredensial database (username, password) secara langsung (hardcoded) di dalam file koneksi. Namun di Jobsheet 13, saya belajar bahwa hal tersebut sangat berbahaya untuk *production*. Menerapkan `DB_NAME` secara dinamis melalui Environment Variable ternyata cukup *tricky*, terutama saat berhadapan dengan perilaku terminal yang berbeda (seperti Windows CMD yang sensitif terhadap spasi gaib, dibandingkan dengan Git Bash yang lebih mulus). 

Selain itu, menangani *Race Condition* di Jobsheet 12 menggunakan `FOR UPDATE` di PostgreSQL membuka mata saya bahwa aplikasi tidak hanya digunakan oleh satu orang. Jika ada dua pustakawan yang menekan tombol "Pinjam" di detik yang persis sama, database bisa rusak jika tidak ada penguncian (Locking) transaksi yang baik.

**Kesimpulan**
Perjalanan dari kerangka statis (Jobsheet 1) hingga aplikasi dinamis siap deploy ini mengajarkan saya bahwa *Programming is about solving problems*. Kesalahan seperti *Syntax Error* atau *Command Not Found* adalah bagian dari proses belajar untuk lebih memahami cara kerja server dan sistem operasi.