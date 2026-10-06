<?php
include '../conn.php';

$id = $_GET['id'];
$deleted_at = date('Y-m-d H:i:s');

mysqli_query($conn, "UPDATE account_type SET deleted_at='$deleted_at' WHERE id='$id'");
header("location:index.php?pesan=hapus");
?>
