<!-- File: Makanan.php -->
<?php
require_once '../configdb.php';
include '../views/header.php'; // Jika ada header umum
?>

<div class="container mt-5">
    <h2 class="mb-4">Menu Main Course</h2>
    <div class="row">
        <?php
        $query = "SELECT * FROM menu WHERE type = 'main_course'";
        $result = mysqli_query($conn, $query);
        
        while($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="img/main-course/<?= $row['image_url'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['name'] ?></h5>
                    <p class="card-text"><?= $row['description'] ?></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Harga: Rp <?= number_format($row['price'], 0, ',', '.') ?></li>
                        <li class="list-group-item">Kalori: <?= $row['calories'] ?> kkal</li>
                        <li class="list-group-item">Bahan: <?= $row['ingredients'] ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../views/footer.php'; // Jika ada footer umum ?>