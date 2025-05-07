<?php
// pages/reservasi.php
session_start();
require_once '../configdb.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$per_page_options = [10, 25, 50, 100];
$selected_per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], $per_page_options)
    ? (int)$_GET['per_page']
    : 10;

$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id','nama','jumlah_orang','tanggal','jam_mulai','jam_selesai','status']) ? $_GET['sort'] : 'tanggal';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

$search_term = "%$search%";
$offset = ($page - 1) * $selected_per_page;

$query = "SELECT * FROM reservation 
          WHERE nama LIKE ? 
             OR pesanan LIKE ? 
             OR status LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT $selected_per_page OFFSET $offset";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
$reservations = $result->fetch_all(MYSQLI_ASSOC);

$total_query = "SELECT COUNT(*) AS total FROM reservation 
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
              <option value="<?= $option ?>" <?= $selected_per_page == $option ? 'selected' : '' ?>><?= $option ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="col-md-9">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Cari reservasi..." value="<?= htmlspecialchars($search) ?>">
          <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
          <a href="reservasi.php" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle" id="reservationTable">
        <thead class="table-light">
          <tr>
            <th>ID</th><th>Nama</th><th>Jumlah Orang</th><th>Tanggal</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Pesanan</th><th>Status</th><th>Aksi</th>
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
              <button class="btn btn-sm btn-info view-btn" data-id="<?= $res['id'] ?>"><i class="bi bi-eye"></i></button>
              <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $res['id'] ?>"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $res['id'] ?>"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="viewReservationModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Reservasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nama:</strong> <span id="modalNama"></span></p>
        <p><strong>Jumlah Orang:</strong> <span id="modalJumlah"></span></p>
        <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
        <p><strong>Jam Mulai:</strong> <span id="modalJamMulai"></span></p>
        <p><strong>Jam Selesai:</strong> <span id="modalJamSelesai"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Pesanan:</strong> <span id="modalPesanan"></span></p>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.view-btn').forEach(btn => {
  btn.addEventListener('click', function () {
    const id = this.dataset.id;

    fetch(`get_reservation.php?id=${id}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('modalNama').textContent = data.nama;
        document.getElementById('modalJumlah').textContent = data.jumlah_orang;
        document.getElementById('modalTanggal').textContent = data.tanggal;
        document.getElementById('modalJamMulai').textContent = data.jam_mulai;
        document.getElementById('modalJamSelesai').textContent = data.jam_selesai;
        document.getElementById('modalStatus').textContent = data.status;
        document.getElementById('modalPesanan').textContent = data.pesanan;

        new bootstrap.Modal(document.getElementById('viewReservationModal')).show();
      });
  });
});
</script>

<?php include '../views/footer.php'; $conn->close(); ?>
