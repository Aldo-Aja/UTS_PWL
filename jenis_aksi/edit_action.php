<?php
include '../conn.php';

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$updated_at = date('Y-m-d H:i:s');

mysqli_query($conn, "UPDATE actions SET name='$name', description='$description', updated_at='$updated_at' WHERE id='$id'");

header("location:index.php?pesan=edit");
?>
