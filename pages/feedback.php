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
        $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
        $stmt->bind_param("i", $id);
        echo json_encode(['message' => $stmt->execute() ? 'Feedback dihapus.' : 'Gagal menghapus feedback.']);
        exit();
    }

    if ($action === 'update') {
        $nama = $_POST['nama'];
        $masukan = $_POST['masukan'];
        $stmt = $conn->prepare("UPDATE feedback SET nama = ?, masukan = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nama, $masukan, $id);
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
$stmt = $conn->prepare("SELECT * FROM feedback WHERE nama LIKE ? OR masukan LIKE ? ORDER BY id ASC LIMIT ? OFFSET ?");
$stmt->bind_param("ssii", $search_term, $search_term, $per_page, $offset);
$stmt->execute();
$feedbacks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt_total = $conn->prepare("SELECT COUNT(*) AS total FROM feedback WHERE nama LIKE ? OR masukan LIKE ?");
$stmt_total->bind_param("ss", $search_term, $search_term);
$stmt_total->execute();
$total_rows = isset($total_rows) && $total_rows > 0 ? $total_rows : 1;
$total_pages = ceil($total_rows / $per_page);
$stmt_total->free_result();


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
                    <tr><th>ID</th><th>Nama</th><th>Masukan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $fb): ?>
                    <tr>
                        <td><?= $fb['id'] ?></td>
                        <td><?= htmlspecialchars($fb['nama']) ?></td>
                        <td><?= htmlspecialchars($fb['masukan']) ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info view-btn" data-id="<?= $fb['id'] ?>"><i class="bi bi-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $fb['id'] ?>"><i class="bi bi-trash"></i></button>
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
        <label>Nama:</label>
        <input type="text" id="modalNama" class="form-control mb-6">
        <label>Masukan:</label>
        <textarea id="modalMasukan" class="form-control mb-2"></textarea>
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
      $('#modalNama').val(data.nama).prop('readonly', true);
      $('#modalMasukan').val(data.masukan).prop('readonly', true);
      $('#saveBtn').addClass('d-none');
      new bootstrap.Modal('#feedbackModal').show();
    }, 'json');
  });

  $('#saveBtn').click(function () {
    $.post('feedback.php', {
      action: 'update',
      id: $(this).data('id'),
      nama: $('#modalNama').val(),
      masukan: $('#modalMasukan').val()
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
