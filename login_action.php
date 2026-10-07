<?php
session_start();
include 'conn.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

if (!preg_match('/^[a-zA-Z0-9._%+-]+@pnj\.ac\.id$/i', $email)) {
    header("location:login.php?pesan=domain");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM accounts WHERE email='$email' AND deleted_at IS NULL");
$row = mysqli_fetch_array($query);

if ($row && password_verify($password, $row['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $row['email'];
    header("location:index.php");
} else {
    header("location:login.php?pesan=gagal");
}
?>
