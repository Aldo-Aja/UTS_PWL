<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include '../conn.php';

$base_url = "../";
$active_menu = "tipe_akun";

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$sql = "SELECT * FROM account_type WHERE deleted_at IS NULL";

if (!empty($cari)) {
    $sql .= " AND (name LIKE '%$cari%' OR description LIKE '%$cari%')";
}

$sql .= " ORDER BY created_at DESC";
$data = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tipe Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex min-vh-100">
    <?php include '../components/sidebar.php'; ?>

    <div class="flex-grow-1 bg-light p-4">
        <h4 class="fw-bold mb-3 text-dark">Manajemen Tipe Akun</h4>

        <?php if (isset($_GET['pesan'])) { ?>
            <div class="alert alert-success py-2 mb-3">
                <?php 
                if ($_GET['pesan'] == 'tambah') echo "Data tipe akun berhasil ditambahkan!";
                else if ($_GET['pesan'] == 'edit') echo "Data tipe akun berhasil diperbarui!";
                else if ($_GET['pesan'] == 'hapus') echo "Data tipe akun berhasil dihapus (soft delete)!";
                ?>
            </div>
        <?php } ?>

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form method="GET" action="index.php" class="d-flex gap-2" style="max-width: 480px; flex: 1;">
                <input type="text" name="cari" class="form-control" placeholder="Cari nama atau deskripsi..." value="<?php echo $cari; ?>">
                <button type="submit" class="btn btn-secondary px-3">Cari</button>
                <?php if (!empty($cari)) { ?>
                    <a href="index.php" class="btn btn-outline-secondary">Reset</a>
                <?php } ?>
            </form>
            <a href="tambah.php" class="btn btn-primary fw-semibold">+ Tambah Tipe Akun</a>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">No</th>
                            <th width="200">Nama</th>
                            <th>Deskripsi</th>
                            <th width="180">Dibuat</th>
                            <th width="140" class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($data) > 0) {
                            while ($row = mysqli_fetch_array($data)) { 
                        ?>
                            <tr>
                                <td class="ps-3 text-muted"><?php echo $no++; ?></td>
                                <td class="fw-semibold text-dark"><?php echo $row['name']; ?></td>
                                <td class="text-secondary"><?php echo $row['description']; ?></td>
                                <td class="text-muted small">
                                    <?php echo date('d M Y H:i', strtotime($row['created_at'])); ?>
                                </td>
                                <td class="text-center pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-warning">Edit</a>
                                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus tipe akun ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            } 
                        } else {
                        ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data tipe akun yang ditemukan.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
