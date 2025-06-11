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
        elseif ($action === 'update') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $message = $_POST['message'];
            $current_image = $_POST['current_image'];
            $image_path = $current_image; // Default to existing image
            
            // Handle new image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $target_dir = "../img/notification/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $image_path = "img/notification/" . basename($_FILES["image"]["name"]);
                
                // Delete old image if exists
                if (!empty($current_image)) {
                    $old_image_path = "../" . $current_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            
            $stmt = $conn->prepare("UPDATE notifications SET title = ?, message = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $message, $image_path, $id);
            $stmt->execute();
        }
        elseif ($action === 'delete') {
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
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

    <!-- Form Tambah/Edit Notifikasi -->
    <div id="notificationForm" class="card shadow-sm mb-4 d-none">
        <div class="card-body">
            <h4 id="formTitle">Tambah Notifikasi Baru</h4>
            <form method="POST" enctype="multipart/form-data" id="notificationFormElement">
                <input type="hidden" name="id" id="editId" value="">
                <input type="hidden" name="current_image" id="currentImage" value="">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" id="editTitle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pesan</label>
                    <textarea name="message" id="editMessage" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                    <div id="imagePreview" class="mt-2"></div>
                </div>
                <input type="hidden" name="action" id="formAction" value="create">
                <button type="submit" class="btn btn-primary" id="submitButton">Tambah</button>
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
                                <button class="btn btn-sm btn-warning edit-button" 
                                        data-id="<?= $notif['id'] ?>" 
                                        data-title="<?= htmlspecialchars($notif['title']) ?>" 
                                        data-message="<?= htmlspecialchars($notif['message']) ?>"
                                        data-image-path="<?= htmlspecialchars($notif['image_path']) ?>">
                                    Edit
                                </button>
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
        resetForm(); // Reset form ke mode tambah
        notificationForm.classList.remove('d-none');
        showFormButton.classList.add('d-none');
    });

    // Tangani klik tombol edit
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const message = this.getAttribute('data-message');
            const imagePath = this.getAttribute('data-image-path');

            // Set form ke mode edit
            document.getElementById('formTitle').textContent = 'Edit Notifikasi';
            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editMessage').value = message;
            document.getElementById('currentImage').value = imagePath;
            document.getElementById('formAction').value = 'update';
            document.getElementById('submitButton').textContent = 'Update';

            // Tampilkan gambar jika ada
            const imagePreview = document.getElementById('imagePreview');
            if (imagePath) {
                imagePreview.innerHTML = `<img src="../${imagePath}" width="100" class="img-thumbnail">`;
            } else {
                imagePreview.innerHTML = '';
            }

            // Tampilkan form dan sembunyikan tombol tambah
            notificationForm.classList.remove('d-none');
            showFormButton.classList.add('d-none');
        });
    });

    // Fungsi reset form ke mode tambah
    function resetForm() {
        document.getElementById('notificationFormElement').reset();
        document.getElementById('imagePreview').innerHTML = '';
        document.getElementById('formTitle').textContent = 'Tambah Notifikasi Baru';
        document.getElementById('formAction').value = 'create';
        document.getElementById('submitButton').textContent = 'Tambah';
        document.getElementById('editId').value = '';
        document.getElementById('currentImage').value = '';
    }

    // Pada saat batal, reset form dan sembunyikan
    cancelFormButton.addEventListener('click', function() {
        notificationForm.classList.add('d-none');
        showFormButton.classList.remove('d-none');
        resetForm();
    });
</script>

<?php include '../views/footer.php'; $conn->close(); ?>