<!-- pages/cashier.php -->
<?php
session_start();
require_once '../configdb.php';

if ($_SESSION['user']['role'] !== 'cashier') {
    header("Location: dashboard.php");
    exit();
}

$title = "Dashboard Kasir";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<div class="main-content">
    <!-- Notifikasi -->
    <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <?= $_SESSION['success_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <!-- Konten khusus kasir -->
</div>

<?php include '../views/footer.php'; ?>