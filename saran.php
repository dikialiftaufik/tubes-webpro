<?php
// Proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $masukan = $_POST['masukan'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "bolooo");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Simpan data ke tabel feedback
    $stmt = $conn->prepare("INSERT INTO feedback (nama, masukan) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $masukan);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Masukan berhasil dikirim!'); window.location.href='saran.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim masukan.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masukan untuk BOLOOO</title>
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="css/style.css" />
    <style>
        body {
            background: linear-gradient(45deg, #0f2027, #203a43, #2c5364);
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        h1 {
            text-align: center;
            color: #f60b0b;
        }
        .inspirational-text {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
            color: #d6a72f;
            font-size: 1.2rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        textarea, input[type="text"] {
            margin-bottom: 20px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button {
            background-color: #d6a72f;
            color: #000;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background-color: #f8110d;
            transform: scale(1.05);
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #333;
            border-radius: 4px;
        }
        .footer {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }
        .footer-social {
            margin: 10px 0;
        }
        .footer-social a {
            margin: 0 10px;
            color: #fff;
            font-size: 1.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer-social a:hover {
            color: #f8110d;
        }
    </style>
    <nav id="nav-desktop">
      <div class="nav large-container">
        <ul>
          <li data-aos="fade-down" data-aos-duration="500">
            <a href="index.php">Home</a>
          </li>
          <li
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="100"
          >
            <a href="AboutUs.html">About</a>
          </li>
          <li
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="200"
          >
            <a href="Makanan.php">Menu</a>
          </li>
          <li
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="400"
          >
            <a href="index.php #reservation">Reservasi</a>
          </li>
        </ul>

        <img
          src="img/logo/logo.png"
          data-aos="fade-down"
          data-aos-duration="500"
          data-aos-delay="300"
          alt="logo"
          width="150px"
          height="100px"
        />

        <ul>
          <li
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="500"
          >
            <a href="index.php #location">Lokasi</a>
          </li>
          <li
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="600"
          >
            <a href="findJobs.php">Karir</a>
          </li>
          <li
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="700"
          >
            <a href="findJobs.html">
              <i class="fas fa-shopping-cart"></i>
            </a>
          </li>

          <!-- Notification -->
          <li
class="notification-dropdown"
data-aos="fade-down"
data-aos-duration="500"
data-aos-delay="800"
>
<a href="#">
  <i class="fas fa-bell"></i>
  <span class="notification-badge">3</span>
</a>
<div class="dropdown-content">
  <div class="notification-item">
    <img src="img/notification/1.avif" alt="Promo Tahun Baru" />
    <div class="notification-text">
      <h4>Promo Tahun Baru</h4>
      <p>Diskon hingga 50% untuk semua menu!</p>
    </div>
  </div>
  <div class="notification-item">
    <img src="img/notification/sate-goreng.jpg" alt="Promo Makan Hemat" />
    <div class="notification-text">
      <h4>Menu Baru Wajib Coba!</h4>
      <p>Rasakan kenikmatan sate goreng ayam!</p>
    </div>
  </div>
  <div class="notification-item">
    <img src="img/notification/4.webp" alt="Reservasi Spesial" />
    <div class="notification-text">
      <h4>Jam Operasional Baru</h4>
      <p>Sekarang kami buka hingga pukul 21:00!</p>
    </div>
  </div>
</div>
</li>

<!-- User -->
<li
class="user-dropdown"
data-aos="fade-down"
data-aos-duration="500"
data-aos-delay="900"
>
<a href="#">
  <i class="fas fa-user"></i>
</a>
<div class="dropdown-content-user">
  <div class="user-info">
    <img src="img/profile-pic.png" alt="User Profile" />
    <div class="user-name">dikialift13</div>
  </div>
  <div class="dropdown-divider"></div>
  <a href="account.html" class="dropdown-item">
    <i class="fas fa-user-cog"></i> <p> Akun Saya</p>
  </a>
  <a href="orders.html" class="dropdown-item">
    <i class="fas fa-box"></i> <p> Pesanan Saya</p>
  </a>
  <a href="reservations.html" class="dropdown-item">
    <i class="fas fa-calendar-alt"></i> <p> Reservasi Saya</p>
  </a>
  <div class="dropdown-divider"></div>
  <a href="signout.html" class="dropdown-item logout">
    <i class="fas fa-sign-out-alt"></i> <p> Sign Out</p>
  </a>
</div>
</li>


        </ul>
      </div>
    </nav>

    <nav id="nav-mobile">
      <div class="nav-mobile">
        <div class="nav large-container">
          <img
            src="img/logo/logo-alt.png"
            data-aos="fade-down"
            data-aos-duration="500"
            data-aos-delay="200"
            alt="logo-alt"
            width="50px"
            height="50px"
          />
          <div id="burger-navigation">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
      </div>

      <div class="nav-mobile-main">
        <div>
          <a href="index.php">Home</a>
        </div>
        <div>
          <a href="about.html">About Us</a>
        </div>
        <div>
          <a href="Makanan.php">Menu</a>
        </div>
        <div>
          <a href="#reservation">Reservation</a>
        </div>
        <div>
          <a href="#location">Location</a>
        </div>
        <div>
          <a href="findJobs.html">Find Jobs</a>
        </div>
      </div>
    </nav>
</head>
<body>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  
    <div class="container" data-aos="fade-up" data-aos-duration="800">
        <h1>Masukan untuk BOLO</h1>
        <p class="inspirational-text">"Kritik dan saran Anda membantu kami menjadi lebih baik setiap harinya. Terima kasih telah berkontribusi!"</p>
        <form method="POST" action="">
            <label>Nama:</label><br>
            <input type="text" id="name" name="nama" placeholder="Masukkan Nama Anda">
            <label>Masukan:</label><br>
            <textarea id="feedback" name="masukan" placeholder="Tulis kritik dan saran Anda di sini..."></textarea>
            <button type="submit">Kirim Masukan</button>
        </form>

        <div id="messageDisplay" class="message" style="display: none;">
            <h3>Terima kasih masukan Anda sudah dikirim!</h3>
            <p><strong>Nama:</strong> <span id="displayName"></span></p>
            <p><strong>Pesan:</strong> <span id="displayMessage"></span></p>
        </div>
    </div>

    <footer>
      <div class="footer-info">
        <div class="footer-info-items main-container">
          <div data-aos="fade-up">
            <h3>Welcome to BOLOO</h3>
            <p>Welcome to BOLOO, where every bite is a story.</p>
            <p>
              Step into our cozy haven, where the warmth of heartfelt
              hospitality invite you to unwind and savor moments of delightful
              indulgence.
            </p>
          </div>
          <div data-aos="fade-up" data-aos-delay="100">
            <h3>Visit</h3>
            <p>
              Jl. Sukapura No.76, Cipagalo, Kec. Bojongsoang, Kabupaten Bandung,
              Jawa Barat 40287
            </p>
  
            <h3>Talk</h3>
            <p>6281215486311</p>
  
            <h3>Write</h3>
            <p>BOLOOO.food@gmail.com</p>
          </div>
  
          <div data-aos="fade-up" data-aos-delay="200">
            <h3>Download App</h3>
            <div>
              <a href="formPemesanan.html">
                <img
                  src="img/logo/google-play-icon.png"
                  alt="Google Play"
                  width="225px"
                  height="65px"
              /></a>
            </div>
  
            <div>
              <a href="formPemesanan.html">
                <img
                  src="img/logo/app-store-icon.png"
                  alt="App Store"
                  width="225px"
                  height="65px"
              /></a>
            </div>
          </div>
        </div>
      </div>
  
      <div class="footer-copyright">
        <div class="footer-items large-container">
          <div class="footer-left">&copy; 2024 BOLOO. All rights reserved</div>
      
          <div class="footer-mid">
            <img
              src="img/logo/logo.png"
              alt="logo"
              width="150px"
              height="100px"
            />
  
    
        <!-- Tombol Kritik dan Saran -->
        <div class="footer-feedback">
          <button onclick="window.location.href='saran.html'" class="feedback-button">Kritik dan Saran</button>
        </div>
      </div>
    </div>
    
        <div class="footer-right">Taste the Difference</div>
      </div>
    </div>
  </footer>


    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();

        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const feedback = document.getElementById('feedback').value;

            if (name && feedback) {
                document.getElementById('displayName').textContent = name;
                document.getElementById('displayMessage').textContent = feedback;
                document.getElementById('messageDisplay').style.display = 'block';

                document.getElementById('feedbackForm').reset();
            } else {
                alert('Silakan isi semua kolom.');
            }
        });
    </script>
</body>
</html>
