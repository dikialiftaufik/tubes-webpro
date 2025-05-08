<?php
// pages/menu.php
session_start();
require_once '../configdb.php';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Cek auth admin
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Fungsi untuk handle edit, delete, dan create
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        die(json_encode(['message' => 'Invalid CSRF token']));
    }
    
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

        // Handle Create
        if ($action === 'create') {
            // Sanitize input
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $image_url = filter_var($_POST['image_url'], FILTER_SANITIZE_URL);
            $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $calories = filter_var($_POST['calories'], FILTER_SANITIZE_NUMBER_INT);
            $ingredients = filter_var($_POST['ingredients'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

            $stmt = $conn->prepare("INSERT INTO menu 
                (name, image_url, type, price, calories, ingredients, description, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("sssdiss", $name, $image_url, $type, $price, $calories, $ingredients, $description);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Menu berhasil ditambahkan']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Gagal menambahkan menu: ' . $stmt->error]);
            }
            exit();
        }

        // Handle Delete
        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Menu berhasil dihapus']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Gagal menghapus menu: ' . $stmt->error]);
            }
            exit();
        }

        // Handle Update
        if ($action === 'update') {
            // Sanitize input
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $image_url = filter_var($_POST['image_url'], FILTER_SANITIZE_URL);
            $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $calories = filter_var($_POST['calories'], FILTER_SANITIZE_NUMBER_INT);
            $ingredients = filter_var($_POST['ingredients'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

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
                http_response_code(500);
                echo json_encode(['message' => 'Gagal memperbarui menu: ' . $stmt->error]);
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
$search = isset($_GET['search']) ? $conn->real_escape_string(strip_tags($_GET['search'])) : '';
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
$page = min($page, $total_pages);

$title = "Data Menu";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<img src="satekambing.jpg" alt="Foto">

<div class="main-content">
    <?php include '../views/alerts.php'; ?>
    
    <div class="d-flex justify-content-between mb-3">
        <h2>Data Menu</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createMenuModal">
            <i class="bi bi-plus-circle"></i> Tambah Menu
        </button>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
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
                        <input type="text" name="search" class="form-control" placeholder="Cari menu..." value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
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
                            <td><?= htmlspecialchars($menu['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><img src="<?= htmlspecialchars($menu['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="Menu" style="max-width: 100px;"></td>
                            <td><?= htmlspecialchars($menu['type'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= number_format($menu['price'], 2) ?></td>
                            <td><?= htmlspecialchars($menu['calories'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($menu['ingredients'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($menu['description'], ENT_QUOTES, 'UTF-8') ?></td>
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

<!-- Modal Create -->
<div class="modal fade" id="createMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createMenuForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Nama Menu:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Gambar URL:</label>
                                <input type="url" name="image_url" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Jenis:</label>
                                <select name="type" class="form-select">
                                    <option value="main_course">Main Course</option>
                                    <option value="drink">Minuman</option>
                                    <option value="side_dish">Side Dish</option>
                                    <option value="backa">Backa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Harga:</label>
                                <input type="number" step="0.01" min="0" name="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Kalori:</label>
                                <input type="number" min="0" name="calories" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Bahan-bahan:</label>
                                <textarea name="ingredients" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi:</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit/View -->
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
                            <input type="text" id="showName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Image URL:</label>
                            <input type="url" id="showImageUrl" class="form-control" required>
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
                            <input type="number" step="0.01" min="0" id="showPrice" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Calories:</label>
                            <input type="number" min="0" id="showCalories" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Ingredients:</label>
                            <textarea id="showIngredients" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Description:</label>
                            <textarea id="showDescription" class="form-control" rows="4" required></textarea>
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
$(document).ready(function() {
    // Handle Delete
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
            $.post('menu.php', { 
                action: 'delete', 
                id: id,
                csrf_token: '<?= $_SESSION['csrf_token'] ?>' 
            }, function(response) {
                alert(response.message);
                location.reload();
            }, 'json').fail(function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Server Error'));
            });
        }
    });

    // Handle Create
    $('#createMenuForm').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            action: 'create',
            csrf_token: '<?= $_SESSION['csrf_token'] ?>',
            ...Object.fromEntries(new FormData(this).entries())
        };

        $.post('menu.php', formData, function(response) {
            alert(response.message);
            $('#createMenuModal').modal('hide');
            location.reload();
        }, 'json').fail(function(xhr) {
            alert('Error: ' + (xhr.responseJSON?.message || 'Server Error'));
        });
    });

    // Handle View/Edit
    $(document).on('click', '.view-btn, .edit-btn', function() {
        const id = $(this).data('id');
        const isView = $(this).hasClass('view-btn');
        
        $.get('get_menu.php', { id }, function(menu) {
            // Fill form
            $('#showName').val(menu.name).prop('readonly', isView);
            $('#showImageUrl').val(menu.image_url).prop('readonly', isView);
            $('#showType').val(menu.type).prop('disabled', isView);
            $('#showPrice').val(menu.price).prop('readonly', isView);
            $('#showCalories').val(menu.calories).prop('readonly', isView);
            $('#showIngredients').val(menu.ingredients).prop('readonly', isView);
            $('#showDescription').val(menu.description).prop('readonly', isView);

            // Toggle save button
            $('#saveMenuChangesBtn').toggle(!isView);
            
            // Show modal
            const modal = new bootstrap.Modal('#showMenuModal');
            modal.show();

            // Handle save
            $('#saveMenuChangesBtn').off('click').on('click', function() {
                const formData = {
                    action: 'update',
                    id: id,
                    csrf_token: '<?= $_SESSION['csrf_token'] ?>',
                    name: $('#showName').val(),
                    image_url: $('#showImageUrl').val(),
                    type: $('#showType').val(),
                    price: $('#showPrice').val(),
                    calories: $('#showCalories').val(),
                    ingredients: $('#showIngredients').val(),
                    description: $('#showDescription').val()
                };
                
                $.post('menu.php', formData, function(response) {
                    alert(response.message);
                    modal.hide();
                    location.reload();
                }, 'json').fail(function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Server Error'));
                });
            });
        }, 'json').fail(function() {
            alert('Gagal memuat data menu');
        });
    });
});
</script>

<?php 
include '../views/footer.php'; 
$conn->close();
?>