<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

    <div class="container" style="max-width: 420px;">
        <div class="card shadow-sm border-0 rounded-3 p-4 bg-white">
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-1 text-dark">Manajemen Akun</h4>
                <p class="text-muted small mb-0">Masuk pakai email dan password kamu.</p>
            </div>

            <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') { ?>
                <div class="alert alert-danger py-2 small mb-3">Email atau password salah!</div>
            <?php } ?>

            <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout') { ?>
                <div class="alert alert-success py-2 small mb-3">Anda telah berhasil keluar.</div>
            <?php } ?>

            <form action="login_action.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="admin@it.pnj.ac.id" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label small fw-semibold text-secondary">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Login
                </button>
            </form>
        </div>
    </div>

</body>
</html>
