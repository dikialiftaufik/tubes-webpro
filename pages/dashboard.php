<?php
// pages/dashboard.php
session_start();
$title = "Dashboard Admin";
require_once '../configdb.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil data untuk cards
$total_customers = 0;
$total_revenue = 0;
$pending_orders = 0;
$total_reservations = 0;

// Query total customers
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");
$stmt->execute();
$result = $stmt->get_result();
$total_customers = $result->fetch_assoc()['total'];

// Query total revenue
$stmt = $conn->prepare("SELECT SUM(total_price) AS total FROM orders WHERE payment_status = 'paid'");
$stmt->execute();
$result = $stmt->get_result();
$total_revenue = $result->fetch_assoc()['total'] ?? 0;

// Query pending orders
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE status = 'pending'");
$stmt->execute();
$result = $stmt->get_result();
$pending_orders = $result->fetch_assoc()['total'];

// Query total reservations
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM reservation");
$stmt->execute();
$result = $stmt->get_result();
$total_reservations = $result->fetch_assoc()['total'];

// Query data untuk chart (penjualan 6 bulan terakhir)
$sales_data = [];
$stmt = $conn->prepare("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') AS bulan,
        SUM(total_price) AS total
    FROM orders
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 5 MONTH)
    GROUP BY bulan
    ORDER BY bulan ASC
");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    $sales_data[$row['bulan']] = $row['total'];
}

include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<div class="main-content">
    <?php include '../views/alerts.php'; ?>
    
    <!-- Cards Section -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="bi bi-people-fill fs-2"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted mb-1">Total Pelanggan</h5>
                            <h2 class="mb-0"><?= number_format($total_customers) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle p-3 me-3">
                            <i class="bi bi-currency-dollar fs-2"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted mb-1">Total Pendapatan</h5>
                            <h2 class="mb-0">Rp <?= number_format($total_revenue, 0, ',', '.') ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle p-3 me-3">
                            <i class="bi bi-hourglass-split fs-2"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted mb-1">Pesanan Pending</h5>
                            <h2 class="mb-0"><?= number_format($pending_orders) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle p-3 me-3">
                            <i class="bi bi-calendar-check fs-2"></i>
                        </div>
                        <div>
                            <h5 class="card-title text-muted mb-1">Total Reservasi</h5>
                            <h2 class="mb-0"><?= number_format($total_reservations) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Analisis Penjualan 6 Bulan Terakhir</h5>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
// Data untuk chart
const salesData = {
    labels: <?= json_encode(array_map(function($month) {
        return date('M Y', strtotime($month.'-01'));
    }, array_keys($sales_data))) ?>,
    datasets: [{
        label: 'Total Penjualan',
        data: <?= json_encode(array_values($sales_data)) ?>,
        borderColor: '#4e73df',
        backgroundColor: '#4e73df20',
        tension: 0.4,
        fill: true
    }]
};

// Inisialisasi chart
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: salesData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>

<?php 
include '../views/footer.php';
$conn->close();
?>