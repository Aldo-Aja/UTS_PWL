<?php
if (!isset($base_url)) {
    $base_url = "./";
}
if (!isset($active_menu)) {
    $active_menu = "";
}
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Administrator';
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'admin@it.pnj.ac.id';
?>
<div class="d-flex flex-column flex-shrink-0 bg-dark text-white" style="width: 240px; min-height: 100vh;">
    <div class="p-3 border-bottom border-secondary">
        <a href="<?php echo $base_url; ?>index.php" class="text-white text-decoration-none">
            <span class="fs-5 fw-bold d-block">Manajemen Akun</span>
        </a>
    </div>

    <ul class="nav nav-pills flex-column p-3 gap-1 mb-auto">
        <li class="nav-item">
            <a href="<?php echo $base_url; ?>index.php" class="nav-link text-white <?php echo ($active_menu == 'beranda') ? 'active bg-primary' : ''; ?>">
                Beranda
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $base_url; ?>akun/index.php" class="nav-link text-white <?php echo ($active_menu == 'akun') ? 'active bg-primary' : ''; ?>">
                Data Akun
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $base_url; ?>tipe_akun/index.php" class="nav-link text-white <?php echo ($active_menu == 'tipe_akun') ? 'active bg-primary' : ''; ?>">
                Tipe Akun
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $base_url; ?>jenis_aksi/index.php" class="nav-link text-white <?php echo ($active_menu == 'jenis_aksi') ? 'active bg-primary' : ''; ?>">
                Jenis Aksi
            </a>
        </li>
    </ul>

    <div class="p-3 border-top border-secondary">
        <div class="mb-2">
            <div class="fw-semibold small text-truncate"><?php echo $user_name; ?></div>
            <div class="text-white-50 small text-truncate" style="font-size: 11px;"><?php echo $user_email; ?></div>
        </div>
        <a href="<?php echo $base_url; ?>logout.php" class="btn btn-outline-danger btn-sm w-100">
            Logout
        </a>
    </div>
</div>
