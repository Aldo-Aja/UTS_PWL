<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['account_type_name']) || $_SESSION['account_type_name'] != 'Admin') {
    header("location:index.php");
    exit;
}

$id = $_GET['id'];
$deleted_at = date('Y-m-d H:i:s');

mysqli_query($conn, "UPDATE accounts SET deleted_at='$deleted_at' WHERE id='$id'");
header("location:index.php?pesan=hapus");
?>
