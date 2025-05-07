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

// Fungsi untuk handle edit dan delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $id = $_POST['id'];

        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM reservation WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Reservasi berhasil dihapus']);
            } else {
                echo json_encode(['message' => 'Gagal menghapus reservasi']);
            }
            exit();
        }

        if ($action === 'update') {
            $nama = $_POST['nama'];
            $jumlah_orang = $_POST['jumlah_orang'];
            $tanggal = $_POST['tanggal'];
            $jam_mulai = $_POST['jam_mulai'];
            $jam_selesai = $_POST['jam_selesai'];
            $pesanan = $_POST['pesanan'];
            $status = $_POST['status'];

            $stmt = $conn->prepare("UPDATE reservation SET nama = ?, jumlah_orang = ?, tanggal = ?, jam_mulai = ?, jam_selesai = ?, pesanan = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sisssssi", $nama, $jumlah_orang, $tanggal, $jam_mulai, $jam_selesai, $pesanan, $status, $id);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Data berhasil diperbarui']);
            } else {
                echo json_encode(['message' => 'Gagal memperbarui data']);
            }
            exit();
        }
    }
}

// Konfigurasi pagination
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
                <table class="table table-hover align-middle" id="reservationTable">
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
                                <button type="button" class="btn btn-sm btn-info view-btn" data-id="<?= $res['id'] ?>"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-warning edit-btn" data-id="<?= $res['id'] ?>"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $res['id'] ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal View/Edit -->
<div class="modal fade" id="showReservationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Reservasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label>Nama:</label>
          <input type="text" id="showNama" class="form-control">
        </div>
        <div class="mb-2">
          <label>Jumlah Orang:</label>
          <input type="text" id="showJumlahOrang" class="form-control">
        </div>
        <div class="mb-2">
          <label>Tanggal:</label>
          <input type="text" id="showTanggal" class="form-control">
        </div>
        <div class="mb-2">
          <label>Jam Mulai:</label>
          <input type="text" id="showJamMulai" class="form-control">
        </div>
        <div class="mb-2">
          <label>Jam Selesai:</label>
          <input type="text" id="showJamSelesai" class="form-control">
        </div>
        <div class="mb-2">
          <label>Pesanan:</label>
          <textarea id="showPesanan" class="form-control"></textarea>
        </div>
        <div class="mb-2">
          <label>Status:</label>
          <input type="text" id="showStatus" class="form-control">
        </div>
        <div class="text-end">
          <button type="button" id="saveChangesBtn" class="btn btn-primary d-none">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  $(document).on('click', '.view-btn', function() {
    const id = $(this).data('id');
    $.get('get_reservation.php', { id }, function(data) {
      if (!data || typeof data !== 'object') {
        console.error('Data kosong atau bukan object:', data);
        return;
      }
      $('#showNama').val(data.nama).prop('readonly', true);
      $('#showJumlahOrang').val(data.jumlah_orang).prop('readonly', true);
      $('#showTanggal').val(data.tanggal).prop('readonly', true);
      $('#showJamMulai').val(data.jam_mulai).prop('readonly', true);
      $('#showJamSelesai').val(data.jam_selesai).prop('readonly', true);
      $('#showPesanan').val(data.pesanan).prop('readonly', true);
      $('#showStatus').val(data.status).prop('readonly', true);
      $('#saveChangesBtn').addClass('d-none');
      const modal = new bootstrap.Modal(document.getElementById('showReservationModal'));
      modal.show();
    }, 'json');
  });

  $(document).on('click', '.edit-btn', function() {
    const id = $(this).data('id');
    $.get('get_reservation.php', { id }, function(data) {
      if (!data || typeof data !== 'object') {
        console.error('Data kosong atau bukan object:', data);
        return;
      }
      $('#showNama').val(data.nama).prop('readonly', false);
      $('#showJumlahOrang').val(data.jumlah_orang).prop('readonly', false);
      $('#showTanggal').val(data.tanggal).prop('readonly', false);
      $('#showJamMulai').val(data.jam_mulai).prop('readonly', false);
      $('#showJamSelesai').val(data.jam_selesai).prop('readonly', false);
      $('#showPesanan').val(data.pesanan).prop('readonly', false);
      $('#showStatus').val(data.status).prop('readonly', false);
      $('#saveChangesBtn').removeClass('d-none').data('id', id);
      const modal = new bootstrap.Modal(document.getElementById('showReservationModal'));
      modal.show();
    }, 'json');
  });

  $('#saveChangesBtn').click(function() {
    const id = $(this).data('id');
    const updatedData = {
      action: 'update',
      id,
      nama: $('#showNama').val(),
      jumlah_orang: $('#showJumlahOrang').val(),
      tanggal: $('#showTanggal').val(),
      jam_mulai: $('#showJamMulai').val(),
      jam_selesai: $('#showJamSelesai').val(),
      pesanan: $('#showPesanan').val(),
      status: $('#showStatus').val()
    };

    $.post('update_reservation.php', updatedData, function(response) {
      alert(response.message || 'Data berhasil diperbarui');
      location.reload();
    }, 'json');
  });

  $(document).on('click', '.delete-btn', function() {
    const id = $(this).data('id');
    if (confirm('Apakah Anda yakin ingin menghapus reservasi ini?')) {
      $.post('reservasi.php', { action: 'delete', id }, function(response) {
        alert(response.message || 'Reservasi berhasil dihapus');
        location.reload();
      }, 'json');
    }
  });
});
</script>

<?php include '../views/footer.php'; $conn->close(); ?>