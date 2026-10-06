<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$base_url = "./";
$active_menu = "beranda";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Manajemen Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex min-vh-100">
    <?php include 'components/sidebar.php'; ?>

    <div class="flex-grow-1 bg-light p-4">
        <div class="p-4 mb-4 bg-white rounded-3 shadow-sm border">
            <h3 class="fw-bold mb-2">Selamat Datang di Sistem Manajemen Akun</h3>
            <p class="text-muted mb-0">Halo, <b><?php echo $_SESSION['name']; ?></b>! Anda login sebagai administrator. Silakan pilih menu di sidebar untuk mengelola data akun, tipe akun, atau jenis aksi.</p>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-primary">Data Akun</h5>
                        <p class="card-text text-muted small">Kelola data pengguna, hak akses, status aktif/nonaktif, dan nomor identitas (NIM/NIP).</p>
                        <a href="akun/index.php" class="btn btn-primary btn-sm">Kelola Akun</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-success">Tipe Akun</h5>
                        <p class="card-text text-muted small">Kelola data tipe role akun seperti Admin, Dosen, dan Mahasiswa berserta deskripsinya.</p>
                        <a href="tipe_akun/index.php" class="btn btn-success btn-sm">Kelola Tipe Akun</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-info">Jenis Aksi</h5>
                        <p class="card-text text-muted small">Kelola katalog jenis aksi sistem seperti Create, Read, Update, dan Delete.</p>
                        <a href="jenis_aksi/index.php" class="btn btn-info btn-sm text-white">Kelola Jenis Aksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
