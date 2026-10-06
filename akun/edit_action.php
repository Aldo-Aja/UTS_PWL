<?php
include '../conn.php';

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$account_type_id = $_POST['account_type_id'];
$status = $_POST['status'];
$identification_type = $_POST['identification_type'];
$identification_number = $_POST['identification_number'];
$updated_at = date('Y-m-d H:i:s');

if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE accounts SET name='$name', email='$email', password='$password', account_type_id='$account_type_id', status='$status', identification_type='$identification_type', identification_number='$identification_number', updated_at='$updated_at' WHERE id='$id'");
} else {
    mysqli_query($conn, "UPDATE accounts SET name='$name', email='$email', account_type_id='$account_type_id', status='$status', identification_type='$identification_type', identification_number='$identification_number', updated_at='$updated_at' WHERE id='$id'");
}

header("location:index.php?pesan=edit");
?>
