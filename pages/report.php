<?php
// pages/laporan.php
session_start();
require_once '../configdb.php';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Cek auth admin
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Tangkap parameter filter tanggal
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Handle export PDF
if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
    // Include library PDF (misalnya TCPDF atau FPDF)
    require_once '../vendor/tcpdf/tcpdf.php';
    
    // Query untuk export dengan filter tanggal jika ada
    $export_query = "SELECT id_transaksi, nama_pelanggan, email, tanggal_transaksi, pesanan, total_harga, metode_pembayaran FROM laporan";
    
    $where = [];
    $params = [];
    
    if (!empty($start_date)) {
        $where[] = "DATE(tanggal_transaksi) >= ?";
        $params[] = $start_date;
    }
    
    if (!empty($end_date)) {
        $where[] = "DATE(tanggal_transaksi) <= ?";
        $params[] = $end_date;
    }
    
    if (!empty($where)) {
        $export_query .= " WHERE " . implode(" AND ", $where);
    }
    
    $export_query .= " ORDER BY tanggal_transaksi DESC";
    
    $stmt = $conn->prepare($export_query);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $export_result = $stmt->get_result();
    
    // Setup PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Laporan Transaksi', 0, 1, 'C');
    
    // Tambahkan informasi filter tanggal jika ada
    if (!empty($start_date) || !empty($end_date)) {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 8, 'Periode: ' . (!empty($start_date) ? date('d/m/Y', strtotime($start_date)) : 'Awal') . 
                     ' - ' . (!empty($end_date) ? date('d/m/Y', strtotime($end_date)) : 'Akhir'), 0, 1, 'C');
    }
    
    $pdf->Ln(5);
    
    // Table header
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(20, 8, 'No', 1);
    $pdf->Cell(30, 8, 'ID Transaksi', 1);
    $pdf->Cell(40, 8, 'Nama Pelanggan', 1);
    $pdf->Cell(50, 8, 'Email', 1);
    $pdf->Cell(30, 8, 'Tanggal', 1);
    $pdf->Cell(40, 8, 'Total Harga', 1);
    $pdf->Cell(30, 8, 'Metode', 1);
    $pdf->Ln();
    
    // Table content
    $pdf->SetFont('helvetica', '', 9);
    $no = 1;
    while($row = $export_result->fetch_assoc()) {
        $pdf->Cell(20, 8, $no++, 1);
        $pdf->Cell(30, 8, $row['id_transaksi'], 1);
        $pdf->Cell(40, 8, substr($row['nama_pelanggan'], 0, 15), 1);
        $pdf->Cell(50, 8, substr($row['email'], 0, 20), 1);
        // Tampilkan tanggal dan jam
        $pdf->Cell(30, 8, date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])), 1);
        $pdf->Cell(40, 8, 'Rp ' . number_format($row['total_harga'], 0, ',', '.'), 1);
        $pdf->Cell(30, 8, $row['metode_pembayaran'], 1);
        $pdf->Ln();
    }
    
    $pdf->Output('laporan_transaksi.pdf', 'D');
    exit();
}

// Handle export Excel
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="laporan_transaksi.xls"');
    header('Cache-Control: max-age=0');
    
    echo '<table border="1">';
    echo '<tr><th colspan="8">Laporan Transaksi</th></tr>';
    
    // Tambahkan informasi filter tanggal jika ada
    if (!empty($start_date) || !empty($end_date)) {
        echo '<tr><th colspan="8">Periode: ' . 
             (!empty($start_date) ? date('d/m/Y', strtotime($start_date)) : 'Awal') . 
             ' - ' . (!empty($end_date) ? date('d/m/Y', strtotime($end_date)) : 'Akhir') . 
             '</th></tr>';
    }
    
    echo '<tr><th>No</th><th>ID Transaksi</th><th>Nama Pelanggan</th><th>Email</th><th>Tanggal Transaksi</th><th>Pesanan</th><th>Total Harga</th><th>Metode Pembayaran</th></tr>';
    
    // Query untuk export dengan filter tanggal jika ada
    $export_query = "SELECT id_transaksi, nama_pelanggan, email, tanggal_transaksi, pesanan, total_harga, metode_pembayaran FROM laporan";
    
    $where = [];
    $params = [];
    
    if (!empty($start_date)) {
        $where[] = "DATE(tanggal_transaksi) >= ?";
        $params[] = $start_date;
    }
    
    if (!empty($end_date)) {
        $where[] = "DATE(tanggal_transaksi) <= ?";
        $params[] = $end_date;
    }
    
    if (!empty($where)) {
        $export_query .= " WHERE " . implode(" AND ", $where);
    }
    
    $export_query .= " ORDER BY tanggal_transaksi DESC";
    
    $stmt = $conn->prepare($export_query);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $export_result = $stmt->get_result();
    $no = 1;
    
    while($row = $export_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . $row['id_transaksi'] . '</td>';
        echo '<td>' . $row['nama_pelanggan'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        // Tampilkan tanggal dan jam
        echo '<td>' . date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])) . '</td>';
        echo '<td>' . $row['pesanan'] . '</td>';
        echo '<td>Rp ' . number_format($row['total_harga'], 0, ',', '.') . '</td>';
        echo '<td>' . $row['metode_pembayaran'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    exit();
}

// Fungsi untuk handle create transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        die(json_encode(['message' => 'Invalid CSRF token']));
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        // Sanitize input
        $id_transaksi = filter_var($_POST['id_transaksi'], FILTER_SANITIZE_STRING);
        $nama_pelanggan = filter_var($_POST['nama_pelanggan'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $waktu_transaksi = $_POST['waktu_transaksi'];
        
        // Validasi format tanggal (YYYY-MM-DD) dan waktu (HH:MM)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_transaksi) || 
            !preg_match('/^\d{2}:\d{2}$/', $waktu_transaksi)) {
            http_response_code(400);
            die(json_encode(['message' => 'Format tanggal atau waktu tidak valid']));
        }
        
        // Gabungkan tanggal dan waktu
        $tanggal_waktu = $tanggal_transaksi . ' ' . $waktu_transaksi . ':00';
        
        // Ambil pesanan sebagai array
        $pesanan = $_POST['pesanan'];
        // Validasi: pastikan setidaknya ada satu pesanan
        if (empty($pesanan)) {
            http_response_code(400);
            die(json_encode(['message' => 'Pesanan tidak boleh kosong']));
        }
        // Konversi array pesanan menjadi JSON
        $pesanan_json = json_encode($pesanan);
        
        $total_harga = filter_var($_POST['total_harga'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $metode_pembayaran = filter_var($_POST['metode_pembayaran'], FILTER_SANITIZE_STRING);

        // Debugging: log input data
        error_log("Inserting transaction: $id_transaksi, $nama_pelanggan, $email, $tanggal_waktu, $pesanan_json, $total_harga, $metode_pembayaran");

        // Query INSERT menggunakan kolom id_transaksi
        $stmt = $conn->prepare("INSERT INTO laporan 
            (id_transaksi, nama_pelanggan, email, tanggal_transaksi, pesanan, total_harga, metode_pembayaran, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        
        // Handle prepare error
        if (!$stmt) {
            $error = $conn->error;
            error_log("Prepare failed: $error");
            http_response_code(500);
            die(json_encode(['message' => 'Database error: ' . $error]));
        }
        
        $stmt->bind_param("sssssss", 
            $id_transaksi,
            $nama_pelanggan, 
            $email, 
            $tanggal_waktu, 
            $pesanan_json,  // Gunakan JSON
            $total_harga, 
            $metode_pembayaran
        );
        
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Transaksi berhasil ditambahkan']);
        } else {
            $error = $stmt->error;
            error_log("Execute failed: $error");
            error_log("ERROR DETAILS: " . print_r($stmt->error_list, true));
            http_response_code(500);
            echo json_encode(['message' => 'Gagal menambahkan transaksi: ' . $error]);
        }
        exit();
    }
}

// Konfigurasi pagination dan sorting
$per_page_options = [10, 25, 50, 100];
$selected_per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], $per_page_options) 
                    ? (int)$_GET['per_page'] 
                    : 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$search = isset($_GET['search']) ? $conn->real_escape_string(strip_tags($_GET['search'])) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id_transaksi','nama_pelanggan','email','tanggal_transaksi','total_harga']) ? $_GET['sort'] : 'tanggal_transaksi';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';
$search_term = "%$search%";
$offset = ($page - 1) * $selected_per_page;

// Query untuk mengambil data transaksi dengan filter
$query = "SELECT id_transaksi, nama_pelanggan, email, tanggal_transaksi, pesanan, total_harga, metode_pembayaran FROM laporan 
          WHERE (nama_pelanggan LIKE ? 
             OR email LIKE ? 
             OR pesanan LIKE ? 
             OR metode_pembayaran LIKE ?)";
$params = ["ssss", $search_term, $search_term, $search_term, $search_term];

// Tambahkan filter rentang tanggal jika ada
if (!empty($start_date)) {
    $query .= " AND DATE(tanggal_transaksi) >= ?";
    $params[0] .= "s";
    $params[] = $start_date;
}

if (!empty($end_date)) {
    $query .= " AND DATE(tanggal_transaksi) <= ?";
    $params[0] .= "s";
    $params[] = $end_date;
}

$query .= " ORDER BY $sort_column $sort_order 
          LIMIT $selected_per_page OFFSET $offset";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}

// PERBAIKAN: Binding parameter yang benar
$ref_params = []; // Array of references
foreach ($params as $key => $value) {
    $ref_params[$key] = &$params[$key];
}
call_user_func_array([$stmt, 'bind_param'], $ref_params);

$stmt->execute();
$result = $stmt->get_result();
$transaksi = $result->fetch_all(MYSQLI_ASSOC);

// Total data untuk pagination
$total_query = "SELECT COUNT(*) AS total FROM laporan 
                WHERE (nama_pelanggan LIKE ? 
                   OR email LIKE ? 
                   OR pesanan LIKE ? 
                   OR metode_pembayaran LIKE ?)";
$total_params = ["ssss", $search_term, $search_term, $search_term, $search_term];

if (!empty($start_date)) {
    $total_query .= " AND DATE(tanggal_transaksi) >= ?";
    $total_params[0] .= "s";
    $total_params[] = $start_date;
}

if (!empty($end_date)) {
    $total_query .= " AND DATE(tanggal_transaksi) <= ?";
    $total_params[0] .= "s";
    $total_params[] = $end_date;
}

$stmt_total = $conn->prepare($total_query);
if (!$stmt_total) {
    die("Error preparing total query: " . $conn->error);
}

// PERBAIKAN: Binding parameter yang benar
$ref_total_params = []; // Array of references
foreach ($total_params as $key => $value) {
    $ref_total_params[$key] = &$total_params[$key];
}
call_user_func_array([$stmt_total, 'bind_param'], $ref_total_params);

$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_transaksi = $total_row['total'];
$total_pages = ceil($total_transaksi / $selected_per_page);
$page = min($page, $total_pages);

$title = "Laporan Transaksi";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<div class="main-content">
    <?php include '../views/alerts.php'; ?>
    
    <div class="d-flex justify-content-between mb-3 mt-4">
        <h2>Laporan Transaksi</h2>
        <div class="d-flex align-items-center">
            <!-- Date Range Picker -->
            <div class="input-group me-3" style="width: 450px;">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                <input 
                    type="date" 
                    id="startDate" 
                    class="form-control" 
                    value="<?= htmlspecialchars($start_date ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Tanggal Mulai"
                >
                <span class="input-group-text">s/d</span>
                <input 
                    type="date" 
                    id="endDate" 
                    class="form-control" 
                    value="<?= htmlspecialchars($end_date ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Tanggal Akhir"
                >
                <button 
                    class="btn btn-outline-secondary" 
                    type="button" 
                    id="clearDate"
                    title="Clear filter"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <!-- Tombol Tambah dan Export -->
            <div>
                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createTransactionModal">
                    <i class="bi bi-plus-circle"></i> Tambah Transaksi
                </button>
                <a href="?export=excel&amp;start_date=<?= !empty($start_date) ? urlencode($start_date) : '' ?>&amp;end_date=<?= !empty($end_date) ? urlencode($end_date) : '' ?>" 
                class="btn btn-success me-2">
                    <i class="bi bi-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
    </div>

    <?php if ($start_date || $end_date): ?>
    <div class="alert alert-info d-flex align-items-center py-2 mb-3">
        <i class="bi bi-info-circle me-2"></i>
        Menampilkan transaksi dari tanggal: 
        <strong class="mx-1"><?= !empty($start_date) ? htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8') : 'Awal' ?></strong> 
        sampai 
        <strong class="mx-1"><?= !empty($end_date) ? htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8') : 'Akhir' ?></strong>
        <a href="?" class="ms-2 text-danger">
            <i class="bi bi-x-circle"></i> Hapus filter
        </a>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">Show</span>
                        <select class="form-select" name="per_page" onchange="this.form.submit()">
                            <?php foreach($per_page_options as $option): ?>
                            <option value="<?= $option ?>" <?= $selected_per_page == $option ? 'selected' : '' ?>>
                                <?= $option ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari transaksi..." value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="report.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
                <!-- Sembunyikan input rentang tanggal agar tidak hilang saat form search disubmit -->
                <?php if ($start_date): ?>
                <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8') ?>">
                <?php endif; ?>
                <?php if ($end_date): ?>
                <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8') ?>">
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="transactionTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi
                                    <?php if($sort_column == 'id_transaksi'): ?>
                                        
                                    <?php endif; ?>
                            </th>
                            <th>Nama Pelanggan</th>
                            <th>Email</th>
                            <th>Tanggal Transaksi</th>
                            <th>Pesanan</th>
                            <th>Total Harga</th>
                            <th>Metode Pembayaran</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = ($page - 1) * $selected_per_page + 1;
                        foreach($transaksi as $trans): 
                            // Parse pesanan jika JSON, jika tidak, gunakan string biasa
                            $pesanan = $trans['pesanan'];
                            $pesananArray = json_decode($pesanan);
                            $isArray = is_array($pesananArray);
                        ?>
                        <tr data-pesanan="<?= htmlspecialchars($pesanan, ENT_QUOTES, 'UTF-8') ?>">
                            <td><?= $no++ ?></td>
                            <td><span class="badge bg-primary"><?= htmlspecialchars($trans['id_transaksi'], ENT_QUOTES, 'UTF-8') ?></span></td>
                            <td><?= htmlspecialchars($trans['nama_pelanggan'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($trans['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <!-- Tampilkan tanggal dan jam -->
                            <td><?= date('d/m/Y H:i', strtotime($trans['tanggal_transaksi'])) ?></td>
                            <td>
                                <?php if ($isArray): ?>
                                    <ul class="mb-0">
                                        <?php foreach($pesananArray as $item): ?>
                                            <li><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="<?= htmlspecialchars($pesanan, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($pesanan, ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><strong class="text-success">Rp <?= number_format($trans['total_harga'], 0, ',', '.') ?></strong></td>
                            <td>
                                <span class="badge bg-<?= $trans['metode_pembayaran'] == 'cash' ? 'success' : 'info' ?>">
                                    <?= htmlspecialchars($trans['metode_pembayaran'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info view-btn" data-id="<?= $trans['id_transaksi'] ?>" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-primary print-btn" 
                                    data-id="<?= htmlspecialchars($trans['id_transaksi'], ENT_QUOTES, 'UTF-8') ?>" 
                                    title="Cetak"
                                >
                                    <i class="bi bi-printer"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>&per_page=<?= $selected_per_page ?>&search=<?= urlencode($search) ?><?= $start_date ? '&start_date='.urlencode($start_date) : '' ?><?= $end_date ? '&end_date='.urlencode($end_date) : '' ?>">Previous</a>
                    </li>
                    
                    <?php for($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&per_page=<?= $selected_per_page ?>&search=<?= urlencode($search) ?><?= $start_date ? '&start_date='.urlencode($start_date) : '' ?><?= $end_date ? '&end_date='.urlencode($end_date) : '' ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>&per_page=<?= $selected_per_page ?>&search=<?= urlencode($search) ?><?= $start_date ? '&start_date='.urlencode($start_date) : '' ?><?= $end_date ? '&end_date='.urlencode($end_date) : '' ?>">Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Create Transaction -->
<div class="modal fade" id="createTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Transaksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createTransactionForm">
                    <!-- FIX: Add CSRF token to form -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">ID Transaksi:</label>
                                <input type="text" name="id_transaksi" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pelanggan:</label>
                                <input type="text" name="nama_pelanggan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control" placeholder="nama@gmail.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal & Waktu Transaksi:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="date" name="tanggal_transaksi" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="time" name="waktu_transaksi" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Harga:</label>
                                <input type="number" step="500" min="1000" name="total_harga" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran:</label>
                                <select name="metode_pembayaran" class="form-select" required>
                                    <option value="">Pilih Metode</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Qris">Qris</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pesanan:</label>
                                <div id="pesanan-container">
                                    <div class="input-group mb-2">
                                        <input type="text" name="pesanan[]" class="form-control" placeholder="Nama menu" required>
                                        <button type="button" class="btn btn-outline-danger remove-pesanan"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                                <button type="button" id="add-pesanan" class="btn btn-sm btn-secondary">Tambah Pesanan</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Transaction -->
<div class="modal fade" id="detailTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><td><strong>ID Transaksi:</strong></td><td id="detailId"></td></tr>
                            <tr><td><strong>Nama Pelanggan:</strong></td><td id="detailNama"></td></tr>
                            <tr><td><strong>Email:</strong></td><td id="detailEmail"></td></tr>
                            <tr><td><strong>Tanggal & Waktu:</strong></td><td id="detailTanggal"></td></tr>
                            <tr><td><strong>Total Harga:</strong></td><td id="detailTotal" class="text-success fw-bold"></td></tr>
                            <tr><td><strong>Metode Pembayaran:</strong></td><td id="detailMetode"></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Detail Pesanan:</strong></h6>
                        <div id="detailPesanan" class="border p-3 rounded bg-light" style="min-height: 200px; white-space: pre-wrap;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printDetailBtn">
                    <i class="bi bi-printer"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {

    // Set default date to today (only date, no time)
    $('input[name="tanggal_transaksi"]').val(new Date().toISOString().split('T')[0]);
    
    // Set default time to current time
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    $('input[name="waktu_transaksi"]').val(`${hours}:${minutes}`);

    // Handle Create Transaction
    $('#createTransactionForm').submit(function(e) {
        e.preventDefault();
        
        // Validasi tanggal dan waktu
        const tanggalInput = $('input[name="tanggal_transaksi"]').val();
        const waktuInput = $('input[name="waktu_transaksi"]').val();
        
        if (!/^\d{4}-\d{2}-\d{2}$/.test(tanggalInput) || 
            !/^\d{2}:\d{2}$/.test(waktuInput)) {
            alert('Format tanggal atau waktu tidak valid');
            return;
        }

        const formData = {
            action: 'create',
            ...Object.fromEntries(new FormData(this).entries())
        };

        // Tampilkan loading indicator
        const submitBtn = $(this).find('[type="submit"]');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');

        $.post('report.php', formData, function(response) {
            alert(response.message);
            $('#createTransactionModal').modal('hide');
            location.reload();
        }, 'json').fail(function(xhr) {
            let errorMsg = 'Error: ' + (xhr.responseJSON?.message || 'Server Error');
            if (xhr.status === 500 && xhr.responseJSON?.message) {
                errorMsg = xhr.responseJSON.message;
            }
            alert(errorMsg);
        }).always(function() {
            submitBtn.prop('disabled', false).html('<i class="bi bi-save"></i> Simpan Transaksi');
        });
    });

    // Handle View Detail
    $(document).on('click', '.view-btn', function() {
        const row = $(this).closest('tr');
        const pesanan = row.data('pesanan');
        
        try {
            const pesananArray = JSON.parse(pesanan);
            let html = '<ul>';
            pesananArray.forEach(item => {
                html += `<li>${item}</li>`;
            });
            html += '</ul>';
            $('#detailPesanan').html(html);
        } catch (e) {
            $('#detailPesanan').text(pesanan);
        }
        
        $('#detailId').text(row.find('td:eq(1) span.badge').text());
        $('#detailNama').text(row.find('td:eq(2)').text());
        $('#detailEmail').text(row.find('td:eq(3)').text());
        $('#detailTanggal').text(row.find('td:eq(4)').text());
        $('#detailTotal').text(row.find('td:eq(6) strong').text());
        $('#detailMetode').html(row.find('td:eq(7) span').clone().wrap('<div>').parent().html());
        
        $('#detailTransactionModal').modal('show');
    });

    // Handle Print Individual Transaction
    $(document).on('click', '.print-btn', function() {
        const id = $(this).data('id');
        window.open('print_transaksi.php?id=' + id, '_blank');
    });

    // Handle Print from Detail Modal
    $('#printDetailBtn').click(function() {
        const id = $('#detailId').text();
        window.open('print_transaksi.php?id=' + id, '_blank');
    });

    // Handle Date Range Filter Change
    function applyDateFilter() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const url = new URL(window.location);
        
        if (startDate) {
            url.searchParams.set('start_date', startDate);
        } else {
            url.searchParams.delete('start_date');
        }
        
        if (endDate) {
            url.searchParams.set('end_date', endDate);
        } else {
            url.searchParams.delete('end_date');
        }
        
        // Reset ke halaman 1
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    }

    // Terapkan filter ketika tanggal diubah
    $('#startDate, #endDate').change(applyDateFilter);

    // Handle Clear Date Button
    $('#clearDate').click(function() {
        $('#startDate').val('');
        $('#endDate').val('');
        const url = new URL(window.location);
        url.searchParams.delete('start_date');
        url.searchParams.delete('end_date');
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    });

    // Set nilai date picker jika ada parameter
    <?php if ($start_date): ?>
        $('#startDate').val('<?= $start_date ?>');
    <?php endif; ?>
    <?php if ($end_date): ?>
        $('#endDate').val('<?= $end_date ?>');
    <?php endif; ?>

    // Tambah input pesanan
    $('#add-pesanan').click(function() {
        $('#pesanan-container').append(`
            <div class="input-group mb-2">
                <input type="text" name="pesanan[]" class="form-control" placeholder="Nama menu" required>
                <button type="button" class="btn btn-outline-danger remove-pesanan"><i class="bi bi-trash"></i></button>
            </div>
        `);
    });

    // Hapus input pesanan
    $(document).on('click', '.remove-pesanan', function() {
        $(this).closest('.input-group').remove();
    });
});
</script>

<?php 
include '../views/footer.php'; 
$conn->close();
?>