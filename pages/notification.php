<?php
// pages/notification.php
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

// Fungsi untuk handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $id = $_POST['id'];

        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Notifikasi berhasil dihapus']);
            } else {
                echo json_encode(['message' => 'Gagal menghapus notifikasi']);
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
$sort_column = in_array($_GET['sort'] ?? '', ['id','user_id','order_id','reservation_id','type','is_read']) 
               ? $_GET['sort'] 
               : 'id';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'DESC' ? 'DESC' : 'ASC';
$search_term = "%$search%";
$offset = ($page - 1) * $selected_per_page;

// Query data notifikasi
$query = "SELECT id, user_id, order_id, reservation_id, type, message, is_read 
          FROM notifications 
          WHERE message LIKE ? 
             OR type LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT $selected_per_page OFFSET $offset";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);

// Query total data
$total_query = "SELECT COUNT(*) AS total FROM notifications 
                WHERE message LIKE ? 
                   OR type LIKE ?";
$stmt_total = $conn->prepare($total_query);
$stmt_total->bind_param("ss", $search_term, $search_term);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_notifications = $total_row['total'];
$total_pages = ceil($total_notifications / $selected_per_page);

// Redirect jika halaman melebihi total
if ($total_pages > 0 && $page > $total_pages) {
    $query_params = [
        'search' => $search,
        'sort' => $sort_column,
        'order' => $sort_order,
        'per_page' => $selected_per_page,
        'page' => $total_pages
    ];
    header("Location: notification.php?" . http_build_query($query_params));
    exit();
}

$title = "Data Notifikasi"; 
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
                        <input type="text" name="search" class="form-control" placeholder="Cari notifikasi..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="notification.php" class="btn btn-secondary">
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
                <table class="table table-hover align-middle" id="notificationTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Order ID</th>
                            <th>Reservation ID</th>
                            <th>Tipe</th>
                            <th>Pesan</th>
                            <th>Status Baca</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($notifications as $notif): ?>
                        <tr>
                            <td><?= htmlspecialchars($notif['id']) ?></td>
                            <td><?= htmlspecialchars($notif['user_id']) ?></td>
                            <td><?= htmlspecialchars($notif['order_id']) ?></td>
                            <td><?= htmlspecialchars($notif['reservation_id']) ?></td>
                            <td><?= htmlspecialchars($notif['type']) ?></td>
                            <td><?= htmlspecialchars($notif['message']) ?></td>
                            <td><?= $notif['is_read'] ? 'Sudah dibaca' : 'Belum dibaca' ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info view-btn" data-id="<?= $notif['id'] ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $notif['id'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="showNotificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Notifikasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label>ID:</label>
          <input type="text" id="showId" class="form-control" readonly>
        </div>
        <div class="mb-2">
          <label>User ID:</label>
          <input type="text" id="showUserId" class="form-control" readonly>
        </div>
        <div class="mb-2">
          <label>Order ID:</label>
          <input type="text" id="showOrderId" class="form-control" readonly>
        </div>
        <div class="mb-2">
          <label>Reservation ID:</label>
          <input type="text" id="showReservationId" class="form-control" readonly>
        </div>
        <div class="mb-2">
          <label>Tipe:</label>
          <input type="text" id="showType" class="form-control" readonly>
        </div>
        <div class="mb-2">
          <label>Pesan:</label>
          <textarea id="showMessage" class="form-control" readonly></textarea>
        </div>
        <div class="mb-2">
          <label>Status Baca:</label>
          <input type="text" id="showIsRead" class="form-control" readonly>
        </div>
        <div class="mb-2">
          <label>Dibuat Pada:</label>
          <input type="text" id="showCreatedAt" class="form-control" readonly>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // View detail notifikasi
  $(document).on('click', '.view-btn', function() {
    const id = $(this).data('id');
    $.get('get_notification.php', { id }, function(data) {
      if (!data || typeof data !== 'object') {
        console.error('Data kosong atau bukan object:', data);
        return;
      }
      $('#showId').val(data.id);
      $('#showUserId').val(data.user_id);
      $('#showOrderId').val(data.order_id);
      $('#showReservationId').val(data.reservation_id);
      $('#showType').val(data.type);
      $('#showMessage').val(data.message);
      $('#showIsRead').val(data.is_read ? 'Sudah dibaca' : 'Belum dibaca');
      $('#showCreatedAt').val(data.created_at);
      
      const modal = new bootstrap.Modal(document.getElementById('showNotificationModal'));
      modal.show();
    }, 'json');
  });

  // Hapus notifikasi
  $(document).on('click', '.delete-btn', function() {
    const id = $(this).data('id');
    if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
      $.post('notification.php', { action: 'delete', id }, function(response) {
        alert(response.message || 'Notifikasi berhasil dihapus');
        location.reload();
      }, 'json');
    }
  });
});
</script>

<?php include '../views/footer.php'; $conn->close(); ?>