<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Side Dish</title>
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
          ><i class="bi bi-house-door me-2"></i> <span>Dashboard</span></a>
      </div>
       <div class="menu-item">
        <a href="report.html"
          ><i class="bi bi-bar-chart-line me-2"></i> <span>Report</span></a
        >
      </div>
      <div class="menu-item">
        <a href="mainCourse.html"
          ><i class="bi bi-egg-fried me-2"></i> <span>Main Course</span></a>
      </div>
      <div class="menu-item">
        <a href="drinks.html"
          ><i class="bi bi-cup me-2"></i> <span>Drinks</span></a>
      </div>
      <div class="menu-item">
        <a href="sideDish.html"
          ><i class="bi bi-egg me-2"></i></i> <span>Side Dish</span></a>
      </div>
      <div class="menu-item">
        <a href="package.html"
          ><i class="bi bi-basket3 me-2"></i></i> <span>Paket</span></a>
      </div>
      <div class="menu-item">
        <a href="order.html"
          ><i class="bi bi-cart3 me-2"></i> <span>Pesanan</span></a>
      </div>
      <div class="menu-item">
        <a href="reservation.html"
          ><i class="bi bi-calendar2-check me-2"></i> <span>Reservasi</span></a>
      </div>
      <div class="menu-item">
        <a href="users.html"
          ><i class="bi bi-person me-2"></i> <span>Users</span></a
        >
      </div>
      <div class="menu-item">
        <a href="notification.html"
          ><i class="bi bi-bell me-2"></i> <span>Notifikasi</span></a
        >
      </div>
<div class="menu-item dropdown" id="dropdownMenu">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-briefcase me-2"></i> <span>Karir</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-start">
        <li>
            <a class="dropdown-item" href="jobs.html">
                <i class="bi bi-person-badge me-2"></i>Lowongan
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="applicant.html">
                <i class="bi bi-person-badge me-2"></i>Pelamar
            </a>
        </li>
    </ul>
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
          <a class="navbar-brand" href="#">Side Dish</a>
          <div class="d-flex align-items-center ms-auto">
            <!-- Notification -->
<div class="dropdown me-3">
  <button
    class="btn btn-light position-relative rounded-circle shadow-sm"
    type="button"
    id="notificationDropdown"
    data-bs-toggle="dropdown"
    aria-expanded="false"
    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;"
  >
    <div class="position-relative">
      <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
      <span
        class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger"
        style="font-size: 0.65rem; width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; transform: translate(-80%, -20%);"
      >
        3
      </span>
    </div>
  </button>
  <ul
    class="dropdown-menu dropdown-menu-end shadow rounded-3 border-0"
    aria-labelledby="notificationDropdown"
    style="width: 300px;"
  >
    <li><h6 class="dropdown-header text-primary">Notifikasi</h6></li>
    <li>
      <a class="dropdown-item d-flex align-items-center" href="#">
        <i class="bi bi-cart-check me-3 text-success" style="font-size: 1.2rem;"></i>
        <span>Pesanan baru diterima</span>
      </a>
    </li>
    <li>
      <a class="dropdown-item d-flex align-items-center" href="#">
        <i class="bi bi-basket me-3 text-warning" style="font-size: 1.2rem;"></i>
        <span>Stok bahan hampir habis</span>
      </a>
    </li>
    <li>
      <a class="dropdown-item d-flex align-items-center" href="#">
        <i class="bi bi-people me-3 text-info" style="font-size: 1.2rem;"></i>
        <span>Reservasi meja baru</span>
      </a>
    </li>
    <li><hr class="dropdown-divider" /></li>
    <li>
      <a class="dropdown-item text-center text-primary fw-bold" href="#">Lihat semua</a>
    </li>
  </ul>
</div>

          
          
          <div class="dropdown ms-auto">
            <button
              class="profile-button rounded"
              type="button"
              id="profileDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <img
                src="../img/profile-pic.png"
                alt="Profile"
                class="rounded-circle"/>
              <div class="text-start">
                <strong>Diki Alif</strong><br />
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
        <button
        class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#addMenuModal">
        <i class="bi bi-plus-circle me-2"></i>Tambah Menu
      </button><br><hr>
      <div class="table-container">
        <table
          id="menuTable"
          class="table table-hover display responsive nowrap"
          style="width: 100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Gambar</th>
              <th>Nama Menu</th>
              <th>Harga</th>
              <th>Kalori</th>
              <th>Bahan Utama</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    
       <!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
          <i class="bi bi-plus-circle me-2"></i> Tambah Menu Baru
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addMenuForm">
          <div class="row">
            <!-- Kolom Gambar -->
            <div class="col-md-4 text-center">
              <label class="form-label fw-bold">Gambar Menu</label>
              <div class="mb-3">
                <input
                  type="file"
                  class="form-control"
                  id="menuImage"
                  accept="image/*"
                  required
                />
              </div>
              <div id="imagePreview" class="border p-2 rounded">
                <!-- Placeholder untuk gambar -->
                <img
                  src="https://via.placeholder.com/150"
                  alt="Image Preview"
                  class="img-fluid rounded"
                />
              </div>
            </div>
            <!-- Kolom Informasi -->
            <div class="col-md-8">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Nama Menu</label>
                    <input
                      type="text"
                      class="form-control"
                      id="menuName"
                      placeholder="Masukkan Nama Menu"
                      required
                    />
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">Harga (Rp)</label>
                      <input
                        type="number"
                        step="0.001"
                        class="form-control"
                        id="menuPrice"
                        placeholder="Masukkan Harga"
                        required
                        min="0"
                      />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">Kalori (kkal)</label>
                      <input
                        type="number"
                        class="form-control"
                        id="menuCalories"
                        placeholder="Masukkan Kalori"
                        required
                        min="0"
                      />
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Bahan Utama</label>
                    <input
                      class="form-control"
                      id="menuIngredients"
                      placeholder="Masukkan Bahan Utama"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea
                      class="form-control"
                      id="menuDescription"
                      placeholder="Masukkan Deskripsi"
                      rows="3"
                      required
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle"></i> Batal
        </button>
        <button type="button" class="btn btn-success" id="saveMenu">
          <i class="bi bi-check-circle"></i> Simpan
        </button>
      </div>
    </div>
  </div>
</div>

     <!-- Show Menu Modal -->
<div class="modal fade" id="showMenuModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">
          <i class="bi bi-card-list me-2"></i> Detail Menu
        </h5>
        <button
          type="button"
          class="btn-close btn-close-white"
          data-bs-dismiss="modal"
        ></button>
      </div>
      <div class="modal-body">
        <form id="showMenuForm">
          <input type="hidden" id="showMenuId" />
          <div class="row">
            <div class="col-md-4 text-center">
              <label class="form-label fw-bold">Gambar Menu</label>
              <div id="showImagePreview" class="border p-2 rounded">
                <!-- Contoh gambar placeholder -->
                <img
                  src="https://via.placeholder.com/150"
                  alt="Menu Image"
                  class="img-fluid rounded"
                />
              </div>
            </div>
            <div class="col-md-8">
              <div class="card shadow-sm border-0">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Nama Menu</label>
                    <input
                      type="text"
                      class="form-control"
                      id="showMenuName"
                      disabled
                    />
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">Harga (Rp)</label>
                      <input
                        type="number"
                        class="form-control"
                        id="showMenuPrice"
                        disabled
                      />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold">Kalori (kkal)</label>
                      <input
                        type="number"
                        class="form-control"
                        id="showMenuCalories"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Bahan Utama</label>
                    <input
                      id="showMenuIngredients"
                      class="form-control"
                      disabled
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea
                      class="form-control"
                      id="showMenuDescription"
                      rows="3"
                      disabled
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button
          type="button"
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >
          <i class="bi bi-x-circle"></i> Tutup
        </button>
        <button
          type="button"
          class="btn btn-warning"
          data-bs-dismiss="modal"
        >
          <i class="bi bi-check-circle"></i> Selesai
        </button>
      </div>
    </div>
  </div>
</div>


    <!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="bi bi-pencil-square me-2"></i> Edit Menu
        </h5>
        <button
          type="button"
          class="btn-close btn-close-white"
          data-bs-dismiss="modal"
        ></button>
      </div>
      <div class="modal-body">
        <form id="editMenuForm">
          <input type="hidden" id="editMenuId" />
          <div class="row">
            <!-- Kolom Gambar Menu -->
            <div class="col-md-4 text-center">
              <label class="form-label fw-bold">Gambar Menu</label>
              <input
                type="file"
                class="form-control mb-2"
                id="editMenuImage"
                accept="image/*"
              />
              <div id="editImagePreview" class="border p-2 rounded">
                <!-- Placeholder gambar -->
                <img
                  src="https://via.placeholder.com/150"
                  alt="Preview Image"
                  class="img-fluid rounded"
                />
              </div>
            </div>
            <!-- Kolom Detail Menu -->
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label class="form-label fw-bold">Nama Menu</label>
                  <input
                    type="text"
                    class="form-control"
                    id="editMenuName"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Harga (Rp)</label>
                  <input
                    type="number"
                    step="0.001"
                    class="form-control"
                    id="editMenuPrice"
                    required
                    min="0"
                  />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Kalori (kkal)</label>
                  <input
                    type="number"
                    class="form-control"
                    id="editMenuCalories"
                    required
                    min="0"
                  />
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label fw-bold">Bahan Utama</label>
                  <input
                    type="text"
                    class="form-control"
                    id="editMenuIngredients"
                    required
                  />
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label fw-bold">Deskripsi</label>
                  <textarea
                    class="form-control"
                    id="editMenuDescription"
                    rows="3"
                    required
                  ></textarea>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button
          type="button"
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >
          <i class="bi bi-x-circle"></i> Batal
        </button>
        <button
          type="button"
          class="btn btn-primary"
          id="updateMenu"
        >
          <i class="bi bi-floppy"></i> Perbarui
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
    </div>
    </div>
    <!-- Footer -->
<footer class="footer-custom text-center">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <p class="mb-0">
          © 2024 BOLOOO: All Rights Reserved
        </p>
      </div>
    </div>
  </div>
</footer>
      
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
    "kedelai": "#D2A872",
    "tepung terigu": "#F5E8C8",
    "garam": "#FFFFFF",
    "bawang putih": "#F7F3E9"
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
        {
            id: 4,
            image: "../img/side-dish/krupuk.jpeg",
            name: "Kerupuk",
            price: 1000,
            calories: 60,
            ingredients: [
            { value: "Tepung terigu" },
            { value: "garam" },
            { value: "bawang putih" },
            { value: "bumbu" },
        ],
            description: "Camilan renyah khas Indonesia yang sering menjadi pelengkap makanan utama atau dinikmati sebagai camilan.",
        },
    ];

    const input = document.querySelector('#menuIngredients');
  const tagify = new Tagify(input, {
    whitelist: ["Daging Ayam", "Bumbu", "Adonan Telur", "Kedelai", "Tepung Terigu", "Garam", "Bawang putih"],
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
                      <button class="btn btn-sm btn-outline-warning show-btn" data-id="${row.id}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary edit-btn" data-id="${row.id}">
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

// Fungsi untuk membuka modal Show Menu
function showMenu(id) {
  const menu = menuData.find((item) => item.id === id);
  if (menu) {
    // Isi data ke dalam modal
    document.getElementById("showMenuId").value = menu.id || "";
    document.getElementById("showMenuName").value = menu.name || "";
    document.getElementById("showMenuPrice").value = menu.price || "";
    document.getElementById("showMenuCalories").value = menu.calories || "";
    document.getElementById("showMenuDescription").value = menu.description || "";

    // Inisialisasi Tagify untuk ingredients pada modal show
    const showIngredientsInput = document.getElementById("showMenuIngredients");
    
    // Hapus instance Tagify sebelumnya jika ada
    if (showIngredientsInput.tagify) {
      showIngredientsInput.tagify.destroy();
    }

    const tagifyShow = new Tagify(showIngredientsInput, {
      whitelist: ["Daging Ayam", "Daging Kambing", "Daging Sapi", "Nasi", "Bumbu Kacang", "Kecap", "Lada Bubuk", "Santan", "Rempah", "Cabai", "Bawang", "Sayuran", "Jeroan"],
      dropdown: {
        maxItems: 10,
        classname: "suggestion-list",
        enabled: 0,
        closeOnSelect: false
      },
      // Jadikan read-only
      readOnly: true
    });

    // Bersihkan tag sebelumnya dan tambahkan tag sesuai data menu
    tagifyShow.removeAllTags();
    
    // Pastikan menu.ingredients adalah array yang valid
    if (Array.isArray(menu.ingredients)) {
      tagifyShow.addTags(menu.ingredients);
    } else if (typeof menu.ingredients === 'string') {
      // Jika ingredients adalah string, pisahkan dengan koma
      tagifyShow.addTags(menu.ingredients.split(',').map(i => i.trim()));
    }

    const imagePreview = document.getElementById("showImagePreview");
    imagePreview.innerHTML = menu.image
      ? `<img src="${menu.image}" alt="${menu.name}" class="img-fluid" style="max-width: 200px;">`
      : "<p>Tidak ada gambar tersedia</p>";

    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById("showMenuModal"));
    modal.show();
  } else {
    console.error(`Menu dengan ID ${id} tidak ditemukan.`);
  }
}

// Contoh event listener untuk tombol Show
document.querySelectorAll(".show-btn").forEach((button) => {
  button.addEventListener("click", (e) => {
    const id = parseInt(e.target.closest("button").dataset.id);
    showMenu(id);
  });
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
            whitelist: ["Daging Ayam", "Bumbu", "Adonan Telur", "Kedelai", "Tepung Terigu", "Garam", "Bawang putih"],
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
