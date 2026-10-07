# Sistem Manajemen Akun

Aplikasi web berbasis PHP Native dan MySQL untuk manajemen data akun, tipe akun, dan katalog aksi pada lingkungan Politeknik Negeri Jakarta.

## Fitur Utama

* Autentikasi pengguna berbasis email domain @pnj.ac.id.
* Pengelolaan data akun pengguna dengan Primary Key UUID.
* Pengelolaan data tipe akun (Admin, Dosen, Mahasiswa).
* Pengelolaan katalog jenis aksi sistem (Create, Read, Update, Delete).
* Mekanisme soft delete menggunakan kolom deleted_at.
* Inisialisasi basis data otomatis saat aplikasi pertama kali dijalankan.

## Kebutuhan Sistem

* PHP 8.0 atau lebih baru
* MySQL 8.0 atau MariaDB 10.4 atau lebih baru
* Web Server (Apache via XAMPP, Laragon, atau sejenisnya)

## Panduan Instalasi dan Penggunaan

1. Pindahkan folder proyek ke direktori web server (contoh: htdocs/UTS_PWL pada XAMPP atau www/UTS_PWL pada Laragon).
2. Pastikan layanan Apache dan MySQL sudah berjalan.
3. Buka web browser dan akses URL berikut:
   http://localhost/UTS_PWL/
4. Basis data dan tabel awal akan dibuat secara otomatis oleh sistem saat pertama kali diakses.

## Akun Bawaan (Default Login)

* Email: admin@pnj.ac.id
* Password: admin123
* Peran: Administrator
