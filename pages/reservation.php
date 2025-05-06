<?php
// pages/reservasi.php
session_start();
require_once '../configdb.php';

// Cek auth admin
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Konfigurasi pagination
$per_page_options = [10, 25, 50, 100];
$selected_per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], $per_page_options) 
                    ? (int)$_GET['per_page'] 
                    : 10;

$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;

// Parameter pencarian dan sorting
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id','nama','jumlah_orang','tanggal','jam_mulai','jam_selesai','status']) ? $_GET['sort'] : 'tanggal';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

$search_term = "%$search%";
$offset = ($page - 1) * $selected_per_page;

// Query data
$query = "SELECT * FROM reservations 
          WHERE nama LIKE ? 
             OR pesanan LIKE ? 
             OR status LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("sssii", $search_term, $search_term, $search_term, $selected_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
$reservations = $result->fetch_all(MYSQLI_ASSOC);

// Total data
$total_query = "SELECT COUNT(*) AS total FROM reservations 
                WHERE nama LIKE ? 
                   OR pesanan LIKE ? 
                   OR status LIKE ?";
$stmt_total = $conn->prepare($total_query);
$stmt_total->bind_param("sss", $search_term, $search_term, $search_term);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_reservations = $total_row['total'];
$total_pages = ceil($total_reservations / $selected_per_page);

if ($total_pages > 0 && $page > $total_pages) {
    $query_params = [
        'search' => $search,
        'sort' => $sort_column,
        'order' => $sort_order,
        'per_page' => $selected_per_page,
        'page' => $total_pages
    ];
    header("Location: reservasi.php?" . http_build_query($query_params));
    exit();
}

$title = "Data Reservasi";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<div class="main-content">
    <?php include '../views/alerts.php'; ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
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
                        <input type="text" name="search" class="form-control" placeholder="Cari reservasi..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="reservasi.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jumlah Orang</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Pesanan</th>
                            <th>Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservations as $res): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['id']) ?></td>
                            <td><?= htmlspecialchars($res['nama']) ?></td>
                            <td><?= htmlspecialchars($res['jumlah_orang']) ?></td>
                            <td><?= htmlspecialchars($res['tanggal']) ?></td>
                            <td><?= htmlspecialchars($res['jam_mulai']) ?></td>
                            <td><?= htmlspecialchars($res['jam_selesai']) ?></td>
                            <td><?= htmlspecialchars($res['pesanan']) ?></td>
                            <td><?= htmlspecialchars($res['status']) ?></td>
                            <td>
                                <a href="view_reservation.php?id=<?= $res['id'] ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="edit_reservation.php?id=<?= $res['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="delete_reservation.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus reservasi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (count($reservations) === 0): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data ditemukan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
include '../views/footer.php';
$conn->close();
?>
