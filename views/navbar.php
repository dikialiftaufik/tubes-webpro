<?php
// navbar.php
require_once '../configdb.php';

// Query notifikasi
$notification_count = 0;
if(isset($_SESSION['user']['id'])) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->bind_param("i", $_SESSION['user']['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $notification_count = $result->fetch_assoc()['count'];
}

// Ambil data user untuk profil
$user_data = [];
if(isset($_SESSION['user']['id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user']['id']);
    $stmt->execute();
    $user_data = $stmt->get_result()->fetch_assoc();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
    <div class="container-fluid">
       
        <!-- Brand -->
        <div class="d-flex align-items-center">
           
            <span class="text-white fs-4 fw-bold d-none d-md-block">
                <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    $page_title = $title ?? 'Dashboard';
 $title = "Pesenan"; // di cashier.php
 $title = "Transaksi"; // di transaksi.php
 
?>

<span class="navbar-brand mb-0 h1 text-white">
    <?= $page_title ?>
</span>
        </div>

        <div class="collapse navbar-collapse" id="mainNavbar">
            
            <!-- Right Section -->
            <ul class="navbar-nav ms-auto align-items-center">
                
                <!-- Notifikasi -->
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle fs-4 position-relative" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bell-fill"></i>
                        <?php if($notification_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $notification_count ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width: 300px;">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
                        $stmt->bind_param("i", $_SESSION['user']['id']);
                        $stmt->execute();
                        $notifications = $stmt->get_result();
                        
                        if($notifications->num_rows > 0): 
                            while($notif = $notifications->fetch_assoc()): ?>
                                <li>
                                    <a class="dropdown-item <?= $notif['is_read'] ? 'text-muted' : 'fw-bold' ?>">
                                        <div class="d-flex justify-content-between">
                                            <small><?= date('d M H:i', strtotime($notif['created_at'])) ?></small>
                                            <?php if(!$notif['is_read']): ?>
                                                <span class="badge bg-primary">Baru</span>
                                            <?php endif; ?>
                                        </div>
                                        <?= htmlspecialchars($notif['message']) ?>
                                    </a>
                                </li>
                            <?php endwhile; 
                        else: ?>
                            <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <!-- Profile Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center py-0" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="d-flex align-items-center">
                            <img src="<?= !empty($user_data['profile_picture']) ? '../'.$user_data['profile_picture'] : 'https://via.placeholder.com/40' ?>" 
                                 class="rounded-circle me-2" 
                                 style="width: 45px; height: 45px; object-fit: cover;">
                            <div class="text-white">
                                <div class="fs-5 fw-bold"><?= $user_data['full_name'] ?? '' ?></div>
                                <small class="text-capitalize"><?= $user_data['role'] ?? '' ?></small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 200px;">
                        <li>
                            <a class="dropdown-item fs-5" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="bi bi-person-fill me-2"></i>Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item fs-5 text-danger" href="logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Include Profile Modal -->
<?php include 'profile_modal.php'; ?>

<style>
.navbar {
    font-size: 1.15rem;
}

.dropdown-menu {
    font-size: 1rem;
}

.nav-link.dropdown-toggle {
    padding: 0.5rem 1rem;
}

.bi-bell-fill, .bi-person-fill, .bi-box-arrow-right {
    font-size: 1.4rem;
}

.dropdown-item {
    padding: 0.75rem 1.5rem;
}

.badge {
    font-size: 0.75rem;
}
</style>