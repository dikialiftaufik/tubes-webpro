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

require_once 'views/header-land-page.php';
require_once 'views/navbar-land-page.php';
require_once 'views/alerts-land-page.php';
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
        <form class="feedback-form" action="process_feedback.php" method="POST">
          <!-- ID User akan diambil dari session secara otomatis -->
          <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
          
          <!-- Tanggal akan diisi dengan tanggal saat ini secara otomatis -->
          <input type="hidden" name="tgl_masukan" value="<?= date('Y-m-d H:i:s') ?>">

          <div class="form-group">
            <label for="judul_masukan">Judul Masukan</label>
            <input type="text" name="judul_masukan" id="judul_masukan" placeholder="Masukkan Judul Masukan" required>
          </div>

          <div class="form-group">
            <label for="pesan_masukan">Pesan Masukan</label>
            <textarea name="pesan_masukan" id="pesan_masukan" placeholder="Masukkan Pesan Anda" rows="4" required></textarea>
          </div>

          <div class="form-group">
            <button type="submit" name="submit_feedback">Kirim Masukan</button>
          </div>
        </form>
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
