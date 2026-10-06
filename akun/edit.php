<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include '../conn.php';

$base_url = "../";
$active_menu = "akun";

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM accounts WHERE id='$id' AND deleted_at IS NULL");
$data = mysqli_fetch_array($query);

if (!$data) {
    header("Location: index.php");
    exit;
}

$tipe_akun_data = mysqli_query($conn, "SELECT * FROM account_type WHERE deleted_at IS NULL ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex min-vh-100">
    <?php include '../components/sidebar.php'; ?>

    <div class="flex-grow-1 bg-light p-4">
        <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 800px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-dark">Edit Akun</h5>
            </div>
            <div class="card-body p-4">
                <form action="edit_action.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label small fw-semibold text-secondary">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-semibold text-secondary">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-secondary">Password <small class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah password)</small></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="account_type_id" class="form-label small fw-semibold text-secondary">Tipe Akun</label>
                            <select class="form-select" id="account_type_id" name="account_type_id" required>
                                <option value="">-- Pilih Tipe Akun --</option>
                                <?php while ($tipe = mysqli_fetch_array($tipe_akun_data)) { ?>
                                    <option value="<?php echo $tipe['id']; ?>" <?php if ($tipe['id'] == $data['account_type_id']) echo 'selected'; ?>>
                                        <?php echo $tipe['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label small fw-semibold text-secondary">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Aktif" <?php if ($data['status'] == 'Aktif') echo 'selected'; ?>>Aktif</option>
                                <option value="Nonaktif" <?php if ($data['status'] == 'Nonaktif') echo 'selected'; ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="identification_type" class="form-label small fw-semibold text-secondary">Jenis Identitas</label>
                            <select class="form-select" id="identification_type" name="identification_type" required>
                                <option value="NIM" <?php if ($data['identification_type'] == 'NIM') echo 'selected'; ?>>NIM</option>
                                <option value="NIP" <?php if ($data['identification_type'] == 'NIP') echo 'selected'; ?>>NIP</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="identification_number" class="form-label small fw-semibold text-secondary">Nomor Identitas (NIM / NIP)</label>
                            <input type="text" class="form-control" id="identification_number" name="identification_number" value="<?php echo $data['identification_number']; ?>" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan Perubahan</button>
                        <a href="index.php" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
