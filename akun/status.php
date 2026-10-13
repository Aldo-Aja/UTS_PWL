<?php
include '../conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $cek_status = mysqli_query($conn, "SELECT status FROM accounts WHERE id = '$id'");
    $data = mysqli_fetch_assoc($cek_status);

    if ($data) {
        $status_baru = ($data['status'] == 'Aktif') ? 'Nonaktif' : 'Aktif';

        $update = mysqli_query($conn, "UPDATE accounts SET status = '$status_baru', updated_at = NOW() WHERE id = '$id'");

        if ($update) {
            header("Location: index.php?pesan=status");
            exit;
        }
    }
}

header("Location: index.php");
exit;
?>


