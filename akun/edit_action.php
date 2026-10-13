<?php
include '../conn.php';

$id = $_POST['id'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);

if (!preg_match('/^[a-zA-Z0-9._%+-]+@pnj\.ac\.id$/i', $email)) {
    header("location:edit.php?id=" . urlencode($id) . "&pesan=invalid_domain");
    exit;
}

$account_type_id = $_POST['account_type_id'];
$status = $_POST['status'];
$identification_type = $_POST['identification_type'];
$identification_number = trim($_POST['identification_number']);
$updated_at = date('Y-m-d H:i:s');

if ($identification_type == 'NIM') {
    if (!preg_match('/^[0-9]{10}$/', $identification_number)) {
        header("location:edit.php?id=" . urlencode($id) . "&pesan=invalid_nim");
        exit;  
    }
} else if ($identification_type == 'NIP') {
    if (!preg_match('/^[0-9]{18}$/', $identification_number)) {
        header("location:edit.php?id=" . urlencode($id) . "&pesan=invalid_nip");
        exit;  
    }
} else {
    header("location:edit.php?id=" . urlencode($id) . "&pesan=invalid_identitas");
    exit;
}

if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE accounts SET name='$name', email='$email', password='$password', account_type_id='$account_type_id', status='$status', identification_type='$identification_type', identification_number='$identification_number', updated_at='$updated_at' WHERE id='$id'");
} else {
    mysqli_query($conn, "UPDATE accounts SET name='$name', email='$email', account_type_id='$account_type_id', status='$status', identification_type='$identification_type', identification_number='$identification_number', updated_at='$updated_at' WHERE id='$id'");
}

header("location:index.php?pesan=edit");
?>
