<?php
include '../conn.php';

$id = generate_uuid();
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$account_type_id = $_POST['account_type_id'];
$status = $_POST['status'];
$identification_type = $_POST['identification_type'];
$identification_number = $_POST['identification_number'];
$created_at = date('Y-m-d H:i:s');

mysqli_query($conn, "INSERT INTO accounts VALUES ('$id', '$name', '$email', '$password', '$account_type_id', '$status', '$identification_number', '$identification_type', '$created_at', NULL, NULL)");

header("location:index.php?pesan=tambah");
?>
