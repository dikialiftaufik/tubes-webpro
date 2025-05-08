<?php
// pages/menu.php
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
            $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Menu berhasil dihapus']);
            } else {
                echo json_encode(['message' => 'Gagal menghapus menu']);
            }
            exit();
        }

        if ($action === 'update') {
            $name = $_POST['name'];
            $image_url = $_POST['image_url'];
            $type = $_POST['type'];
            $price = $_POST['price'];
            $calories = $_POST['calories'];
            $ingredients = $_POST['ingredients'];
            $description = $_POST['description'];

            $stmt = $conn->prepare("UPDATE menu SET 
                name = ?, 
                image_url = ?, 
                type = ?, 
                price = ?, 
                calories = ?, 
                ingredients = ?, 
                description = ?, 
                updated_at = NOW() 
                WHERE id = ?");
            $stmt->bind_param("sssdissi", $name, $image_url, $type, $price, $calories, $ingredients, $description, $id);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Menu berhasil diperbarui']);
            } else {
                echo json_encode(['message' => 'Gagal memperbarui menu']);
            }
            exit();
        }
    }
}

// Konfigurasi pagination dan sorting
$per_page_options = [10, 25, 50, 100];
$selected_per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], $per_page_options) 
                    ? (int)$_GET['per_page'] 
                    : 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id','name','type','price','calories']) ? $_GET['sort'] : 'id';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'DESC' ? 'DESC' : 'ASC';
$search_term = "%$search%";
$offset = ($page - 1) * $selected_per_page;

$query = "SELECT * FROM menu 
          WHERE name LIKE ? 
             OR type LIKE ? 
             OR ingredients LIKE ? 
             OR description LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT $selected_per_page OFFSET $offset";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
$menus = $result->fetch_all(MYSQLI_ASSOC);

// Total data untuk pagination
$total_query = "SELECT COUNT(*) AS total FROM menu 
                WHERE name LIKE ? 
                   OR type LIKE ? 
                   OR ingredients LIKE ? 
                   OR description LIKE ?";
$stmt_total = $conn->prepare($total_query);
$stmt_total->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_menus = $total_row['total'];
$total_pages = ceil($total_menus / $selected_per_page);

$title = "Data Menu";
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
                        <input type="text" name="search" class="form-control" placeholder="Cari menu..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="menu.php" class="btn btn-secondary">
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
                <table class="table table-hover align-middle" id="menuTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Calories</th>
                            <th>Ingredients</th>
                            <th>Description</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($menus as $menu): ?>
                        <tr>
                            <td><?= htmlspecialchars($menu['id']) ?></td>
                            <td><?= htmlspecialchars($menu['name']) ?></td>
                            <td><img src="<?= htmlspecialchars($menu['image_url']) ?>" alt="Menu" style="max-width: 100px;"></td>
                            <td><?= htmlspecialchars($menu['type']) ?></td>
                            <td><?= number_format($menu['price'], 2) ?></td>
                            <td><?= htmlspecialchars($menu['calories']) ?></td>
                            <td><?= htmlspecialchars($menu['ingredients']) ?></td>
                            <td><?= htmlspecialchars($menu['description']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info view-btn" data-id="<?= $menu['id'] ?>"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-warning edit-btn" data-id="<?= $menu['id'] ?>"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $menu['id'] ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="showMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Name:</label>
                            <input type="text" id="showName" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Image URL:</label>
                            <input type="text" id="showImageUrl" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Type:</label>
                            <select id="showType" class="form-select">
                                <option value="main_course">Main Course</option>
                                <option value="drink">Drink</option>
                                <option value="side_dish">Side Dish</option>
                                <option value="backa">Backa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Price:</label>
                            <input type="number" step="0.01" id="showPrice" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Calories:</label>
                            <input type="number" id="showCalories" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Ingredients:</label>
                            <textarea id="showIngredients" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Description:</label>
                            <textarea id="showDescription" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" id="saveMenuChangesBtn" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ... (script AJAX sama seperti di reservation.php dengan penyesuaian field) ...
});
</script>

<?php include '../views/footer.php'; ?>
<?php $conn->close(); ?>