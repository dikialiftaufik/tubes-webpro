<?php
session_start();

// Fungsi untuk menampilkan pesan error
function display_error($message) {
    echo "<div class='error-message'>$message</div>";
}

// Memproses pengiriman formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    
    // Validasi nama
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    if (empty($nama)) {
        $errors[] = "Nama pelanggan harus diisi";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $errors[] = "Nama hanya boleh mengandung huruf dan spasi";
    }
    
    // Validasi email
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    if (empty($email)) {
        $errors[] = "Email pelanggan harus diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    // Validasi telepon
    $telepon = isset($_POST['telepon']) ? trim($_POST['telepon']) : '';
    if (empty($telepon)) {
        $errors[] = "Nomor telepon harus diisi";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $telepon)) {
        $errors[] = "Nomor telepon harus terdiri dari 10-15 digit angka";
    }
    
    // Validasi pesanan
    if (!isset($_SESSION['pesanan']) || empty($_SESSION['pesanan'])) {
        $errors[] = "Tidak ada pesanan yang ditemukan";
    }
    
    // Jika tidak ada error, lanjutkan ke halaman konfirmasi
    if (empty($errors)) {
        // Simpan data ke session untuk digunakan di halaman konfirmasi
        $_SESSION['data_pembayaran'] = [
            'nama' => $nama,
            'email' => $email,
            'telepon' => $telepon,
            'totalQuantity' => $_SESSION['totalQuantity'],
            'totalPrice' => $_SESSION['totalPrice']
        ];
        
        header("Location: konfirmasi.php");
        exit();
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laman Pembayaran</title>
    <link rel="stylesheet" href="css/css/lamanpembayaran.css" />
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    .error-message {
        color: #dc3545;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        text-align: center;
    }

    .form-group input:invalid {
        border-color: #dc3545;
    }

    .form-group input:valid {
        border-color: #28a745;
    }
    </style>
</head>
<body>
    <header>
        <nav id="nav-desktop">
            <div class="nav large-container">
                <ul>
                    <li data-aos="fade-down" data-aos-duration="500">
                        <a href="index.php">Home</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="100">
                        <a href="AboutUs.php">About</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="200">
                        <a href="Makanan.php">Menu</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="400">
                        <a href="#reservation">Reservasi</a>
                    </li>
                </ul>
            
                <img src="img/logo/logo.png" data-aos="fade-down" data-aos-duration="500" data-aos-delay="300" alt="logo" width="150px" height="100px" />
            
                <ul>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="500">
                        <a href="#location">Lokasi</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="600">
                        <a href="findJobs.php">Karir</a>
                    </li>
                    <li data-aos="fade-down" data-aos-duration="500" data-aos-delay="700">
                        <a href="keranjang.php">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <nav id="nav-mobile">
            <div class="nav-mobile">
                <div class="nav large-container">
                    <img src="img/logo/logo-alt.png" data-aos="fade-down" data-aos-duration="500" data-aos-delay="200" alt="logo-alt" width="50px" height="50px" />
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
                    <a href="about.php">About Us</a>
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
                    <a href="findJobs.php">Find Jobs</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-pembayaran">
            <?php
            // Tampilkan pesan error jika ada
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    display_error($error);
                }
            }
            ?>
            
            <div class="form-group">
                <label for="nama">Nama Pelanggan</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    placeholder="Masukkan nama Anda"
                    value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>"
                    pattern="[a-zA-Z ]+"
                    required
                />
            </div>

            <div class="form-group">
                <label for="email">Email Pelanggan</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan email Anda"
                    value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                    required
                />
            </div>

            <div class="form-group">
                <label for="telepon">Nomor Telepon Pelanggan</label>
                <input
                    type="tel"
                    id="telepon"
                    name="telepon"
                    placeholder="Masukkan nomor telepon"
                    value="<?php echo isset($telepon) ? htmlspecialchars($telepon) : ''; ?>"
                    pattern="[0-9]{10,15}"
                    required
                />
            </div>

            <div class="container">
                <header>
                    <h1>Rincian Pembayaran</h1>
                </header>
            
                <main>
                    <h2>Pesanan Anda:</h2>
                    <ul id="pesanan-list">
                        <?php
                        // Versi PHP untuk menampilkan pesanan dari sesi alih-alih localStorage
                        if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])) {
                            $totalQuantity = 0;
                            $totalPrice = 0;
                            
                            foreach ($_SESSION['pesanan'] as $item) {
                                echo "<li>{$item['name']} ({$item['quantity']}) - Rp " . ($item['price'] * $item['quantity']) . "</li>";
                                $totalQuantity += $item['quantity'];
                                $totalPrice += $item['price'] * $item['quantity'];
                            }
                            
                            // Simpan nilai-nilai ini untuk digunakan di bagian informasi total
                            $_SESSION['totalQuantity'] = $totalQuantity;
                            $_SESSION['totalPrice'] = $totalPrice;
                        } else {
                            echo "<li>Pesanan tidak ditemukan</li>";
                            $_SESSION['totalQuantity'] = 0;
                            $_SESSION['totalPrice'] = 0;
                        }
                        ?>
                    </ul>
            
                    <div class="total-info">
                        <p>Total Makanan: <span id="total-quantity"><?php echo isset($_SESSION['totalQuantity']) ? $_SESSION['totalQuantity'] : 0; ?></span></p>
                        <p>Total Harga: Rp <span id="total-price"><?php echo isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0; ?></span></p>
                    </div>
                </main>
            </div>
            
            <div class="form-group">
                <label for="metode">Metode Pembayaran</label>
                <input type="text" id="metode" name="metode" value="QRIS" readonly />
            </div>

            <button class="order-button" type="submit">
                Lanjutkan pembayaran
            </button>
        </form>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // JavaScript ini dipertahankan untuk kompatibilitas mundur
        // Jika penanganan sesi PHP belum diimplementasikan sepenuhnya, ini masih akan berfungsi
        const pesananItems = JSON.parse(localStorage.getItem("pesanan")) || [];
        const pesananList = document.getElementById("pesanan-list");
        const totalQuantityElement = document.getElementById("total-quantity");
        const totalPriceElement = document.getElementById("total-price");
        
        // Hanya gunakan data JavaScript jika PHP belum mengisi daftar
        if (pesananList.children.length === 1 && pesananList.children[0].textContent === "Pesanan tidak ditemukan" && pesananItems.length > 0) {
            let totalQuantity = 0;
            let totalPrice = 0;
            pesananList.innerHTML = '';
            pesananItems.forEach(item => {
                const li = document.createElement("li");
                li.textContent = `${item.name} (${item.quantity}) - Rp ${item.price * item.quantity}`;
                pesananList.appendChild(li);
                totalQuantity += item.quantity;
                totalPrice += item.price * item.quantity;
            });
            totalQuantityElement.textContent = totalQuantity;
            totalPriceElement.textContent = totalPrice;
        }
        
        // Validasi client-side sebelum submit
        const form = document.querySelector('.form-pembayaran');
        form.addEventListener('submit', (e) => {
            let isValid = true;
            
            // Validasi nama
            const nama = document.getElementById('nama');
            if (!nama.value.trim()) {
                isValid = false;
                alert('Nama pelanggan harus diisi');
                nama.focus();
                e.preventDefault();
                return false;
            } else if (!/^[a-zA-Z ]+$/.test(nama.value)) {
                isValid = false;
                alert('Nama hanya boleh mengandung huruf dan spasi');
                nama.focus();
                e.preventDefault();
                return false;
            }
            
            // Validasi email
            const email = document.getElementById('email');
            if (!email.value.trim()) {
                isValid = false;
                alert('Email pelanggan harus diisi');
                email.focus();
                e.preventDefault();
                return false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                isValid = false;
                alert('Format email tidak valid');
                email.focus();
                e.preventDefault();
                return false;
            }
            
            // Validasi telepon
            const telepon = document.getElementById('telepon');
            if (!telepon.value.trim()) {
                isValid = false;
                alert('Nomor telepon harus diisi');
                telepon.focus();
                e.preventDefault();
                return false;
            } else if (!/^[0-9]{10,15}$/.test(telepon.value)) {
                isValid = false;
                alert('Nomor telepon harus terdiri dari 10-15 digit angka');
                telepon.focus();
                e.preventDefault();
                return false;
            }
            
            // Validasi pesanan
            const pesananItems = <?php echo isset($_SESSION['pesanan']) ? json_encode($_SESSION['pesanan']) : '[]'; ?>;
            if (pesananItems.length === 0 && JSON.parse(localStorage.getItem("pesanan") || "[]").length === 0) {
                isValid = false;
                alert('Tidak ada pesanan yang ditemukan');
                e.preventDefault();
                return false;
            }
            
            return isValid;
        });
    });
    </script>
</body>
</html>