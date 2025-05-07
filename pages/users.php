<?php
// pages/users.php
session_start();

// Error handling (disable di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../configdb.php';

// Cek autentikasi admin
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
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id','username','role','created_at']) ? $_GET['sort'] : 'created_at';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

$search_term = "%" . str_replace(' ', '%', $search) . "%";
$offset = ($page - 1) * $selected_per_page;

// Query data dengan prepared statement
$query = "SELECT * FROM users 
          WHERE username LIKE ? 
            OR full_name LIKE ? 
            OR email LIKE ? 
            OR role LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}

$stmt->bind_param("ssssii", 
    $search_term, 
    $search_term, 
    $search_term, 
    $search_term, 
    $selected_per_page, 
    $offset
);

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

// Total data dengan prepared statement
$total_query = "SELECT COUNT(*) AS total FROM users 
                WHERE username LIKE ? 
                  OR full_name LIKE ? 
                  OR email LIKE ? 
                  OR role LIKE ?";

$stmt_total = $conn->prepare($total_query);
if (!$stmt_total) {
    die("Error preparing total query: " . $conn->error);
}

$stmt_total->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $selected_per_page);

// Redirect jika page tidak valid
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
                        <th width="50">No.</th>
                        <th>Foto</th>
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
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = ($page - 1) * $selected_per_page + 1;
                    foreach($users as $user): 
                        $profile_pic = !empty($user['profile_picture']) 
                                    ? '../' . htmlspecialchars($user['profile_picture']) 
                                    : 'https://via.placeholder.com/40';
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <img src="<?= $profile_pic ?>" 
                                 class="rounded-circle border" 
                                 style="width: 40px; height: 40px; object-fit: cover;"
                                 onerror="this.src='https://via.placeholder.com/40'">
                        </td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td>
                            <span class="badge bg-<?= 
                            $user['role'] === 'admin'   ? 'primary'   :
                            ($user['role'] === 'cashier' ? 'success' : 'warning')
                        ?>">
                            <?= ucfirst($user['role']) ?>
                        </span>
                        </td>
                        <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <!-- ... tombol aksi tetap sama ... -->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" 
                           href="?<?= http_build_query([
                               'search' => $search,
                               'sort' => $sort_column,
                               'order' => $sort_order,
                               'per_page' => $selected_per_page,
                               'page' => $page - 1
                           ]) ?>">
                            &laquo; Previous
                        </a>
                    </li>
                    
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" 
                           href="?<?= http_build_query([
                               'search' => $search,
                               'sort' => $sort_column,
                               'order' => $sort_order,
                               'per_page' => $selected_per_page,
                               'page' => $i
                           ]) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" 
                           href="?<?= http_build_query([
                               'search' => $search,
                               'sort' => $sort_column,
                               'order' => $sort_order,
                               'per_page' => $selected_per_page,
                               'page' => $page + 1
                           ]) ?>">
                            Next &raquo;
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
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
                        <dl class="row" id="modalUserData"></dl>
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
document.getElementById('userModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const userData = JSON.parse(button.dataset.userData);
    
    // Update profile picture
    const profilePic = document.getElementById('modalProfilePic');
    profilePic.src = userData.profile_picture 
        ? '../' + userData.profile_picture 
        : 'https://via.placeholder.com/150';
    profilePic.onerror = () => profilePic.src = 'https://via.placeholder.com/150';
    
    // Update user data
    const fields = {
        'username': 'Username',
        'full_name': 'Nama Lengkap',
        'email': 'Email',
        'phone_number': 'No. HP',
        'address': 'Alamat',
        'role': 'Role',
        'created_at': 'Terdaftar'
    };
    
    const modalBody = document.getElementById('modalUserData');
    modalBody.innerHTML = '';
    
    Object.entries(fields).forEach(([key, label]) => {
        const row = document.createElement('div');
        row.className = 'mb-2 row';
        
        const dt = document.createElement('dt');
        dt.className = 'col-sm-4';
        dt.textContent = label;
        
        const dd = document.createElement('dd');
        dd.className = 'col-sm-8';
        
        if(key === 'created_at') {
            dd.textContent = new Date(userData[key]).toLocaleString();
        } else {
            dd.textContent = userData[key] || '-';
        }
        
        row.appendChild(dt);
        row.appendChild(dd);
        modalBody.appendChild(row);
    });
});
</script>

<?php 
include '../views/footer.php';
$conn->close();
?>