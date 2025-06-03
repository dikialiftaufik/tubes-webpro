<!-- pages/cashier.php -->
<?php
session_start();
require_once '../configdb.php';

// Jika role bukan cashier, redirect kembali
if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'cashier') {
    header("Location: dashboard.php");
    exit();
}

$title = "Dashboard Kasir";

// --------------------------------------------------
// 1) Proses FORM UPDATE STOK
// --------------------------------------------------
$update_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_id'], $_POST['new_stock'])) {
    $menu_id   = (int) $_POST['menu_id'];
    $new_stock = (int) $_POST['new_stock'];

    // Validasi sederhana: stok minimal 0
    if ($new_stock < 0) {
        $update_message = "Stok tidak boleh negatif.";
    } else {
        $stmt = $conn->prepare("UPDATE menu SET quantity = ? WHERE id = ?");
        $stmt->bind_param('ii', $new_stock, $menu_id);
        if ($stmt->execute()) {
            $update_message = "Stok berhasil diperbarui untuk item ID $menu_id.";
        } else {
            $update_message = "Gagal memperbarui stok: " . $stmt->error;
        }
        $stmt->close();
    }
}

// --------------------------------------------------
// 2) Ambil SELURUH DATA MENU (id, name, price, quantity)
// --------------------------------------------------
$menuList = $conn->query("SELECT id, name, price, quantity FROM menu");
?>
<?php include '../views/header.php'; ?>
<?php include '../views/navbar.php'; ?>
<?php include '../views/sidebar.php'; ?>

<div class="main-content">
    <!-- Notifikasi sukses atau error -->
    <?php if ($update_message !== ''): ?>
        <?php 
        $cls = (strpos($update_message, 'berhasil') !== false) 
               ? 'alert alert-success alert-dismissible fade show mt-2' 
               : 'alert alert-danger alert-dismissible fade show mt-2'; 
        ?>
        <div class="<?= $cls ?>" role="alert">
            <?= htmlspecialchars($update_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Konten khusus kasir (tetap seperti semula) -->
    <!-- kalian bisa menaruh konten lain di sini... -->

    <!-- ============================================================== -->
    <!-- DI BAWAH INI: Tabel untuk MELIHAT & MENGUBAH STOK (TANPA MENGUBAH STYLING) -->
    <!-- ============================================================== -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Kelola Stok Menu</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 35%;">Nama Makanan</th>
                            <th style="width: 20%;">Harga (Rp)</th>
                            <th style="width: 15%;">Stok Saat Ini</th>
                            <th style="width: 15%;">Stok Baru</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($menuList && $menuList->num_rows > 0): ?>
                            <?php while ($row = $menuList->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= number_format($row['price'], 0, ',', '.') ?></td>
                                    <td><?= $row['quantity'] ?></td>
                                    <td>
                                        <form method="post" action="" class="d-flex">
                                            <input 
                                                type="hidden" 
                                                name="menu_id" 
                                                value="<?= $row['id'] ?>"
                                            >
                                            <input 
                                                type="number" 
                                                name="new_stock" 
                                                value="<?= $row['quantity'] ?>" 
                                                min="0"
                                                class="form-control form-control-sm"
                                                style="width: 80px;"
                                            >
                                    </td>
                                    <td>
                                            <button 
                                                type="submit" 
                                                class="btn btn-sm btn-primary"
                                                name="update_stock"
                                            >
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data menu.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- SELESAI Bagian Tabel Pengaturan Stok -->
    <!-- ============================================================== -->
</div>

<?php include '../views/footer.php'; ?>
