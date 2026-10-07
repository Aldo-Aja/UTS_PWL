<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "pbl_ti_2025_3c_revaldoparikesit";

$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Koneksi MySQL server gagal: " . mysqli_connect_error());
}

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$db_name`");
mysqli_select_db($conn, $db_name);

$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'accounts'");
if ($check_table && mysqli_num_rows($check_table) == 0) {
    $sql_file = __DIR__ . '/database.sql';
    if (file_exists($sql_file)) {
        $sql_content = file_get_contents($sql_file);
        if (mysqli_multi_query($conn, $sql_content)) {
            do {
                if ($result = mysqli_store_result($conn)) {
                    mysqli_free_result($result);
                }
            } while (mysqli_more_results($conn) && mysqli_next_result($conn));
        }
    }
}

function generate_uuid()
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
?>