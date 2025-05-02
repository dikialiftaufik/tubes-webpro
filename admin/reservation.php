<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservasi</title>
    <link rel="icon" type="image/x-icon" href="../img/logo/logo-alt.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
      <div class="logo-container">
        <img src="../img/logo/logo-alt.png" alt="Logo" />
        <span>BOLOOO</span>
      </div>
      <div class="menu-item active-menu-item">
        <a href="dashboard.html"
          ><i class="bi bi-house-door me-2"></i> <span>Dashboard</span></a
        >
      </div>
      <div class="menu-item">
        <a href="mainCourse.html"
          ><i class="bi bi-egg-fried me-2"></i> <span>Main Course</span></a
        >
      </div>
      <div class="menu-item">
        <a href="drinks.html"
          ><i class="bi bi-cup me-2"></i> <span>Drinks</span></a
        >
      </div>
      <div class="menu-item">
        <a href="sideDish.html"
          ><i class="bi bi-egg me-2"></i></i> <span>Side Dish</span></a
        >
      </div>
      <div class="menu-item">
        <a href="package.html"
          ><i class="bi bi-basket3 me-2"></i></i> <span>Paket</span></a
        >
      </div>
      <div class="menu-item">
        <a href="order.html"
          ><i class="bi bi-cart3 me-2"></i> <span>Pesanan</span></a
        >
      </div>
      <div class="menu-item">
        <a href="reservation.html"
          ><i class="bi bi-calendar2-check me-2"></i> <span>Reservasi</span></a
        >
      </div>
      <div class="menu-item">
        <a href="jobs.html"
          ><i class="bi bi-briefcase me-2"></i> <span>Karir</span></a
        >
      </div>
      <div class="menu-item">
        <a href="applicant.html"
          ><i class="bi bi-person me-2"></i> <span>Pelamar</span></a
        >
      </div>
      <div class="menu-item">
        <a href="users.html"
          ><i class="bi bi-person me-2"></i> <span>Users</span></a
        >
      </div>
      <div class="menu-item">
        <a href="report.html"
          ><i class="bi bi-bar-chart-line me-2"></i> <span>Report</span></a
        >
      </div>     
    </div>

    <!-- Main Content -->
    <div id="content" class="content">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm rounded">
        <div class="container-fluid">
          <button id="toggleSidebar" class="btn btn-outline-secondary me-3">
            <i class="bi bi-list"></i>
          </button>
          <a class="navbar-brand" href="#">Reservasi</a>
          <div class="dropdown ms-auto">
            <button
              class="profile-button rounded"
              type="button"
              id="profileDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <img
                src="fotozufar.jpg"
                alt="Profile"
                class="rounded-circle"/>
              <div class="text-start">
                <strong>Ahmad Zufar</strong><br />
                <small class="text-muted">Super Admin</small>
              </div>
            </button>
            <ul
              class="dropdown-menu dropdown-menu-end profile-dropdown shadow"
              aria-labelledby="profileDropdown">
              <li>
                <a
                  class="dropdown-item"
                  href="#"
                  data-bs-toggle="modal"
                  data-bs-target="#profileModal">
                  <i class="bi bi-person me-2"></i>Profil
                </a>
              </li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <a class="dropdown-item text-danger" href="login.html"
                  ><i class="bi bi-box-arrow-right me-2"></i>Keluar</a>
              </li>
            </ul>
          </div>

          <!-- Profile Modal -->
          <div
            class="modal fade"
            id="profileModal"
            tabindex="-1"
            aria-labelledby="profileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="profileModalLabel">Profil</h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                  </button>
                </div>
                <div class="modal-body">
                  <form id="profileForm">
                    <div class="mb-3 text-center">
                      <img
                        id="profilePicturePreview"
                        src="../img/profile-pic.png"
                        alt="Profile Picture"
                        class="rounded-circle mb-2"
                        style="width: 100px; height: 100px"/>
                        <br />
                      <button
                        type="button"
                        id="editPictureButton"
                        class="btn btn-outline-primary btn-sm mt-2"
                        style="display: none">
                        Ubah Foto Profil</button><br /><br />
                      <input
                        type="file"
                        id="profilePictureInput"
                        class="form-control"
                        style="display: none"
                        accept="image/*"/>
                    </div>

                    <!-- Two-Column Layout -->
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="name" class="form-label"
                          >Nama Lengkap</label>
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="bi bi-person"></i>
                          </span>
                          <input
                            type="text"
                            id="name"
                            class="form-control"
                            value="Diki Alif"
                            disabled/>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="username" class="form-label"
                          >Username</label>
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="bi bi-person"></i>
                          </span>
                          <input
                            type="text"
                            id="username"
                            class="form-control"
                            value="dikialif"
                            disabled/>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                          <label for="email" class="form-label">Email</label>
                          <div class="input-group">
                            <span class="input-group-text">
                              <i class="bi bi-envelope"></i>
                            </span>
                            <input
                              type="email"
                              id="email"
                              class="form-control"
                              value="dikialif@gmail.com"
                              disabled/>
                          </div>
                        </div>
                        <div class="col-md-6">
                        <label for="password" class="form-label"
                          >Password</label>
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                          </span>
                          <input
                            type="password"
                            id="password"
                            class="form-control"
                            value="admin123"
                            disabled/>
                        </div>
                      </div>
                      
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Tutup
                  </button>
                  <button type="button" id="editButton" class="btn btn-success">
                    Edit
                  </button>
                  <button
                    type="button"
                    id="saveButton"
                    class="btn btn-success"
                    style="display: none">
                    Simpan
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="main-content">
        
      <div class="table-container">
        <table
          id="menuTable"
          class="table table-hover display responsive nowrap"
          style="width: 100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>Jumlah Orang</th>
              <th>Tanggal & Waktu</th>
              <th>Pesanan</th>
              <th>Status Reservasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    
      <!-- Add Menu Modal -->
    <div class="modal fade" id="addMenuModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Menu Baru</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal">
            </button>
          </div>
          <div class="modal-body">
            <form id="addMenuForm">
              <div class="mb-3">
                <label class="form-label">Gambar Menu</label>
                <input
                  type="file"
                  class="form-control"
                  id="menuImage"
                  accept="image/*"
                  required
                />
                <div id="imagePreview"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input
                  type="text"
                  class="form-control"
                  id="menuName" placeholder="Masukkan Nama Menu"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input
                  type="number" step="0.001"
                  class="form-control"
                  id="menuPrice" placeholder="Masukkan Harga"
                  required
                  min="0"
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Kalori (kkal)</label>
                <input
                  type="number"
                  class="form-control"
                  id="menuCalories" placeholder="Masukkan Kalori"
                  required
                  min="0"
                />
              </div>
              <div class="mb-3">
                <label class="form-label" for="menuIngredients">Bahan Utama</label>
<input id="menuIngredients" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea
                  class="form-control"
                  id="menuDescription" placeholder="Masukkan Deskripsi"
                  rows="3"
                  required
                ></textarea>
              </div>
              
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Batal
            </button>
            <button type="button" class="btn btn-success" id="saveMenu">
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Menu Modal -->
    <div class="modal fade" id="editMenuModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Menu</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            <form id="editMenuForm">
              <input type="hidden" id="editMenuId" />
              <div class="mb-3">
                <label class="form-label">Gambar Menu</label>
                <input
                  type="file"
                  class="form-control"
                  id="editMenuImage"
                  accept="image/*"
                />
                <div id="editImagePreview"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input
                  type="text"
                  class="form-control"
                  id="editMenuName"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input
                  type="number" step="0.001"
                  class="form-control"
                  id="editMenuPrice"
                  required
                  min="0"
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Kalori (kkal)</label>
                <input
                  type="number"
                  class="form-control"
                  id="editMenuCalories"
                  required
                  min="0"
                />
              </div>
              <div class="mb-3">
                <label class="form-label" for="editMenuIngredients">Bahan Utama</label>
                <input id="editMenuIngredients" required />
              </div>              
              <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea
                  class="form-control"
                  id="editMenuDescription"
                  rows="3"
                  required
                ></textarea>
              </div>
              
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Batal
            </button>
            <button type="button" class="btn btn-primary" id="updateMenu">
              Perbarui
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteMenuModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Menu</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            <p>
              Are you sure you want to delete this menu item? This action cannot
              be undone.
            </p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cancel
            </button>
            <button type="button" class="btn btn-danger" id="confirmDelete">
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
      
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = $("#menuTable").DataTable({
        data: [
            { 
                no: 1, 
                nama: "Ega", 
                jumlahOrang: 4, 
                tanggalWaktu: "01-01-2025 19:00", 
                pesanan: "Sate Ayam", 
                status: "Tidak tersedia" 
            },
            { 
                no: 2, 
                nama: "Rina", 
                jumlahOrang: 2, 
                tanggalWaktu: "02-01-2025 18:30", 
                pesanan: "Nasi Goreng Kambing", 
                status: "Tersedia" 
            },
            { 
                no: 3, 
                nama: "Budi", 
                jumlahOrang: 5, 
                tanggalWaktu: "03-01-2025 20:00", 
                pesanan: "Ayam Geprek", 
                status: "Tersedia" 
            },
            { 
                no: 4, 
                nama: "Sari", 
                jumlahOrang: 3, 
                tanggalWaktu: "04-01-2025 19:30", 
                pesanan: "Nasi Goreng", 
                status: "Tidak tersedia" 
            },
            { 
                no: 5, 
                nama: "Dewi", 
                jumlahOrang: 6, 
                tanggalWaktu: "05-01-2025 21:00", 
                pesanan: "Sosis Solo", 
                status: "Tersedia" 
            },
            { 
                no: 6, 
                nama: "Fajar", 
                jumlahOrang: 2, 
                tanggalWaktu: "06-01-2025 18:00", 
                pesanan: "Gulai Kambing", 
                status: "Tidak tersedia" 
            },
            { 
                no: 7, 
                nama: "Hana", 
                jumlahOrang: 4, 
                tanggalWaktu: "07-01-2025 19:00", 
                pesanan: "Sate Sapi", 
                status: "Tersedia" 
            },
            { 
                no: 8, 
                nama: "Irfan", 
                jumlahOrang: 3, 
                tanggalWaktu: "08-01-2025 20:30", 
                pesanan: "Sate Kambing", 
                status: "Tersedia" 
            },
            { 
                no: 9, 
                nama: "Lina", 
                jumlahOrang: 5, 
                tanggalWaktu: "09-01-2025 19:00", 
                pesanan: "Sate Sapi", 
                status: "Tidak tersedia" 
            },
            { 
                no: 10, 
                nama: "Mira", 
                jumlahOrang: 2, 
                tanggalWaktu: "10-01-2025 18:30", 
                pesanan: "Tengkleng", 
                status: "Tersedia" 
            }
        ],
        columns: [
            { data: "no" },
            { data: "nama" },
            { data: "jumlahOrang" },
            { data: "tanggalWaktu" },
            { data: "pesanan" },
            { data: "status" },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-outline-success edit-btn" data-id="${row.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                },
            }
        ],
        responsive: true,
        dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex gap-3"l><"ms-auto"f>>rt<"d-flex justify-content-between align-items-center"<"text-muted"i><"ms-auto"p>>',
        language: {
            lengthMenu: "Tampilkan _MENU_ entries",
            search: "Cari menu:",
            paginate: {
                next: "Next",
                previous: "Previous",
            },
        },
    });
});

    document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item a");
    const currentUrl = window.location.href;

    menuItems.forEach((menuItem) => {
      if (currentUrl.includes(menuItem.getAttribute("href"))) {
        menuItem.parentElement.classList.add("active-menu-item");
      } else {
        menuItem.parentElement.classList.remove("active-menu-item");
      }
    });
  });

  const ingredientColors = { 
    "daging ayam": "#FFF4E0", 
    "bumbu": "#FF8A65", 
    "adonan telur": "#FFD700",  
    "kedelai": "#D2A872" 
  };

function isColorDark(hex) {
    // Hapus tanda #
    hex = hex.replace("#", "");

    // Pisahkan warna menjadi RGB
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    // Hitung luminance (perceptual brightness)
    const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

    // Return true jika warna gelap
    return luminance < 0.5;
}


  document.addEventListener("DOMContentLoaded", function () {
    // Sample data
    let menuData = [
        {
            id: 1,
            image: "../img/side-dish/sosis-solo.webp",
            name: "Sosis Solo",
            price: 3000,
            calories: 120,
            ingredients: [
            { value: "Daging ayam" },
            { value: "bumbu" },
            { value: "adonan telur" },
        ],
            description: "Camilan khas Jawa Tengah yang menghadirkan cita rasa autentik Indonesia. Terbuat dari kulit dadar lembut yang membungkus isian daging ayam yang gurih.",
        },
        {
            id: 2,
            image: "../img/side-dish/tahu.jpg",
            name: "Tahu",
            price: 2500,
            calories: 100,
            ingredients: [
            { value: "Kedelai" },
        ],
            description: "Tahu Goreng kami dibuat dari tahu berkualitas tinggi. Renyah di luar, lembut di dalam.",
        },
        {
            id: 3,
            image: "../img/side-dish/tempe.jpg",
            name: "Tempe",
            price: 2500,
            calories: 100,
            ingredients: [
            { value: "Kedelai" },
        ],
            description: "Terbuat dari tempe pilihan yang digoreng hingga renyah dengan aroma khas yang menggugah selera.",
        },
    ];

    const input = document.querySelector('#menuIngredients');
  const tagify = new Tagify(input, {
    whitelist: ["Daging Ayam", "Bumbu", "Adonan Telur", "Kedelai"],
    dropdown: {
      maxItems: 10,           // jumlah maksimum saran dropdown
      classname: "suggestion-list", // nama kelas CSS untuk dropdown
      enabled: 0,              // akan muncul setelah mengetikkan minimal 0 karakter
      closeOnSelect: false     // tetap terbuka setelah memilih
    }
  });

    // Format currency
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
        }).format(amount);
    };
    // Fungsi untuk memformat angka dengan titik
    // Fungsi untuk memformat angka dengan titik
function formatPrice(input) {
    let cursorPosition = input.selectionStart; // Simpan posisi kursor
    let value = input.value.replace(/\./g, ''); // Hapus semua titik

    if (!isNaN(value)) {
        // Format ulang angka dengan titik
        const formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = formattedValue;

        // Kembalikan posisi kursor ke tempat yang sesuai
        const diff = formattedValue.length - value.length;
        input.setSelectionRange(cursorPosition + diff, cursorPosition + diff);
    }
}

// Tambahkan event listener pada input harga
const priceInputs = document.querySelectorAll("#editMenuPrice, #menuPrice");

priceInputs.forEach(input => {
    // Format angka hanya saat pengguna selesai mengetik (blur)
    input.addEventListener("blur", function () {
        formatPrice(this);
    });

    // Cegah karakter non-angka saat mengetik
    input.addEventListener("input", function () {
        this.value = this.value.replace(/[^\d]/g, '');
    });
});


// Menambahkan event listener pada input harga
document.getElementById("editMenuPrice").addEventListener("input", function() {
    formatPrice(this);
});
document.getElementById("menuPrice").addEventListener("input", function() {
    formatPrice(this);
});

    // Initialize DataTable
const table = $("#menuTable").DataTable({
    data: menuData,
    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
    return parseInt(meta.row, 10) + 1; // Paksa menjadi angka
},
            className: "text-center", // Tambahkan styling jika perlu
        },
            {
                data: "image",
                render: function (data, type, row) {
                    return `<img src="${data}" class="menu-image" alt="${row.name}">`;
                },
            },
            { data: "name" },
            {
                data: "price",
                render: function (data) {
                    return formatCurrency(data);
                },
            },
            { 
                data: null,
                render: function (data, type, row) {
                    return row.calories ? `${row.calories} kkal` : '-';
                }
            },
            {
    data: "ingredients",
    render: function (data, type, row) {
        if (typeof data === "string") {
            data = data.split(", ").map((item) => ({ value: item }));
        }

        if (Array.isArray(data)) {
            return data
                .map((ingredient) => {
                    const color = ingredientColors[ingredient.value.toLowerCase()] || "#9E9E9E"; // Warna default abu-abu
                    const textColor = isColorDark(color) ? "white" : "black"; // Tentukan warna teks
                    return `<span class="badge me-1" style="
                        background-color: ${color}; 
                        color: ${textColor}; 
                        font-size: 0.75rem; 
                        padding: 0.4em 0.6em; 
                        border-radius: 12px; 
                        margin-right: 0.5rem; 
                        margin-bottom: 0.5rem; 
                        display: inline-block;
                    ">
                        ${ingredient.value}
                    </span>`;
                })
                .join("");
        }

        return "-";
    },
},

            { 
                data: null,
                render: function (data, type, row) {
                    return row.description || '-';
                }
            },
        {
            data: null,
            render: function (data, type, row) {
                return `
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-success edit-btn" data-id="${row.id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            },
        }
    ],
    responsive: true,
    dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex gap-3"l><"ms-auto"f>>rt<"d-flex justify-content-between align-items-center"<"text-muted"i><"ms-auto"p>>',
    language: {
        lengthMenu: "Tampilkan _MENU_ entries",
        search: "Cari menu:",
        paginate: {
            next: "Next",
            previous: "Previous",
        },
    },
});


// Delegasi event untuk tombol edit
$('#menuTable').on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    editMenu(id);
});

// Delegasi event untuk tombol delete 
$('#menuTable').on('click', '.delete-btn', function () { 
    const id = $(this).data('id'); 
    deleteMenu(id); 
});

        // Sidebar toggle functionality
        const toggleSidebarBtn = document.getElementById("toggleSidebar");
        toggleSidebarBtn.addEventListener("click", () => {
          const sidebar = document.getElementById("sidebar");
          const content = document.getElementById("content");
          sidebar.classList.toggle("collapsed");
          content.classList.toggle("collapsed");
          table.columns.adjust().responsive.recalc();
        });

        // Save menu function
    window.saveMenu = () => {
        const form = document.getElementById("addMenuForm");
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Pastikan semua ID input sesuai dengan form
        const newMenu = {
          id: Date.now(), // ID unik
            image: URL.createObjectURL(
                document.getElementById("menuImage").files[0]
            ),
            name: document.getElementById("menuName").value,
            price: parseFloat(document.getElementById("menuPrice").value.replace(/\./g, "")) || 0,            // Ubah dari menuPrice ke editMenuPrice
            calories: parseInt(document.getElementById("menuCalories").value), // Ubah dari menuCalories ke editMenuCalories
            ingredients: JSON.parse(document.getElementById("menuIngredients").value), // Parse JSON dari Tagify
            description: document.getElementById("menuDescription").value,
        };

  menuData.push(newMenu);
  table.clear().rows.add(menuData).draw(); // Perbarui tabel

  // Tutup modal Bootstrap
  bootstrap.Modal.getInstance(document.getElementById("addMenuModal")).hide();
    form.reset();
    document.getElementById("imagePreview").innerHTML = "";

  // Tambahkan SweetAlert
  Swal.fire({
    icon: 'success',
    title: 'Menu Berhasil Ditambahkan!',
    text: `Menu ${newMenu.name} telah ditambahkan ke daftar.`,
    confirmButtonText: "OK"
  });

  // Reset form
  form.reset();
  document.getElementById("imagePreview").innerHTML = "";
};

// Edit menu function
window.editMenu = (id) => {
    const menu = menuData.find((item) => item.id === id);
    if (menu) {
        document.getElementById("editMenuId").value = menu.id;
        document.getElementById("editMenuName").value = menu.name || "";
        document.getElementById("editMenuPrice").value = menu.price || "";
        document.getElementById("editMenuCalories").value = menu.calories || "";
        document.getElementById("editMenuDescription").value = menu.description || "";

        // Inisialisasi Tagify untuk edit menu
        const editIngredientsInput = document.getElementById("editMenuIngredients");
        const tagifyEdit = new Tagify(editIngredientsInput, {
            whitelist: ["Daging Ayam", "Bumbu", "Adonan Telur", "Kedelai"],
            dropdown: {
                maxItems: 10,
                classname: "suggestion-list",
                enabled: 0, // Tidak langsung terbuka
                closeOnSelect: false,
            },
        });

        // Bersihkan tag sebelumnya dan tambahkan tag sesuai data menu
        tagifyEdit.removeAllTags();
        tagifyEdit.addTags(menu.ingredients.map((i) => i.value));

        // Gambar preview
        const editImagePreview = document.getElementById("editImagePreview");
        editImagePreview.innerHTML = menu.image
            ? `<img src="${menu.image}" alt="Preview" style="max-width: 200px; max-height: 200px;">`
            : "<p>No image available</p>";

        // Tampilkan modal edit
        $('#editMenuModal').modal('show');
    } else {
        console.error(`Menu with ID ${id} not found`);
    }
};

// Tambahkan fungsi untuk menghapus backdrop yang tersisa
function removeBackdrops() {
    document.querySelectorAll('.modal-backdrop').forEach((backdrop) => {
        backdrop.remove();
    });
}

// Tambahkan event listener untuk modal edit
document.getElementById("editMenuModal").addEventListener("hidden.bs.modal", () => {
    removeBackdrops(); // Hapus backdrop ketika modal ditutup
});

// Update menu function
window.updateMenu = () => {
    const form = document.getElementById("editMenuForm");
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const id = parseInt(document.getElementById("editMenuId").value);
    const index = menuData.findIndex((item) => item.id === id);

    if (index !== -1) {
        const imageFile = document.getElementById("editMenuImage").files[0];
        const editIngredientsInput = document.getElementById("editMenuIngredients");
        const tagifyEdit = new Tagify(editIngredientsInput);

        const updatedMenu = {
            id: id,
            name: document.getElementById("editMenuName").value || "",
            price: parseFloat(document.getElementById("editMenuPrice").value.replace(/\./g, "")) || 0,
            calories: parseInt(document.getElementById("editMenuCalories").value) || 0,
            ingredients: tagifyEdit.value, // Ambil nilai Tagify
            description: document.getElementById("editMenuDescription").value || "",
            image: imageFile ? URL.createObjectURL(imageFile) : menuData[index].image,
        };

        menuData[index] = updatedMenu;

        // Update DataTable
        table.row((idx, data) => data.id === id).data(updatedMenu).draw();

        // Tutup modal dan reset form
        bootstrap.Modal.getInstance(document.getElementById("editMenuModal")).hide();
        form.reset();
        document.getElementById("editImagePreview").innerHTML = "";

        // Notifikasi berhasil
        Swal.fire({
            icon: "success",
            title: "Menu Berhasil Diperbarui",
            text: `Menu ${updatedMenu.name} berhasil diperbarui`,
            confirmButtonText: "OK",
        });
    } else {
        console.error(`Menu with ID ${id} not found`);
    }
};

        // Delete menu function
window.deleteMenu = (id) => {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Menu ini akan terhapus secara permanen. Anda tidak akan bisa mengembalikan aksi ini.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            menuData = menuData.filter((item) => item.id !== id);
            table.clear().rows.add(menuData).draw(); // Perbarui tabel

            Swal.fire(
                "Terhapus!",
                "Menus berhasil terhapus!",
                "success"
            );
        }
    });
};

        // Initialize event listeners for modal buttons
        document.getElementById("saveMenu").addEventListener("click", saveMenu);
        document
          .getElementById("updateMenu")
          .addEventListener("click", updateMenu);

        // Image preview handlers
        document.getElementById("menuImage").addEventListener("change", (e) => {
          const preview = document.getElementById("imagePreview");
          const file = e.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
              preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
          }
        });

        document
          .getElementById("editMenuImage")
          .addEventListener("change", (e) => {
            const preview = document.getElementById("editImagePreview");
            const file = e.target.files[0];
            if (file) {
              const reader = new FileReader();
              reader.onload = (e) => {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
              };
              reader.readAsDataURL(file);
            }
          });
      });

      document.addEventListener("DOMContentLoaded", () => {
        const editButton = document.getElementById("editButton");
        const saveButton = document.getElementById("saveButton");
        const editPictureButton = document.getElementById("editPictureButton");
        const profilePictureInput = document.getElementById(
          "profilePictureInput"
        );
        const profilePicturePreview = document.getElementById(
          "profilePicturePreview"
        );
        const formFields = document.querySelectorAll(
          "#profileForm input, #profileForm select"
        );

        // Enable Editing
        editButton.addEventListener("click", () => {
          formFields.forEach((field) => field.removeAttribute("disabled"));
          editButton.style.display = "none";
          saveButton.style.display = "inline-block";
          editPictureButton.style.display = "inline-block"; // Show Change Picture button
        });

        // Save Changes
        saveButton.addEventListener("click", () => {
          formFields.forEach((field) => field.setAttribute("disabled", "true"));
          editButton.style.display = "inline-block";
          saveButton.style.display = "none";
          editPictureButton.style.display = "none"; // Hide Change Picture button

          // SweetAlert2 Confirmation
          Swal.fire({
            icon: "success",
            title: "Profil Diperbarui",
            text: "Profil Anda telah sukses diperbarui.",
            confirmButtonText: "OK",
          });
        });

        // Change Profile Picture
        editPictureButton.addEventListener("click", () => {
          profilePictureInput.click();
        });

        profilePictureInput.addEventListener("change", () => {
          const file = profilePictureInput.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
              profilePicturePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
        });
      });

          </script>
  </body>
</html>
