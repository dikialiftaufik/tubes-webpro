<?php
// pages/feedback.php
session_start();
require_once '../configdb.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    $action = $_POST['action'];
    $id = (int)$_POST['id'];

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM feedback WHERE id_masukan = ?");
        $stmt->bind_param("i", $id);
        echo json_encode(['message' => $stmt->execute() ? 'Feedback dihapus.' : 'Gagal menghapus feedback.']);
        exit();
    }

    if ($action === 'update') {
        $judul_masukan = $_POST['judul_masukan'];
        $pesan_masukan = $_POST['pesan_masukan'];
        $stmt = $conn->prepare("UPDATE masukan SET judul_masukan = ?, pesan_masukan = ? WHERE id_masukan = ?");
        $stmt->bind_param("ssi", $judul_masukan, $pesan_masukan, $id);
        echo json_encode(['message' => $stmt->execute() ? 'Feedback diperbarui.' : 'Gagal memperbarui feedback.']);
        exit();
    }
}

// Pagination & search
$per_page = isset($_GET['per_page']) && in_array((int)$_GET['per_page'], [10, 25, 50, 100]) ? (int)$_GET['per_page'] : 10;
if ($per_page <= 0) $per_page = 10; 
$page = max((int)($_GET['page'] ?? 1), 1);
$search = $conn->real_escape_string($_GET['search'] ?? '');
$offset = ($page - 1) * $per_page;

$search_term = "%$search%";
$stmt = $conn->prepare("SELECT * FROM feedback WHERE judul_masukan LIKE ? OR pesan_masukan LIKE ? ORDER BY id_masukan ASC LIMIT ? OFFSET ?");
$stmt->bind_param("ssii", $search_term, $search_term, $per_page, $offset);
$stmt->execute();
$feedbacks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt_total = $conn->prepare("SELECT COUNT(*) AS total FROM feedback WHERE judul_masukan LIKE ? OR pesan_masukan LIKE ?");
$stmt_total->bind_param("ss", $search_term, $search_term);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$row_total = $result_total->fetch_assoc();
$total_rows = $row_total['total'];
$total_pages = ceil($total_rows / $per_page);

$title = "Data Feedback";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>
<div class="main-content">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <select name="per_page" class="form-select" onchange="this.form.submit()">
                        <?php foreach ([10, 25, 50, 100] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $opt == $per_page ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-9">
                    <div class="input-group">
                        <input name="search" class="form-control" placeholder="Cari feedback..." value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                        <a href="feedback.php" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>ID User</th>
                        <th>Tanggal</th>
                        <th>Judul Masukan</th>
                        <th>Pesan Masukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $fb): ?>
                    <tr>
                        <td><?= $fb['id_masukan'] ?></td>
                        <td><?= $fb['user_id'] ?></td>
                        <td><?= $fb['tgl_masukan'] ?></td>
                        <td><?= htmlspecialchars($fb['judul_masukan']) ?></td>
                        <td><?= htmlspecialchars($fb['pesan_masukan']) ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info view-btn" data-id="<?= $fb['id_masukan'] ?>"><i class="bi bi-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $fb['id_masukan'] ?>"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Feedback</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label>ID User:</label>
        <input type="text" id="modalUserId" class="form-control mb-2" readonly>
        
        <label>Tanggal:</label>
        <input type="text" id="modalTanggal" class="form-control mb-2" readonly>
        
        <label>Judul Masukan:</label>
        <input type="text" id="modalJudul" class="form-control mb-2">
        
        <label>Pesan Masukan:</label>
        <textarea id="modalPesan" class="form-control mb-2"></textarea>
        
        <div class="text-end">
          <button id="saveBtn" class="btn btn-primary d-none">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  $('.view-btn').click(function () {
    const id = $(this).data('id');
    $.get('get_feedback.php', { id }, function (data) {
      $('#modalUserId').val(data.user_id);
      $('#modalTanggal').val(data.tgl_masukan);
      $('#modalJudul').val(data.judul_masukan);
      $('#modalPesan').val(data.pesan_masukan);
      $('#saveBtn').removeClass('d-none').data('id', id);
      new bootstrap.Modal('#feedbackModal').show();
    }, 'json').fail(function() {
      alert('Gagal mengambil data feedback.');
    });
  });

  $('#saveBtn').click(function () {
    const id = $(this).data('id');
    $.post('feedback.php', {
      action: 'update',
      id: id,
      judul_masukan: $('#modalJudul').val(),
      pesan_masukan: $('#modalPesan').val()
    }, function (res) {
      alert(res.message);
      location.reload();
    }, 'json');
  });

  $('.delete-btn').click(function () {
    if (confirm('Yakin ingin menghapus?')) {
      $.post('feedback.php', {
        action: 'delete',
        id: $(this).data('id')
      }, function (res) {
        alert(res.message);
        location.reload();
      }, 'json');
    }
  });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../views/footer.php'; $conn->close(); ?>