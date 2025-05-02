<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pelamar</title>
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
    <div class="d-flex align-items-center justify-content-between d-md-none p-2">
      <!-- Logo dan Judul Website -->
      <div class="d-flex align-items-center">
        <img src="../img/logo/logo-alt.png" alt="Logo" style="width: 40px; height: 40px;" />
        <span class="ms-2 fw-bold">BOLOOO</span>
      </div>
      <!-- Tombol Toggle -->
      <button class="btn btn-outline-light" id="toggleSidebarMobile">
        <i class="bi bi-list"></i>
      </button>
    </div>

    <div class="logo-container d-none d-md-flex">
      <img src="../img/logo/logo-alt.png" alt="Logo" />
      <span>BOLOOO</span>
    </div>

    <div class="menu-item">
      <a href="dashboard.html"><i class="bi bi-house-door me-2"></i> <span>Dashboard</span></a>
    </div>
    <div class="menu-item">
      <a href="report.html"><i class="bi bi-bar-chart-line me-2"></i> <span>Report</span></a>
    </div>
    <div class="menu-item">
      <a href="mainCourse.html"><i class="bi bi-egg-fried me-2"></i> <span>Main Course</span></a>
    </div>
    <div class="menu-item">
      <a href="drinks.html"><i class="bi bi-cup me-2"></i> <span>Drinks</span></a>
    </div>
    <div class="menu-item">
      <a href="sideDish.html"><i class="bi bi-egg me-2"></i> <span>Side Dish</span></a>
    </div>
    <div class="menu-item">
      <a href="package.html"><i class="bi bi-basket3 me-2"></i> <span>Paket</span></a>
    </div>
    <div class="menu-item">
      <a href="order.html"><i class="bi bi-cart3 me-2"></i> <span>Pesanan</span></a>
    </div>
    <div class="menu-item">
      <a href="reservation.html"><i class="bi bi-calendar2-check me-2"></i> <span>Reservasi</span></a>
    </div>
    <div class="menu-item">
      <a href="users.html"><i class="bi bi-person me-2"></i> <span>Users</span></a>
    </div>
    <div class="menu-item dropdown active-menu-item" id="dropdownMenu">
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
          <a class="dropdown-item active-dropdown-item" href="applicant.html">
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

      <!-- Tombol toggle sidebar untuk desktop -->
        <button id="toggleSidebar" class="btn btn-outline-secondary me-3 d-none d-md-inline">
          <i class="bi bi-list"></i>
        </button>
          <a class="navbar-brand" href="#">Pelamar</a>
    <div class="d-flex align-items-center ms-auto">

          <div class="dropdown ms-auto">
            <button
              class="profile-button rounded"
              type="button"
              id="profileDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <img
                src="../img/profile-pic-ray.jpg"
                alt="Profile"
                class="rounded-circle"/>
              <div class="text-start">
                <strong>Raynaldi Paniroean</strong><br />
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
                        src="../img/profile-pic-ray.jpg"
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
                            value="Raynaldi Paniroean"
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
                            value="rnldss"
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
                              value="raynaldipaniroean@gmail.com"
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
                <th>Nama Lengkap</th>
                <th>KTP</th>
                <th>Ijazah</th>
                <th>CV</th>
                <th>Status Pelamar</th>
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
                <h5 class="modal-title">Edit Data</h5>
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
                    <label class="form-label">File CV</label>
                    <input
                      type="file"
                      class="form-control"
                      id="editMenuImage"
                      accept="image/*"
                    />
                    <div id="editImagePreview"></div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Nama Pelamar</label>
                    <input
                      type="text"
                      class="form-control"
                      id="editMenuName"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Ijazah
                    </label>
                    <input
                      type="number" step="0.001"
                      class="form-control"
                      id="editMenuPrice"
                      required
                      min="0"
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">No. KTP</label>
                    <input
                      type="number"
                      class="form-control"
                      id="editMenuCalories"
                      required
                      min="0"
                    />
                  </div>
                  <div class="mb-3">            
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
      // Sample data
      let pelamarData = [
        {
          id: 1,
          namaLengkap: "Andi Wijaya",
          ktp: "1234567890123456",
          ijazah: "S1 Teknik Informatika",
          cv: "Andi Wijaya CV.pdf",
          statusPelamar: "Diterima"
        },
        {
          id: 2,
          namaLengkap: "Siti Nurhaliza",
          ktp: "9876543210987654",
          ijazah: "D3 Akuntansi",
          cv: "Siti Nurhaliza CV.pdf",
          statusPelamar: "Ditolak"
        },
        {
          id: 3,
          namaLengkap: "Budi Santoso",
          ktp: "1234567890123456",
          ijazah: "S2 Manajemen",
          cv: "Budi Santoso CV.pdf",
          statusPelamar: "Diterima"
        },
        {
          id: 4,
          namaLengkap: "Rina Dewi",
          ktp: "6543210987654321",
          ijazah: "S1 Psikologi",
          cv: "Rina Dewi CV.pdf",
          statusPelamar: "Diterima"
        },
        {
          id: 6,
          namaLengkap: "Dewi Lestari",
          ktp: "9988776655443322",
          ijazah: "S1 Ekonomi",
          cv: "Dewi Lestari CV.pdf",
          statusPelamar: "Diterima"
        },
        {
          id: 7,
          namaLengkap: "Fani Anggraeni",
          ktp: "3344556677889900",
          ijazah: "S1 Kedokteran",
          cv: "Fani Anggraeni CV.pdf",
          statusPelamar: "Diterima"
        },

      ];

      // Initialize DataTable with dummy data
      const table = $("#menuTable").DataTable({
        data: pelamarData,
        columns: [
          { data: "id" },
          { data: "namaLengkap" },
          { data: "ktp" },
          { data: "ijazah" },
          { data: "cv" },
          { data: "statusPelamar" },
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
          search: "Cari menu: ",
          paginate: {
            next: "Next",
            previous: "Previous",
          },
        },
      });

      // Event listeners for edit and delete buttons
      $('#menuTable').on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        editMenu(id);
      });

      $('#menuTable').on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        deleteMenu(id);
      });

      // Function to edit menu
      function editMenu(id) {
        const menu = pelamarData.find(item => item.id === id);
        if (menu) {
          // Populate the edit form with menu data
          document.getElementById("editMenuId").value = menu.id;
          document.getElementById("editMenuName").value = menu.namaLengkap;
          document.getElementById("editMenuPrice").value = menu.ijazah;
          document.getElementById("editMenuCalories").value = menu.ktp;
          document.getElementById("editMenuDescription").value = menu.cv;
          $('#editMenuModal').modal('show');
        }
      }

      // Function to delete menu
      function deleteMenu(id) {
        pelamarData = pelamarData.filter(item => item.id !== id);
        table.clear().rows.add(pelamarData).draw();
      }

      // Event listeners for modal buttons
      document.getElementById("saveMenu").addEventListener("click", saveMenu);
      document.getElementById("updateMenu").addEventListener("click", updateMenu);

      // Save menu function
      function saveMenu() {
        const newMenu = {
          id: pelamarData.length + 1,
          namaLengkap: document.getElementById("menuName").value,
          ktp: document.getElementById("menuPrice").value,
          ijazah: document.getElementById("menuCalories").value,
          cv: document.getElementById("menuDescription").value,
          statusPelamar: "Diterima"
        };
        pelamarData.push(newMenu);
        table.clear().rows.add(pelamarData).draw();
        $('#addMenuModal').modal('hide');
      }

      // Update menu function
      function updateMenu() {
        const id = parseInt(document.getElementById("editMenuId").value);
        const index = pelamarData.findIndex(item => item.id === id);
        if (index !== -1) {
          pelamarData[index].namaLengkap = document.getElementById("editMenuName").value;
          pelamarData[index].ktp = document.getElementById("editMenuPrice").value;
          pelamarData[index].ijazah = document.getElementById("editMenuCalories").value;
          pelamarData[index].cv = document.getElementById("editMenuDescription").value;
          table.clear().rows.add(pelamarData).draw();
          $('#editMenuModal').modal('hide');
        }
      }
    </script>
  </body>
</html>