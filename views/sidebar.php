<!-- views/sidebar.php -->
<div class="sidebar bg-light border-end vh-100 position-fixed" style="width: 280px;">
    <div class="sidebar-header p-4">
        <a href="dashboard.php" class="d-block text-decoration-none">
            <img src="../img/logo/logo2.png" alt="Logo" class="img-fluid mb-3" style="max-height: 140px;">
        </a>
    </div>
    
    <nav class="sidebar-menu p-3">
        <?php
        $allowed_pages = [
            'admin' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'bi-speedometer2',
                    'link' => 'dashboard.php'
                ],
                [
                    'label' => 'Report',
                    'icon' => 'bi-file-earmark-text',
                    'link' => 'report.php'
                ],
                [
                    'label' => 'Menu',
                    'icon' => 'bi-menu-button',
                    'link' => 'menu.php'
                ],
                [
                    'label' => 'Reservasi',
                    'icon' => 'bi-calendar',
                    'link' => 'reservation.php'
                ],
                [
                    'label' => 'Users',
                    'icon' => 'bi-people',
                    'link' => 'users.php'
                ],
                [
                    'label' => 'Notifikasi',
                    'icon' => 'bi-bell',
                    'link' => 'notification.php'
                ],
                [
                    'label' => 'Feedback',
                    'icon' => 'bi-chat-left-text',
                    'link' => 'feedback.php'
                ]
            ],
            'cashier' => [
                [
                    'label' => 'Kasir',
                    'icon' => 'bi-cash',
                    'link' => 'cashier.php'
                ],
                [
                    'label' => 'Pesanan',
                    'icon' => 'bi-cart',
                    'link' => 'order.php'
                ]
            ]
        ];

        $current_page = basename($_SERVER['SCRIPT_NAME']);
        $role = $_SESSION['user']['role'];
        
        foreach ($allowed_pages[$role] as $menu_item): 
            $is_active = ($current_page === $menu_item['link']) ? 'active' : '';
        ?>
            <a href="<?= $menu_item['link'] ?>" 
               class="d-flex align-items-center text-decoration-none text-dark mb-2 p-3 rounded <?= $is_active ?>"
               style="font-size: 1.1rem; transition: all 0.3s;">
                <i class="bi <?= $menu_item['icon'] ?> me-3" style="font-size: 1.2rem;"></i>
                <?= $menu_item['label'] ?>
            </a>
        <?php endforeach; ?>
    </nav>
</div>

<style>
    .sidebar-menu a.active {
        background: #0d6efd;
        color: white !important;
    }
    
    .sidebar-menu a:hover:not(.active) {
        background: #e9ecef;
    }
    
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
    }
</style>