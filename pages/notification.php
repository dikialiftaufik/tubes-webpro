<?php
// pages/notification.php
session_start();
require_once '../configdb.php';

// Cek auth admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'create') {
            $title = $_POST['title'];
            $message = $_POST['message'];
            $image_path = '';
            
            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $target_dir = "../img/notification/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $image_path = "img/notification/" . basename($_FILES["image"]["name"]);
            }
            
            // Buat notifikasi langsung aktif (is_active=1)
            $stmt = $conn->prepare("INSERT INTO notifications (title, message, image_path, is_active) VALUES (?, ?, ?, 1)");
            $stmt->bind_param("sss", $title, $message, $image_path);
            $stmt->execute();
        }
        elseif ($action === 'delete') {
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
        // Hapus fungsi toggle karena tidak diperlukan lagi
    }
}

// Ambil data notifikasi
$stmt = $conn->prepare("SELECT * FROM notifications ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);

$title = "Kelola Notifikasi";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<div class="main-content">
    <!-- Header dengan tombol di kanan -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Kelola Notifikasi</h4>
        <button id="showFormButton" class="btn btn-primary">Tambah Notifikasi Baru</button>
    </div>

    <!-- Form Tambah Notifikasi (awalnya tersembunyi) -->
    <div id="notificationForm" class="card shadow-sm mb-4 d-none">
        <div class="card-body">
            <h4>Tambah Notifikasi Baru</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pesan</label>
                    <textarea name="message" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <input type="hidden" name="action" value="create">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <button type="button" id="cancelFormButton" class="btn btn-secondary">Batal</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($notifications as $notif): ?>
                        <tr>
                            <td>
                                <?php if (!empty($notif['image_path'])): ?>
                                    <img src="../<?= htmlspecialchars($notif['image_path']) ?>" width="50" height="50" style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary" style="width:50px;height:50px;"></div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($notif['title']) ?></td>
                            <td><?= htmlspecialchars($notif['message']) ?></td>
                            <td>
                                <span class="badge bg-<?= $notif['is_active'] ? 'success' : 'secondary' ?>">
                                    <?= $notif['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td><?= $notif['created_at'] ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $notif['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle tampilan form
    const showFormButton = document.getElementById('showFormButton');
    const notificationForm = document.getElementById('notificationForm');
    const cancelFormButton = document.getElementById('cancelFormButton');

    showFormButton.addEventListener('click', function() {
        notificationForm.classList.remove('d-none');
        showFormButton.classList.add('d-none');
    });

    cancelFormButton.addEventListener('click', function() {
        notificationForm.classList.add('d-none');
        showFormButton.classList.remove('d-none');
        // Reset form saat batal
        document.querySelector('#notificationForm form').reset();
    });
</script>

<?php include '../views/footer.php'; $conn->close(); ?>