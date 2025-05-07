<?php
require_once 'configdb.php';
include 'views/header.php';
// Query untuk mengambil data makanan
$sql = "SELECT name AS nama_makanan, price AS harga, image_url AS gambar, description AS deskripsi FROM menu";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu Makanan</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color:rgb(13, 13, 13);
      margin: 0;
      padding: 0;
    }
    .container {
      width: 90%;
      max-width: 1200px;
      margin: auto;
      padding: 40px 0;
    }
    h1 {
      text-align: center;
      margin-bottom: 40px;
      color: white;
    }
    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
      overflow: hidden;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .card h2 {
      font-size: 1.5rem;
      margin: 16px;
    }
    .card p {
      margin: 0 16px 16px;
      color: #555;
    }
    .order-button {
      display: block;
      width: calc(100% - 32px);
      margin: 0 16px 16px;
      padding: 10px;
      background-color: rgb(233, 2, 2);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      text-align: center;
      text-decoration: none;
    }
    .order-button:hover {
      background-color: rgb(124, 9, 9);
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Menu Makanan</h1>
    <div class="card-container">

      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="card">
            <img src="assets/images/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_makanan']); ?>" />
            <h2><?php echo htmlspecialchars($row['nama_makanan']); ?></h2>
            <p><?php echo htmlspecialchars($row['deskripsi'] ?? ''); ?></p>
            <p>Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
            <a href="pages/order.php?menu=<?php echo urlencode($row['nama_makanan']); ?>" class="order-button">
              <i class="fas fa-shopping-cart"></i> Pesan
            </a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align: center; color: white;">Tidak ada data makanan tersedia.</p>
      <?php endif; ?>

    </div>
  </div>

  <!-- Tambahan script JS jika dibutuhkan -->
  <script src="assets/js/script.js"></script>
</body>
</html>

<?php include 'views/footer.php'; ?>
