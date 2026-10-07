<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include '../conn.php';

$base_url = "../";
$active_menu = "akun";

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$sql = "SELECT accounts.*, account_type.name AS tipe_akun_nama 
        FROM accounts 
        LEFT JOIN account_type ON accounts.account_type_id = account_type.id 
        WHERE accounts.deleted_at IS NULL";

if (!empty($cari)) {
    $sql .= " AND (accounts.name LIKE '%$cari%' 
              OR accounts.email LIKE '%$cari%' 
              OR accounts.identification_number LIKE '%$cari%' 
              OR account_type.name LIKE '%$cari%')";
}

$sql .= " ORDER BY accounts.created_at DESC";
$data = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex min-vh-100">
    <?php include '../components/sidebar.php'; ?>

    <div class="flex-grow-1 bg-light p-4">
        <h4 class="fw-bold mb-3 text-dark">Manajemen Akun</h4>

        <?php if (isset($_GET['pesan'])) { ?>
            <div class="alert alert-success py-2 mb-3">
                <?php 
                if ($_GET['pesan'] == 'tambah') echo "Data akun berhasil ditambahkan!";
                else if ($_GET['pesan'] == 'edit') echo "Data akun berhasil diperbarui!";
                else if ($_GET['pesan'] == 'hapus') echo "Data akun berhasil dihapus!";
                ?>
            </div>
        <?php } ?>

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form method="GET" action="index.php" class="d-flex gap-2" style="max-width: 480px; flex: 1;">
                <input type="text" name="cari" class="form-control" placeholder="Cari data akun..." value="<?php echo $cari; ?>">
                <button type="submit" class="btn btn-secondary px-3">Cari</button>
                <?php if (!empty($cari)) { ?>
                    <a href="index.php" class="btn btn-outline-secondary">Reset</a>
                <?php } ?>
            </form>
            <a href="tambah.php" class="btn btn-primary fw-semibold">+ Tambah Akun</a>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Identitas</th>
                            <th>Tipe Akun</th>
                            <th>Status</th>
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
                                <td class="text-secondary"><?php echo $row['email']; ?></td>
                                <td>
                                    <?php echo $row['identification_type']; ?>: <?php echo $row['identification_number']; ?>
                                </td>
                                <td>
                                    <?php echo $row['tipe_akun_nama']; ?>
                                </td>
                                <td>
                                    <?php echo $row['status']; ?>
                                </td>
                                <td class="text-center pe-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus akun ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            } 
                        } else {
                        ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data akun yang ditemukan.</td>
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
