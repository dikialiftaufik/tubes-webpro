<?php
session_start(); // HARUS menjadi baris pertama sebelum output apapun

// Periksa apakah pengguna sudah login dan memiliki peran 'admin'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect ke halaman login jika tidak login atau bukan admin
    header("Location: login.php");
    exit();
}

require_once '../configdb.php'; // Koneksi database

$adminFullName = isset($_SESSION['user']['full_name']) ? htmlspecialchars($_SESSION['user']['full_name']) : 'Admin';

// --- Pengambilan Data untuk Kartu (Cards) ---

// Total Pelanggan
$role_pelanggan = 'customer'; // Pastikan ini sesuai dengan nilai peran pelanggan di tabel users
$sqlTotalCustomers = "SELECT COUNT(id) AS total_customers FROM users WHERE role = ?";
$stmtTotalCustomers = $conn->prepare($sqlTotalCustomers);
$totalCustomers = 0; // Default
if ($stmtTotalCustomers) {
    $stmtTotalCustomers->bind_param("s", $role_pelanggan);
    $stmtTotalCustomers->execute();
    $resultTotalCustomers = $stmtTotalCustomers->get_result();
    if ($resultTotalCustomers) {
        $data = $resultTotalCustomers->fetch_assoc();
        $totalCustomers = $data['total_customers'] ?? 0;
    }
    $stmtTotalCustomers->close();
} else {
    error_log("Error preparing statement for total customers: " . $conn->error);
}

// Total Item Menu
$resultTotalMenuItems = $conn->query("SELECT COUNT(id) AS total_menu_items FROM menu");
$totalMenuItems = $resultTotalMenuItems ? ($resultTotalMenuItems->fetch_assoc()['total_menu_items'] ?? 0) : 0;

// Total Pesanan (Orders) - Semua status
$resultTotalOrders = $conn->query("SELECT COUNT(id) AS total_orders FROM orders");
$totalOrders = $resultTotalOrders ? ($resultTotalOrders->fetch_assoc()['total_orders'] ?? 0) : 0;

// Total Reservasi Tertunda (Pending)
$resultPendingReservations = $conn->query("SELECT COUNT(id) AS total_pending_reservations FROM reservation WHERE status = 'pending'");
$pendingReservations = $resultPendingReservations ? ($resultPendingReservations->fetch_assoc()['total_pending_reservations'] ?? 0) : 0;

// --- Pengambilan Data untuk Grafik (Charts) ---

// Grafik 1: Registrasi Pelanggan dalam 6 Bulan Terakhir
$userRegLabels = [];
$userRegData = [];
$sqlUserReg = "SELECT COUNT(id) AS count FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND role = ?";
$stmtUserReg = $conn->prepare($sqlUserReg);
if ($stmtUserReg) {
    for ($i = 5; $i >= 0; $i--) {
        $monthYear = date('Y-m', strtotime("-$i month"));
        $monthName = date('M Y', strtotime("-$i month"));
        $userRegLabels[] = $monthName;

        $stmtUserReg->bind_param("ss", $monthYear, $role_pelanggan);
        $stmtUserReg->execute();
        $result = $stmtUserReg->get_result();
        $countData = $result->fetch_assoc();
        $userRegData[] = $countData['count'] ?? 0;
    }
    $stmtUserReg->close();
} else {
    error_log("Error preparing statement for user registration chart: " . $conn->error);
    for ($i = 5; $i >= 0; $i--) {
        $userRegLabels[] = date('M Y', strtotime("-$i month"));
        $userRegData[] = 0;
    }
}

// Grafik 2: Pendapatan Harian (14 Hari Terakhir, payment_status = 'paid')
$dailyRevenueLabels_14 = [];
$dailyRevenueData_14 = [];
$endDateRevenue_14 = new DateTime();
$startDateRevenue_14 = (new DateTime())->modify('-13 days'); // 14 hari termasuk hari ini

$dailyRevenues_14 = [];
// Menggunakan created_at dari tabel orders sebagai tanggal transaksi
$sqlDailyRevenue_14 = "SELECT DATE(created_at) AS tanggal, SUM(total_price) AS total_harian 
                       FROM orders 
                       WHERE  created_at >= ? AND created_at < ?
                       GROUP BY DATE(created_at) 
                       ORDER BY tanggal ASC";
$stmtDailyRevenue_14 = $conn->prepare($sqlDailyRevenue_14);

if ($stmtDailyRevenue_14) {
    // Format tanggal untuk query SQL (Y-m-d H:i:s atau Y-m-d jika kolomnya DATE)
    // Karena created_at adalah TIMESTAMP, kita gunakan H:i:s untuk mencakup seluruh hari
    $startDateStr_14 = $startDateRevenue_14->format('Y-m-d 00:00:00');
    $endDateStr_14 = $endDateRevenue_14->modify('+1 day')->format('Y-m-d 00:00:00'); // Sampai awal hari berikutnya

    $stmtDailyRevenue_14->bind_param("ss", $startDateStr_14, $endDateStr_14);
    $stmtDailyRevenue_14->execute();
    $resultDailyRevenue_14 = $stmtDailyRevenue_14->get_result();

    if ($resultDailyRevenue_14) {
        while ($row = $resultDailyRevenue_14->fetch_assoc()) {
            $dailyRevenues_14[$row['tanggal']] = $row['total_harian'];
        }
    } else {
        error_log("Error fetching daily revenue (14 days): " . $stmtDailyRevenue_14->error);
    }
    $stmtDailyRevenue_14->close();
    $endDateRevenue_14->modify('-1 day'); // Kembalikan ke tanggal hari ini untuk iterasi label
} else {
    error_log("Error preparing statement for daily revenue (14 days): " . $conn->error);
}

$interval_14 = new DateInterval('P1D');
// Periode untuk label, pastikan startDateRevenue_14 tidak dimodifikasi sebelum ini
$period_14 = new DatePeriod( (new DateTime())->modify('-13 days') , $interval_14, (new DateTime())->modify('+1 day') ); // Iterasi sampai hari ini

foreach ($period_14 as $dt) {
    $dateString = $dt->format('Y-m-d');
    $dailyRevenueLabels_14[] = $dt->format('d M'); // Label: "03 Jun"
    $dailyRevenueData_14[] = $dailyRevenues_14[$dateString] ?? 0;
}


// --- AWAL OUTPUT HTML ---
include '../views/header.php';
include '../views/sidebar.php';
?>

<div id="main-content">
    <?php include '../views/navbar.php'; ?>

    <div class="container-fluid pt-4 px-4">
        

        <div class="row g-4 my-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center p-4">
                        <i class="fas fa-users fa-3x text-primary me-3"></i>
                        <div>
                            <p class="mb-2 text-secondary">Total Pelanggan</p>
                            <h4 class="mb-0"><?php echo $totalCustomers; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center p-4">
                        <i class="fas fa-utensils fa-3x text-success me-3"></i>
                        <div>
                            <p class="mb-2 text-secondary">Total Item Menu</p>
                            <h4 class="mb-0"><?php echo $totalMenuItems; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center p-4">
                        <i class="fas fa-shopping-cart fa-3x text-warning me-3"></i>
                        <div>
                            <p class="mb-2 text-secondary">Total Pesanan</p>
                            <h4 class="mb-0"><?php echo $totalOrders; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card bg-light shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center p-4">
                        <i class="fas fa-calendar-check fa-3x text-info me-3"></i>
                        <div>
                            <p class="mb-2 text-secondary">Reservasi Tertunda</p>
                            <h4 class="mb-0"><?php echo $pendingReservations; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card bg-light shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Pendapatan Harian (14 Hari Terakhir)</h5>
                         <div style="height: 350px;">
                            <canvas id="dailyRevenueChart14Days"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-light shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Registrasi Pelanggan (6 Bulan)</h5>
                        <div style="height: 350px;"> 
                            <canvas id="userRegistrationsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../views/footer.php'; ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Grafik Registrasi Pengguna
    const userRegCtx = document.getElementById('userRegistrationsChart');
    if (userRegCtx) {
        new Chart(userRegCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($userRegLabels); ?>,
                datasets: [{
                    label: 'Pelanggan Baru',
                    data: <?php echo json_encode($userRegData); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#6c757d' },
                        grid: { color: "rgba(0, 0, 0, 0.05)" }
                    },
                    x: {
                        ticks: { color: '#6c757d' },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top', labels: { color: '#495057', usePointStyle: true, } },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.7)', titleColor: '#fff', bodyColor: '#fff',
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) { label += context.parsed.y; }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    // Grafik Pendapatan Harian (14 Hari)
    const dailyRevenueCtx14 = document.getElementById('dailyRevenueChart14Days');
    if (dailyRevenueCtx14) {
        new Chart(dailyRevenueCtx14, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dailyRevenueLabels_14); ?>,
                datasets: [{
                    label: 'Pendapatan Harian (Rp)',
                    data: <?php echo json_encode($dailyRevenueData_14); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(75, 192, 192, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6c757d',
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: { color: "rgba(0, 0, 0, 0.05)" }
                    },
                    x: {
                        ticks: { color: '#6c757d' },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top', labels: { color: '#495057', usePointStyle: true, } },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.7)', titleColor: '#fff', bodyColor: '#fff',
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
<?php
// $conn->close();
?>
