<?php
// formPemesanan.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Restaurant</title>

  <!-- Inline CSS -->
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    header, nav {
      background-color: #333;
      color: white;
    }

    nav ul {
      list-style: none;
      padding: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 0;
    }

    nav ul li {
      margin: 0 10px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      padding: 10px;
      display: block;
    }

    nav ul li a:hover {
      background-color: #444;
      border-radius: 4px;
    }

    .fas.fa-shopping-cart {
      font-size: 24px;
      color: white;
    }

    .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
    }

    .nav img {
      height: 80px;
    }

    .menu-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 40px 10%;
      border-bottom: 1px solid #ccc;
    }

    .menu-section:nth-child(even) {
      flex-direction: row-reverse;
    }

    .content-wrapper {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
    }

    .text-content {
      flex: 1;
      padding: 20px;
    }

    .text-content h2 {
      font-size: 2em;
      margin-bottom: 10px;
    }

    .text-content p {
      font-size: 1.1em;
      margin-bottom: 15px;
    }

    .explore-btn {
      background-color: #ff4500;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 5px;
      font-size: 1em;
    }

    .explore-btn:hover {
      background-color: #e63e00;
    }

    .image-content {
      flex: 1;
      text-align: center;
    }

    .menu-image {
      width: 100%;
      max-width: 400px;
      border-radius: 10px;
    }

    @media (max-width: 768px) {
      .menu-section,
      .content-wrapper {
        flex-direction: column;
        text-align: center;
      }

      .image-content,
      .text-content {
        padding: 10px;
      }
    }
  </style>

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

  <header>
    <nav>
      <div class="nav">
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../AboutUs.php">About</a></li>
          <li><a href="Makanan.php">Menu</a></li>
          <li><a href="#reservation">Reservasi</a></li>
        </ul>
        <img src="../img/logo/logo.png" alt="logo" />
        <ul>
          <li><a href="#location">Lokasi</a></li>
          <li><a href="../findJobs.php">Karir</a></li>
          <li><a href="keranjang.php"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
      </div>
    </nav>
  </header>

  <section class="menu-section">
    <div class="content-wrapper">
      <div class="text-content">
        <h2>MAKANAN</h2>
        <p>Makanan khas Jawa Tengah yang otentik dengan bahan-bahan berkualitas.</p>
        <a href="Makanan.php"><button class="explore-btn">LIHAT MENU »</button></a>
      </div>
      <div class="image-content">
        <img src="../img/logo/menumakanan.jpg" alt="MAKANAN" class="menu-image" />
      </div>
    </div>
  </section>

  <section class="menu-section">
    <div class="content-wrapper">
      <div class="image-content">
        <img src="../img/logo/minuman.webp" alt="MINUMAN" class="menu-image" />
      </div>
      <div class="text-content">
        <h2>MINUMAN</h2>
        <p>Minuman yang cocok untuk menemani makanmu.</p>
        <a href="Minuman.php"><button class="explore-btn">LIHAT MENU »</button></a>
      </div>
    </div>
  </section>

  <section class="menu-section">
    <div class="content-wrapper">
      <div class="image-content">
        <img src="../img/img/main-course/sidedish.jpg" alt="Side Dish" class="menu-image" />
      </div>
      <div class="text-content">
        <h2>SIDE DISH</h2>
        <p>Lengkapi hidangan utama Anda dengan berbagai pilihan side dish lezat kami.</p>
        <a href="sidedish.php"><button class="explore-btn">LIHAT MENU »</button></a>
      </div>
    </div>
  </section>

  <section class="menu-section">
    <div class="content-wrapper">
      <div class="image-content">
        <img src="../img/Paket Pa Gesit.png" alt="Paket" class="menu-image" />
      </div>
      <div class="text-content">
        <h2>PAKET</h2>
        <p>Paket yang cocok dengan kamu.</p>
        <a href="paket.php"><button class="explore-btn">LIHAT MENU »</button></a>
      </div>
    </div>
  </section>
  

</body>
</html>

