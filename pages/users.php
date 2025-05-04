<?php
// pages/users.php
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

// Konfigurasi pagination
$per_page_options = [10, 25, 50, 100];
$selected_per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], $per_page_options) 
                    ? (int)$_GET['per_page'] 
                    : 10;

$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;

// Parameter pencarian dan sorting
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id','username','role','created_at']) ? $_GET['sort'] : 'created_at';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

$search_term = "%$search%";
$offset = ($page - 1) * $selected_per_page;

// Query data
$query = "SELECT * FROM users 
          WHERE username LIKE ? 
            OR full_name LIKE ? 
            OR email LIKE ? 
            OR role LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssssii", $search_term, $search_term, $search_term, $search_term, $selected_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

// Total data
$total_query = "SELECT COUNT(*) AS total FROM users 
                WHERE username LIKE ? 
                  OR full_name LIKE ? 
                  OR email LIKE ? 
                  OR role LIKE ?";
$stmt_total = $conn->prepare($total_query);
$stmt_total->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $selected_per_page);

// Redirect jika page melebihi total halaman
if ($total_pages > 0 && $page > $total_pages) {
    $query_params = [
        'search' => $search,
        'sort' => $sort_column,
        'order' => $sort_order,
        'per_page' => $selected_per_page,
        'page' => $total_pages
    ];
    header("Location: users.php?" . http_build_query($query_params));
    exit();
}

$title = "Manajemen Pengguna";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<div class="main-content">
    <?php include '../views/alerts.php'; ?>
    
    
    <!-- Search dan Filter -->
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
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari user..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="users.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
                
                <input type="hidden" name="sort" value="<?= $sort_column ?>">
                <input type="hidden" name="order" value="<?= $sort_order ?>">
                <input type="hidden" name="page" value="1">
            </form>
        </div>
    </div>

    <!-- Tabel Users -->
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
                                    'sort' => 'username',
                                    'order' => ($sort_column === 'username' && $sort_order === 'ASC') ? 'DESC' : 'ASC',
                                    'per_page' => $selected_per_page
                                ]) ?>">
                                    Username <?= ($sort_column === 'username') ? ($sort_order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th>Foto Profil</th>
                            <th>Nama Lengkap</th>
                            <th>
                                <a href="?<?= http_build_query([
                                    'search' => $search,
                                    'sort' => 'role',
                                    'order' => ($sort_column === 'role' && $sort_order === 'ASC') ? 'DESC' : 'ASC',
                                    'per_page' => $selected_per_page
                                ]) ?>">
                                    Role <?= ($sort_column === 'role') ? ($sort_order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th>Terdaftar</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): 
                            $profile_pic = !empty($user['profile_picture']) 
                                        ? '../' . $user['profile_picture'] 
                                        : 'https://via.placeholder.com/40';
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td>
                                <img src="<?= $profile_pic ?>" 
                                     class="rounded-circle border" 
                                     style="width: 40px; height: 40px; object-fit: cover;"
                                     onerror="this.src='https://via.placeholder.com/40'">
                            </td>
                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                            <td>
                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'primary' : 'success' ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#userModal"
                                        data-user='<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>'>
                                    <i class="bi bi-eye"></i>
                                </button>
                                <form action="delete_user.php" method="POST" class="d-inline">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Ganti bagian pagination dengan ini -->
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php
        $query_params = [
            'search' => $search,
            'sort' => $sort_column,
            'order' => $sort_order,
            'per_page' => $selected_per_page
        ];
        ?>
        
        <!-- Tombol Previous - SELALU TAMPIL -->
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" 
               href="?<?= http_build_query($query_params + ['page' => $page - 1]) ?>" 
               aria-label="Previous"
               <?= $page <= 1 ? 'tabindex="-1"' : '' ?>>
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>

        <!-- Nomor Halaman -->
        <?php if($total_pages > 0): ?>
            <?php for($i = max(1, $page - 2); $i <= min($page + 2, $total_pages); $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" 
                   href="?<?= http_build_query($query_params + ['page' => $i]) ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>
        <?php endif; ?>

        <!-- Tombol Next - SELALU TAMPIL -->
        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
            <a class="page-link" 
               href="?<?= http_build_query($query_params + ['page' => $page + 1]) ?>" 
               aria-label="Next"
               <?= $page >= $total_pages ? 'tabindex="-1"' : '' ?>>
                <span aria-hidden="true">Next &raquo;</span>
            </a>
        </li>
    </ul>
</nav>
            
        </div>
    </div>
</div>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="modalProfilePic" 
                             class="rounded-circle border mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <dl class="row">
                            <?php 
                            $fields = [
                                'username' => 'Username',
                                'full_name' => 'Nama Lengkap',
                                'email' => 'Email',
                                'phone_number' => 'No. HP',
                                'address' => 'Alamat',
                                'role' => 'Role',
                                'created_at' => 'Terdaftar'
                            ];
                            foreach($fields as $key => $label): ?>
                            <dt class="col-sm-4"><?= $label ?></dt>
                            <dd class="col-sm-8" id="modal<?= ucfirst($key) ?>">
                                <?php if($key === 'created_at'): ?>
                                    <?= date('d M Y H:i', strtotime($user[$key])) ?>
                                <?php else: ?>
                                    <?= htmlspecialchars($user[$key] ?? '-') ?>
                                <?php endif; ?>
                            </dd>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
// Script untuk modal
document.getElementById('userModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const userData = JSON.parse(button.dataset.user);
    
    // Update foto profil
    const profilePic = document.getElementById('modalProfilePic');
    profilePic.src = userData.profile_picture 
        ? '../' + userData.profile_picture 
        : 'https://via.placeholder.com/150';
    profilePic.onerror = () => profilePic.src = 'https://via.placeholder.com/150';
    
    // Update data lainnya
    <?php foreach(array_keys($fields) as $field): ?>
    document.getElementById('modal<?= ucfirst($field) ?>').textContent = 
        userData.<?= $field ?> || '-';
    <?php endforeach; ?>
});
</script>

<?php 
include '../views/footer.php';
$conn->close();
?>