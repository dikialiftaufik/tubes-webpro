<?php
// pages/reservations.php
session_start();
require_once '../configdb.php';


// Konfigurasi pagination & parameter pencarian
$per_page_options = [10, 25, 50, 100];
$selected_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id','nama','tanggal','status']) ? $_GET['sort'] : 'tanggal';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

$offset = ($page - 1) * $selected_per_page;

// Query data reservasi
$query = "SELECT * FROM reservations 
          WHERE nama LIKE ? 
            OR jumlah_orang LIKE ? 
            OR pesanan LIKE ? 
            OR status LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT $selected_per_page OFFSET $offset";


$search_term = "%$search%";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
$reservations = $result->fetch_all(MYSQLI_ASSOC);

// Total data (query disesuaikan)
$total_query = "SELECT COUNT(*) AS total FROM reservations 
                WHERE nama LIKE ? 
                  OR jumlah_orang LIKE ? 
                  OR pesanan LIKE ? 
                  OR status LIKE ?";
// ... (sisanya sama, hanya ganti tabel ke reservations)

// ... (header, navbar, sidebar tetap sama)
?>

<div class="main-content">
    <?php include '../views/alerts.php'; ?>
    
    <!-- Search dan Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <!-- ... (form search tetap sama, hanya ganti placeholder) -->
            <input type="text" name="search" class="form-control" 
                   placeholder="Cari reservasi..." value="<?= htmlspecialchars($search) ?>">
        </div>
    </div>

    <!-- Tabel Reservasi -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">
                                <a href="?<?= http_build_query([
                                    'search' => $search,
                                    'sort' => 'id',
                                    'order' => ($sort_column === 'id' && $sort_order === 'ASC') ? 'DESC' : 'ASC',
                                    'per_page' => $selected_per_page
                                ]) ?>">
                                    ID <?= ($sort_column === 'id') ? ($sort_order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?= http_build_query([
                                    'search' => $search,
                                    'sort' => 'nama',
                                    'order' => ($sort_column === 'nama' && $sort_order === 'ASC') ? 'DESC' : 'ASC',
                                    'per_page' => $selected_per_page
                                ]) ?>">
                                    Nama <?= ($sort_column === 'nama') ? ($sort_order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th>Jml Orang</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Pesanan</th>
                            <th>
                                <a href="?<?= http_build_query([
                                    'search' => $search,
                                    'sort' => 'status',
                                    'order' => ($sort_column === 'status' && $sort_order === 'ASC') ? 'DESC' : 'ASC',
                                    'per_page' => $selected_per_page
                                ]) ?>">
                                    Status <?= ($sort_column === 'status') ? ($sort_order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservations as $res): ?>
                        <tr>
                            <td><?= $res['id'] ?></td>
                            <td><?= htmlspecialchars($res['nama']) ?></td>
                            <td><?= $res['jumlah_orang'] ?></td>
                            <td><?= date('d M Y', strtotime($res['tanggal'])) ?></td>
                            <td><?= $res['jam_mulai'] ?></td>
                            <td><?= $res['jam_selesai'] ?></td>
                            <td><?= htmlspecialchars($res['pesanan']) ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $res['status'] === 'Dikonfirmasi' ? 'success' : 
                                    ($res['status'] === 'Dibatalkan' ? 'danger' : 'warning') ?>">
                                    <?= $res['status'] ?>
                                </span>
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="edit_reservation.php?id=<?= $res['id'] ?>" 
                                   class="btn btn-sm btn-warning"
                                   data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <!-- Tombol Hapus -->
                                <form action="delete_reservation.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Hapus reservasi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (tetap sama) -->
        </div>
    </div>
</div>

<!-- ... (modal dan footer tetap sama) -->