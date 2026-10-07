<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$base_url = "../";
$active_menu = "jenis_aksi";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jenis Aksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex min-vh-100">
    <?php include '../components/sidebar.php'; ?>

    <div class="flex-grow-1 bg-light p-4">
        <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 650px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-dark">Tambah Jenis Aksi</h5>
            </div>
            <div class="card-body p-4">
                <form action="tambah_action.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-semibold text-secondary">Nama Aksi</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama Jenis Aksi" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label small fw-semibold text-secondary">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Masukan Deskripsi Jenis Aksi"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan</button>
                        <a href="index.php" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
