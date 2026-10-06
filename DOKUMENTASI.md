# Dokumentasi Sistem Manajemen Akun (UTS PWL)

**Mata Kuliah:** Pemrograman Web Lanjut  
**Program Studi:** D4 Teknik Informatika - PNJ  
**Pendekatan:** PHP Native (Tanpa Framework) & Minimalis  

---

## 1. Deskripsi Sistem
Sistem Manajemen Akun adalah aplikasi berbasis web yang dibuat untuk mengelola data akun pengguna, tipe akun (role/hak akses), serta jenis aksi yang diizinkan dalam sistem.  
**Tujuan Pembuatan:**
- Mempermudah administrasi data pengguna dan hak akses secara terpusat.
- Mencegah kehilangan data permanen dengan menerapkan mekanisme **Soft Delete**.

**Fitur Utama:**
1. **Autentikasi (Login & Logout):** Masuk sistem menggunakan email dan password terenkripsi (`password_hash`).
2. **Manajemen Akun:** Menampilkan data akun, pencarian, penambahan akun baru ber-UUID, edit data/password, dan soft delete.
3. **Manajemen Tipe Akun:** Pengelolaan role akun (Admin, Dosen, Mahasiswa) dengan fitur cari, tambah, ubah, dan soft delete.
4. **Manajemen Jenis Aksi:** Pengelolaan aksi sistem (Create, Read, Update, Delete) dengan fitur cari, tambah, ubah, dan soft delete.

---

## 2. Kebutuhan Sistem
1. **Web Server & Lingkungan:**
   - PHP versi 7.4 / 8.x
   - MySQL / MariaDB (via XAMPP)
   - Web Browser (Chrome, Edge, Firefox)
2. **Basis Data & Penamaan:**
   - Format nama database: `PBL_{JURUSAN}_{ANGKATAN}_{KELAS}_{NAMA}`  
     *Contoh default:* `pbl_ti_2025_3a_aldo`
3. **Tabel Database (Semua ber-Primary Key UUID v4 & Soft Delete):**
   - **`account_type`**: `id` (UUID), `name`, `description`, `created_at`, `updated_at`, `deleted_at`.
   - **`actions`**: `id` (UUID), `name`, `description`, `created_at`, `updated_at`, `deleted_at`.
   - **`accounts`**: `id` (UUID), `name`, `email`, `password`, `account_type_id` (FK), `status` (Aktif/Nonaktif), `identification_number`, `identification_type` (NIM/NIP), `created_at`, `updated_at`, `deleted_at`.

---

## 3. Proses Pembuatan Fitur & Logika Alur
1. **Koneksi & Helper UUID (`conn.php`):**
   - Menggunakan `mysqli_connect()`.
   - Fungsi `generate_uuid()` membangkitkan string acak format UUID v4 (36 karakter) sebelum query `INSERT`.
2. **Autentikasi Login (`login.php` & `login_action.php`):**
   - Password diverifikasi menggunakan `password_verify($password, $row['password'])`.
   - Menggunakan session PHP sederhana untuk menyimpan sesi login.
3. **Struktur Folder Terorganisir:**
   - **`akun/`**: `index.php`, `tambah.php`, `tambah_action.php`, `edit.php`, `edit_action.php`, `hapus.php`
   - **`tipe_akun/`**: `index.php`, `tambah.php`, `tambah_action.php`, `edit.php`, `edit_action.php`, `hapus.php`
   - **`jenis_aksi/`**: `index.php`, `tambah.php`, `tambah_action.php`, `edit.php`, `edit_action.php`, `hapus.php`
   - **Root**: `index.php`, `conn.php`, `login.php`, `login_action.php`, `logout.php`, `database.sql`

4. **Tampil & Pencarian Data:**
   - Hanya menampilkan data aktif dengan kondisi `WHERE deleted_at IS NULL`.
   - Fitur pencarian menggunakan klausa `LIKE '%$cari%'`.
5. **Mekanisme Soft Delete:**
   - Tidak menggunakan perintah `DELETE FROM ...`.
   - Menggunakan perintah `UPDATE ... SET deleted_at = NOW() WHERE id = '$id'` sehingga riwayat data tetap aman di database.

---

## 4. Demo Aplikasi (Alur Pengujian)
1. **Import Database:**
   - Buka `phpMyAdmin` -> Import file `database.sql`.
2. **Login ke Sistem:**
   - Akses URL: `http://localhost/belajar%20aldo/UTS%20PWL/login.php`
   - Akun Pengujian:
     - **Email:** `admin@it.pnj.ac.id`
     - **Password:** `admin123`
3. **Uji Coba Fitur:**
   - **Pencarian:** Masukkan nama atau NIM pada kolom cari, lalu klik tombol **Cari**.
   - **Tambah Akun:** Klik **+ Tambah Akun**, isi form, lalu klik **Simpan**.
   - **Edit Akun:** Klik icon pensil (✏️), ubah data, lalu klik **Simpan**.
   - **Hapus Akun:** Klik icon tempat sampah (🗑️), data akan otomatis ter-soft delete.
   - **Logout:** Klik tombol **Logout** di pojok kanan atas untuk keluar dari sesi.
