<?php
include '../conn.php';

$id = generate_uuid();
$name = trim($_POST['name']);
$email = trim($_POST['email']);

if (!preg_match('/^[a-zA-Z0-9._%+-]+@pnj\.ac\.id$/i', $email)) {
    header("location:tambah.php?pesan=invalid_domain");
    exit;
}

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$account_type_id = $_POST['account_type_id'];
$status = $_POST['status'];
$identification_type = $_POST['identification_type'];
$identification_number = trim($_POST['identification_number']);
$created_at = date('Y-m-d H:i:s');

if ($identification_type == 'NIM') {
    if (!preg_match('/^[0-9]{10}$/', $identification_number)) {
        header("location:tambah.php?pesan=invalid_nim");
        exit;  
    }
} else if ($identification_type == 'NIP') {
    if (!preg_match('/^[0-9]{18}$/', $identification_number)) {
        header("location:tambah.php?pesan=invalid_nip");
        exit;  
    }
} else {
    header("location:tambah.php?pesan=invalid_identitas");
    exit;
}



mysqli_query($conn, "INSERT INTO accounts VALUES ('$id', '$name', '$email', '$password', '$account_type_id', '$status', '$identification_number', '$identification_type', '$created_at', NULL, NULL)");

header("location:index.php?pesan=tambah");
?>
