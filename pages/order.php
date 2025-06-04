<?php
session_start();
require_once '../configdb.php';

if ($_SESSION['user']['role'] !== 'cashier') {
    header("Location: dashboard.php");
    exit();
}

// Proses update status jika tombol ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['new_status'])) {
    $order_id = (int) $_POST['order_id'];
    $new_status = $_POST['new_status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['success_message'] = "Status pesanan berhasil diperbarui.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$title = "Dashboard Kasir";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';

// Ambil data pesanan
$orders = [];
$sql = "SELECT o.id AS order_id, o.status, o.created_at,
               m.name AS nama_makanan, m.image_url,
               oi.quantity, oi.price_at_order
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN menu m ON oi.menu_id = m.id
        ORDER BY o.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$total_harian = 0;
$tanggal_hari_ini = date('Y-m-d');

while ($row = $result->fetch_assoc()) {
    $orders[$row['order_id']]['items'][] = $row;
    $orders[$row['order_id']]['status'] = $row['status'];
    $orders[$row['order_id']]['created_at'] = $row['created_at'];

    if (substr($row['created_at'], 0, 10) === $tanggal_hari_ini) {
        $total_harian += $row['price_at_order'] * $row['quantity'];
    }
}
?>

<div class="main-content">
    <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <?= $_SESSION['success_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <div class="container py-4">
      <div class="row g-4">
        <?php foreach ($orders as $orderId => $orderData): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <h6 class="mb-0">#<?= htmlspecialchars($orderId) ?></h6>
                  <small class="text-muted"><?= date('j F Y, H:i', strtotime($orderData['created_at'])) ?></small>
                </div>
              </div>

              <?php foreach ($orderData['items'] as $item): ?>
              <div class="d-flex align-items-center mb-2">
                <img src="../uploads/menu/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['nama_makanan']) ?>" class="rounded me-3" width="60" height="60">
                <div>
                  <h6 class="mb-1 mb-0"><?= htmlspecialchars($item['nama_makanan']) ?></h6>
                  <small class="text-muted"><?= $item['quantity'] ?>x - Rp <?= number_format($item['price_at_order'], 0, ',', '.') ?>/porsi</small>
                </div>
              </div>
              <?php endforeach; ?>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <strong>Total:</strong>
                <strong class="text-primary">Rp <?= number_format(array_sum(array_map(function($i){ return $i['price_at_order'] * $i['quantity']; }, $orderData['items'])), 0, ',', '.') ?></strong>
              </div>

              <form method="POST" class="mt-3">
                <input type="hidden" name="order_id" value="<?= $orderId ?>">
                <?php if ($orderData['status'] === 'pending'): ?>
                  <button type="submit" name="new_status" value="processing" class="btn btn-warning w-100">Tandai Sudah siap</button>
                <?php elseif ($orderData['status'] === 'processing'): ?>
                  <button type="submit" name="new_status" value="completed" class="btn btn-success w-100">Tandai Siap</button>
                <?php endif; ?>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-5 text-end">
        <h5>Total Pendapatan Hari Ini: <span class="text-success">Rp <?= number_format($total_harian, 0, ',', '.') ?></span></h5>
      </div>
    </div>
</div>

<?php include '../views/footer.php'; ?>
