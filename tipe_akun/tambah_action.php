<?php
include '../conn.php';

$id = generate_uuid();
$name = $_POST['name'];
$description = $_POST['description'];
$created_at = date('Y-m-d H:i:s');

mysqli_query($conn, "INSERT INTO account_type VALUES ('$id', '$name', '$description', '$created_at', NULL, NULL)");

header("location:index.php?pesan=tambah");
?>
