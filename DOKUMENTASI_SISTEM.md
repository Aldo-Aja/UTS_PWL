# DOKUMENTASI SISTEM MANAJEMEN AKUN (UTS PEMROGRAMAN WEB LANJUT)

---

## 1. Deskripsi Sistem

### 1.1 Gambaran Umum
**Sistem Manajemen Akun** adalah aplikasi web dinamis berbasis **PHP Native** dan basis data relasional **MySQL (MariaDB)** yang dikembangkan untuk mengelola data akun pengguna terpusat, pengelompokan tipe akun (*role/hak akses*), serta katalog jenis aksi sistem di lingkungan institusi akademik Politeknik Negeri Jakarta (PNJ).

Sistem ini menerapkan standar arsitektur modern dalam manipulasi basis data, meliputi penggunaan pengenal unik global **UUID Version 4 (36 karakter)** sebagai *Primary Key*, penjaminan integritas data relasional (*One-to-One / Foreign Key Constraints*), enkripsi kredensial pengguna menggunakan algoritma hashing standar industri (*Bcrypt*), mekanisme penghapusan aman (*deleted_at*), serta validasi domain email khusus institusi (`@pnj.ac.id`).

### 1.2 Tujuan Pembuatan Sistem
Tujuan dari perancangan dan pembangunan sistem ini adalah:
1. **Sentralisasi Pengelolaan Data Akun**: Mempermudah administrator dalam mencatat, memperbarui, memantau, dan mengorganisasi data pengguna (Admin, Dosen, Mahasiswa) lengkap dengan nomor identitas resmi (NIM/NIP).
2. **Keamanan Kredensial & Validasi Identitas Institusi**: Mencegah pendaftaran email ilegal dari penyedia publik (seperti Gmail, Yahoo, dsb.) dengan membatasi registrasi dan otentikasi hanya untuk pengguna yang memiliki domain resmi kampus (`@pnj.ac.id`).
3. **Penerapan Standar UUID**: Menggantikan skema *Auto-Increment Integer* konvensional dengan *Universally Unique Identifier (UUID)* 128-bit untuk mencegah ancaman *enumeration attack* dan mendukung skalabilitas multi-server.
4. **Keamanan Data Historis (*Audit Trail*)**: Memastikan data yang dihapus tidak langsung hilang secara fisik dari basis data, melainkan ditandai melalui stempel waktu pada kolom `deleted_at`, sehingga jejak integritas relasi tetap terjaga.
5. **Kemudahan *Deployment* Mandiri (*Auto-Migration*)**: Menyediakan fitur inisialisasi basis data otomatis saat aplikasi pertama kali dijalankan tanpa menuntut administrator mengimpor berkas SQL secara manual.

### 1.3 Fitur-Fitur Utama Sistem
1. **Otentikasi & Manajemen Sesi (*Login / Logout*)**:
   - Autentikasi berbasis email institusi (`@pnj.ac.id`) dan kata sandi terenkripsi.
   - Proteksi sesi global (*session protection*) pada seluruh halaman internal agar tidak dapat diakses tanpa login.
2. **Inisialisasi Database Otomatis (*Auto-Init / Auto-Migration*)**:
   - Pengecekan otomatis saat web pertama kali diakses. Jika database atau tabel belum tersedia, sistem secara otomatis mengeksekusi DDL dan seeder data awal dari `database.sql`.
3. **Manajemen Akun Pengguna (*CRUD Accounts*)**:
   - Menambah akun baru dengan generator UUID otomatis.
   - Menampilkan daftar akun dengan relasi nama tipe akun, jenis identitas (NIM/NIP), dan status akun.
   - Mengubah profil akun dan pembaruan kata sandi opsional.
   - Menghapus akun secara aman dengan pembaruan stempel waktu `deleted_at`.
4. **Validasi Interaktif Domain Email (`@pnj.ac.id`)**:
   - Pengecekan real-time di sisi *client* (JavaScript) yang mendeteksi ketikan setelah simbol `@`.
   - Validasi ketat di sisi *server* (PHP Regular Expression) untuk menjamin integritas data sebelum query SQL dijalankan.
5. **Manajemen Tipe Akun (*CRUD Account Type*)**:
   - Pengelolaan kategori peran (*Admin, Dosen, Mahasiswa*) beserta deskripsi hak aksesnya.
6. **Manajemen Jenis Aksi Sistem (*CRUD Actions*)**:
   - Pengelolaan katalog aksi sistem (*Create, Read, Update, Delete*) sebagai fondasi hak akses lanjutan.
7. **Pencarian Data Terpadu (*Search & Filter*)**:
   - Filter pencarian berbasis teks pada setiap modul untuk mempercepat penemuan data berdasarkan nama, email, identitas, atau deskripsi.

---

## 2. Kebutuhan Sistem

### 2.1 Kebutuhan Perangkat Lunak (*Software Requirements*)
Untuk mengembangkan dan menjalankan sistem ini secara optimal, diperlukan lingkungan perangkat lunak sebagai berikut:
- **Web Server**: Apache Web Server (dijalankan melalui paket lokal Laragon / XAMPP).
- **Bahasa Pemrograman**: PHP versi 8.0 atau yang lebih baru (pada proyek ini berjalan di PHP 8.2).
- **Basis Data**: MySQL versi 8.0+ atau MariaDB 10.4+.
- **Web Browser**: Browser modern dengan dukungan penuh terhadap HTML5, CSS3, JavaScript ES6 (Google Chrome, Mozilla Firefox, Microsoft Edge).
- **Ekstensi PHP Aktif**:
  - `mysqli`: Untuk komunikasi dan eksekusi query ke server database MySQL.
  - `session`: Untuk manajemen status sesi login pengguna.
  - `random`: Untuk pembangkitan entropi kriptografis UUID v4 via `random_bytes()`.

### 2.2 Kebutuhan Basis Data (*Database Requirements*)
- **Nama Basis Data**: `pbl_ti_2025_3c_revaldoparikesit`
- **Karakter Set & Collation**: `utf8mb4` / `utf8mb4_general_ci` (mendukung penyimpanan karakter internasional secara presisi).
- **Format Primary Key Wajib**: `VARCHAR(36)` berisikan UUID Version 4.
- **Kolom Standar Audit Wajib (Tersedia di setiap tabel)**:
  - `created_at` bertipe `DATETIME` (Default: `CURRENT_TIMESTAMP`) untuk mencatat waktu data dibuat.
  - `updated_at` bertipe `DATETIME` (Default: `NULL ON UPDATE CURRENT_TIMESTAMP`) untuk mencatat waktu data terakhir kali diperbarui.
  - `deleted_at` bertipe `DATETIME` (Default: `NULL`) untuk mencatat waktu data dihapus.

### 2.3 Detail Struktur Tabel yang Digunakan

#### A. Tabel `account_type`
Menyimpan klasifikasi tipe akun atau peran hak akses pengguna.
| Nama Kolom | Tipe Data | Constraint / Keterangan |
| :--- | :--- | :--- |
| `id` | VARCHAR(36) | Primary Key, Not Null (UUID v4) |
| `name` | VARCHAR(128) | Not Null (Nama tipe: Admin, Dosen, Mahasiswa) |
| `description` | TEXT | Nullable (Deskripsi fungsi hak akses) |
| `created_at` | DATETIME | Default: `CURRENT_TIMESTAMP` |
| `updated_at` | DATETIME | Default: `NULL ON UPDATE CURRENT_TIMESTAMP` |
| `deleted_at` | DATETIME | Default: `NULL` (Waktu data dihapus) |

#### B. Tabel `actions`
Menyimpan katalog jenis aksi atau tindakan operasi yang diizinkan dalam sistem.
| Nama Kolom | Tipe Data | Constraint / Keterangan |
| :--- | :--- | :--- |
| `id` | VARCHAR(36) | Primary Key, Not Null (UUID v4) |
| `name` | VARCHAR(128) | Not Null (Nama aksi: Create, Read, Update, Delete) |
| `description` | TEXT | Nullable (Deskripsi teknis fungsi aksi) |
| `created_at` | DATETIME | Default: `CURRENT_TIMESTAMP` |
| `updated_at` | DATETIME | Default: `NULL ON UPDATE CURRENT_TIMESTAMP` |
| `deleted_at` | DATETIME | Default: `NULL` (Waktu data dihapus) |

#### C. Tabel `accounts`
Menyimpan informasi identitas dan autentikasi pengguna sistem.
| Nama Kolom | Tipe Data | Constraint / Keterangan |
| :--- | :--- | :--- |
| `id` | VARCHAR(36) | Primary Key, Not Null (UUID v4) |
| `name` | VARCHAR(128) | Not Null (Nama lengkap pengguna) |
| `email` | VARCHAR(128) | Not Null, UNIQUE (Wajib domain `@pnj.ac.id`) |
| `password` | TEXT | Not Null (Enkripsi Bcrypt hash) |
| `account_type_id` | VARCHAR(36) | Not Null, Foreign Key merujuk ke `account_type(id)` |
| `status` | VARCHAR(128) | Not Null (`Aktif` / `Nonaktif`) |
| `identification_number` | VARCHAR(128) | Not Null (Nomor unik identitas: NIM / NIP) |
| `identification_type` | ENUM('NIM', 'NIP') | Not Null (Jenis identitas resmi) |
| `created_at` | DATETIME | Default: `CURRENT_TIMESTAMP` |
| `updated_at` | DATETIME | Default: `NULL ON UPDATE CURRENT_TIMESTAMP` |
| `deleted_at` | DATETIME | Default: `NULL` (Waktu data dihapus) |

**Relasi Antartabel (*Foreign Key*)**:
```sql
CONSTRAINT `fk_accounts_account_type` 
FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`) 
ON DELETE CASCADE ON UPDATE CASCADE
```

### 2.4 Kebutuhan Antarmuka & Pustaka Pendukung
- **Framework Tampilan**: Bootstrap versi 5.3.0 (via CDN) untuk tata letak kisi (*grid system*), komponen formulir, kartu (*cards*), dan responsivitas layar ponsel maupun desktop.
- **Struktur Modular Antarmuka**: Komponen bilah samping terpusat (`components/sidebar.php`) yang menyatukan navigasi menu dan menampilkan profil pengguna yang sedang login.

---

## 3. Proses Pembuatan Fitur, Logika, dan Algoritma

### 3.1 Fitur Auto-Migration & Inisialisasi Database (`conn.php`)
Fitur ini dirancang agar penguji atau dosen dapat menjalankan proyek tanpa perlu membuka phpMyAdmin untuk membuat database dan mengimpor tabel secara manual.

#### Logika dan Algoritma:
1. **Koneksi Non-Database Awal**:
   Aplikasi membuat koneksi ke server database MySQL tanpa menyertakan nama database tujuan:
   ```php
   $conn = mysqli_connect($host, $user, $pass);
   ```
   *Tujuan*: Mencegah PHP melempar error fatal `Unknown database` apabila database belum pernah dibuat di server.
2. **Pembuatan Database Idempoten**:
   Sistem mengeksekusi query pembuatan database dengan klausa aman:
   ```sql
   CREATE DATABASE IF NOT EXISTS `pbl_ti_2025_3c_revaldoparikesit`;
   ```
   Setelah itu, koneksi dialihkan ke database aktif melalui `mysqli_select_db()`.
3. **Pendeteksian Keberadaan Tabel**:
   Sistem memeriksa apakah tabel utama `accounts` sudah ada:
   ```sql
   SHOW TABLES LIKE 'accounts';
   ```
4. **Eksekusi Multi-Query & Pembersihan Buffer**:
   Jika tabel `accounts` belum ada (database baru):
   - Script membaca isi berkas `database.sql` menggunakan `file_get_contents()`.
   - Menjalankan seluruh batch query DDL dan seeder data awal menggunakan fungsi `mysqli_multi_query($conn, $sql_content)`.
   - Membersihkan antrean hasil query multi (*result buffer draining*) menggunakan perulangan:
     ```php
     do {
         if ($result = mysqli_store_result($conn)) {
             mysqli_free_result($result);
         }
     } while (mysqli_more_results($conn) && mysqli_next_result($conn));
     ```
     *Tujuan*: Mencegah terjadinya galat internal MySQL driver `Commands out of sync; you can't run this command now` pada query aplikasi berikutnya.

---

### 3.2 Algoritma Pembangkit UUID v4 (`generate_uuid()`)
Sistem tidak menggunakan ID integer auto-increment untuk memenuhi ketentuan primary key unik global.

#### Logika dan Algoritma:
Standar UUID v4 (RFC 4122) mensyaratkan 128 bit acak dengan struktur heksadesimal 32 karakter dan 4 pemisah strip (`8-4-4-4-12`).
1. **Pembangkitan Entropi Acak Aman**:
   Mengambil 16 byte acak kriptografis:
   ```php
   $data = random_bytes(16);
   ```
2. **Penyetelan Bit Versi 4**:
   Byte ke-7 dimanipulasi dengan operasi bitwise logika AND dan OR agar 4 bit paling atas bernilai `0100` (versi 4):
   ```php
   $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
   ```
3. **Penyetelan Bit Varian RFC 4122**:
   Byte ke-9 dimanipulasi agar 2 bit paling atas bernilai `10` (varian standar):
   ```php
   $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
   ```
4. **Format Heksadesimal String**:
   Konversi string biner ke heksadesimal lalu diformat menjadi pola `xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx`:
   ```php
   return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
   ```

---

### 3.3 Logika Validasi Khusus Domain Email `@pnj.ac.id`
Sistem menerapkan prinsip *Defense in Depth* (Validasi Ganda di sisi *Client* dan *Server*).

#### A. Logika Sisi Klien (Real-time JavaScript Interaktif)
Diterapkan pada [login.php](file:///c:/laragon/www/UTS_PWL/login.php), [akun/tambah.php](file:///c:/laragon/www/UTS_PWL/akun/tambah.php), dan [akun/edit.php](file:///c:/laragon/www/UTS_PWL/akun/edit.php).
- **Algoritma Saat Mengetik (`input` event)**:
  1. Ambil nilai input email dan lakukan `trim()`.
  2. Cari posisi karakter `@` menggunakan `indexOf('@')`.
  3. **Jika simbol `@` belum diketik**: Sembunyikan pesan peringatan dan hilangkan penanda merah (`is-invalid`) agar pengguna tidak terganggu saat masih mengetik nama depan.
  4. **Jika simbol `@` sudah diketik**: Ambil substring setelah simbol `@` dan ubah menjadi huruf kecil (*lowercase*).
  5. Periksa kesamaan teks domain:
     - Jika domain **tidak sama persis** dengan `pnj.ac.id`, aktifkan class `is-invalid` dan munculkan teks peringatan:
       > `Domain email harus @pnj.ac.id`
     - Jika domain **sudah sama persis** dengan `pnj.ac.id`, hilangkan status error.
- **Proteksi Pengiriman Formulir (`submit` event)**:
  Saat tombol Simpan / Login diklik, script mengecek ulang domain. Jika tidak valid, pengiriman formulir dibatalkan via `e.preventDefault()`, input diberi fokus kursor, dan pesan peringatan dipaksa tampil.

#### B. Logika Sisi Server (Validasi Backend PHP)
Diterapkan pada [login_action.php](file:///c:/laragon/www/UTS_PWL/login_action.php), [akun/tambah_action.php](file:///c:/laragon/www/UTS_PWL/akun/tambah_action.php), dan [akun/edit_action.php](file:///c:/laragon/www/UTS_PWL/akun/edit_action.php).
- Menggunakan ekspresi reguler (Regex) untuk menjamin tidak ada manipulasi melalui Inspect Element atau tools API:
  ```php
  $email = trim($_POST['email']);
  if (!preg_match('/^[a-zA-Z0-9._%+-]+@pnj\.ac\.id$/i', $email)) {
      header("location:...&pesan=invalid_domain");
      exit;
  }
  ```

---

### 3.4 Logika Autentikasi Pengguna & Keamanan Kata Sandi
1. **Hashing Kata Sandi**:
   Pada saat penambahan atau pembaruan akun, kata sandi dienkripsi menggunakan fungsi bawaan PHP:
   ```php
   $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
   ```
   Metode ini secara otomatis menyertakan *salt* acak dan algoritma Bcrypt yang aman terhadap serangan *rainbow table*.
2. **Verifikasi Login**:
   - Sistem mencari akun berdasarkan email terdaftar yang belum terhapus:
     ```sql
     SELECT * FROM accounts WHERE email = '$email' AND deleted_at IS NULL;
     ```
   - Menguji kecocokan teks kata sandi masukan dengan hash tersimpan menggunakan `password_verify($password, $row['password'])`.
   - Jika cocok, inisialisasi sesi `$_SESSION['login'] = true`, `$_SESSION['name']`, dan `$_SESSION['email']`.
   - Jika tidak cocok atau akun tidak ditemukan, pengguna diarahkan kembali dengan notifikasi kegagalan.

---

### 3.5 Logika Penghapusan Aman Data (Kolom `deleted_at`)
Pada tabel `accounts`, `account_type`, dan `actions`, penghapusan data tidak mengeksekusi perintah SQL `DELETE FROM`.
1. **Proses Penghapusan**:
   Saat aksi hapus dijalankan, sistem mencatat waktu kejadian ke kolom `deleted_at`:
   ```sql
   UPDATE accounts SET deleted_at = NOW() WHERE id = '$id';
   ```
2. **Proses Pembacaan Data**:
   Semua query `SELECT` pada aplikasi secara ketat menambahkan klausa kondisi:
   ```sql
   WHERE deleted_at IS NULL
   ```
   Hal ini menjamin integritas relasi foreign key tidak rusak dan data yang dihapus dapat dipulihkan (*restore*) kembali di masa mendatang jika diperlukan.

---

### 3.6 Logika Pencarian Cepat (*Search Filter*)
Setiap modul indeks menyertakan formulir pencarian dinamis:
1. Mengambil parameter query string `$_GET['cari']`.
2. Jika parameter terisi, query SQL diperluas menggunakan operator `OR` dan wildcard `LIKE '%$cari%'` pada beberapa kolom sekaligus:
   ```sql
   SELECT accounts.*, account_type.name AS tipe_akun_nama 
   FROM accounts 
   LEFT JOIN account_type ON accounts.account_type_id = account_type.id 
   WHERE accounts.deleted_at IS NULL 
     AND (accounts.name LIKE '%$cari%' 
       OR accounts.email LIKE '%$cari%' 
       OR accounts.identification_number LIKE '%$cari%' 
       OR account_type.name LIKE '%$cari%')
   ORDER BY accounts.created_at DESC;
   ```

---

### 3.7 Penataan Antarmuka & Penyeragaman Placeholder
Untuk memberikan pengalaman pengguna (*User Experience*) yang rapi dan konsisten:
- **Jarak Antar-Tombol Aksi**: Tombol *Edit* dan *Hapus* disusun dalam kontainer flexbox Bootstrap `d-flex justify-content-center gap-2` sehingga kedua tombol terpisah secara proporsional dengan sudut membulat mandiri.
- **Teks Bersih Tanpa Badge**: Nilai kolom tipe akun, status, dan nomor identitas disajikan sebagai teks bersih tanpa latar belakang badge warna-warni yang mencolok.
- **Konsistensi Placeholder**: Seluruh elemen masukan formulir diseragamkan dengan format kalimat instruktif yang diawali kata `Masukan ...` (misalnya: *Masukan Nama Lengkap, Masukan Email, Masukan Password, Masukan Nomor Identitas, Masukan Nama Tipe Akun, Masukan Deskripsi Tipe Akun*).
