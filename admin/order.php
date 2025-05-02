<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pesanan</title>
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
    <style>
      .btn-status {
      font-size: 0.875rem;
      padding: 0.25rem 0.5rem;
      transition: all 0.3s;
    }
    .btn-status:hover {
      border: 2px solid;
      background-color: transparent;
    }

    .btn-small {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        transition: all 0.3s;
      }

      .btn-outline {
        border: 1px solid #ddd;
      }

      .btn-small:hover {
        background-color: transparent;
        border: 2px solid;
      }


      .btn-status-pending {
        background-color: #ffc107;
        border-color: #ffc107;
        color: white;
      }

      .btn-status-completed {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
      }

      .btn-status-canceled {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
      }

      .btn-payment-paid {
        background-color: #4caf50;
        border-color: #4caf50;
        color: white;
      }

      .btn-payment-unpaid {
        background-color: #f44336;
        border-color: #f44336;
        color: white;
      }

      #showModal .modal-header {
        background-color: #ffc107;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
      }

      #editModal .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
      }

      #showModal .modal-body,
      #editModal .modal-body {
        max-height: 75vh;
        overflow-y: auto;
      }

      .modal-dialog {
        max-width: 800px;
      }

      .modal-header {
        background: linear-gradient(45deg, #6a11cb, #2575fc);
        color: white;
      }

      .modal-footer {
        border-top: 1px solid #ddd;
      }

      .form-label {
        font-weight: bold;
      }
    </style>
    </style>
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
          <a class="navbar-brand" href="#">Pesanan</a>
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
       
      <div class="container mt-4">
      <table id="orderTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Pemesan</th>
            <th>Pesanan</th>
            <th>Jumlah</th>
            <th>Total Bayar</th>
            <th>Status Pesanan</th>
            <th>Status Pembayaran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data akan diisi menggunakan JavaScript -->
        </tbody>
      </table>
    </div>

     <!-- Modal Show -->
    <div class="modal fade" id="showModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detail Pesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nama Pelanggan</label>
                  <input type="text" id="showCustomerName" class="form-control" disabled />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email</label>
                  <input type="text" id="showCustomerEmail" class="form-control" disabled />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nomor Telepon</label>
                  <input type="text" id="showCustomerPhone" class="form-control" disabled />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Pesanan</label>
                  <input type="text" id="showOrder" class="form-control" disabled />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Jumlah</label>
                  <input type="text" id="showQuantity" class="form-control" disabled />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Total Bayar</label>
                  <input type="text" id="showTotal" class="form-control" disabled />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Status Pesanan</label>
                  <input type="text" id="showOrderStatus" class="form-control" disabled />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Status Pembayaran</label>
                  <input type="text" id="showPaymentStatus" class="form-control" disabled />
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Pesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="editForm">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nama Pelanggan</label>
                  <input type="text" id="editCustomerName" class="form-control" disabled />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Pesanan</label>
                  <input type="text" id="editOrder" class="form-control" disabled />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Jumlah</label>
                  <input type="text" id="editQuantity" class="form-control" disabled />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Total Bayar</label>
                  <input type="text" id="editTotal" class="form-control" disabled />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Status Pesanan</label>
                  <select id="editOrderStatus" class="form-select">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Canceled">Canceled</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Status Pembayaran</label>
                  <select id="editPaymentStatus" class="form-select">
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                  </select>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="saveChanges">Simpan Perubahan</button>
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
$(document).ready(function () {
  // Data awal pesanan
  let orders = [
    {
      id: 1,
      name: "Budi",
      email: "budi@example.com",
      phone: "081234567890",
      order: "Nasi Goreng",
      quantity: 2,
      total: "Rp20.000",
      orderStatus: "Pending",
      paymentStatus: "Unpaid",
    },
    {
      id: 2,
      name: "Siti",
      email: "siti@example.com",
      phone: "081987654321",
      order: "Sate Ayam",
      quantity: 1,
      total: "Rp15.000",
      orderStatus: "Completed",
      paymentStatus: "Paid",
    },
    {
      id: 3,
      name: "Andi",
      email: "andi@example.com",
      phone: "081987654321",
      order: "Sate Ayam",
      quantity: 1,
      total: "Rp15.000",
      orderStatus: "Completed",
      paymentStatus: "Paid",
    },
    {
      id: 4,
      name: "Asep",
      email: "asep@example.com",
      phone: "081987654321",
      order: "Sate Ayam",
      quantity: 1,
      total: "Rp15.000",
      orderStatus: "Completed",
      paymentStatus: "Paid",
    },
    {
      id: 5,
      name: "Ujang",
      email: "ujang@example.com",
      phone: "081987654321",
      order: "Sate Ayam",
      quantity: 1,
      total: "Rp15.000",
      orderStatus: "Completed",
      paymentStatus: "Paid",
    },
    {
      id: 6,
      name: "Dadang",
      email: "dadang@example.com",
      phone: "081987654321",
      order: "Sate Ayam",
      quantity: 1,
      total: "Rp15.000",
      orderStatus: "Completed",
      paymentStatus: "Paid",
    },
    {
      id: 7,
      name: "Tatang",
      email: "tatang@example.com",
      phone: "081987654321",
      order: "Sate Ayam",
      quantity: 1,
      total: "Rp15.000",
      orderStatus: "Completed",
      paymentStatus: "Paid",
    },
    {
      id: 8,
      name: "Jajang",
      email: "jajang@example.com",
      phone: "081987654321",
      order: "Sate Ayam",
      quantity: 1,
      total: "Rp15.000",
      orderStatus: "Completed",
      paymentStatus: "Paid",
    },
  ];

  // Inisialisasi DataTable
  const table = $("#orderTable").DataTable({
    data: orders,
    columns: [
      { data: null, render: (data, type, row, meta) => meta.row + 1 },
      { data: "name" },
      { data: "order" },
      { data: "quantity" },
      { data: "total" },
      { data: "orderStatus" },
      { data: "paymentStatus" },
      {
        data: null,
        render: (data) => `
          <button class='btn btn-sm btn-outline-warning show-btn' data-id='${data.id}'>
            <i class="bi bi-eye"></i>
          </button>
          <button class='btn btn-sm btn-outline-primary edit-btn' data-id='${data.id}'>
            <i class="bi bi-pencil"></i>
          </button>
          <button class='btn btn-sm btn-outline-danger delete-btn' data-id='${data.id}'>
            <i class="bi bi-trash"></i>
          </button>`,
      },
    ],
  });

  // Fungsi untuk menampilkan modal detail pesanan (show)
  $("#orderTable").on("click", ".show-btn", function () {
    const id = $(this).data("id");
    const order = orders.find((o) => o.id === id);
    if (order) {
      $("#showCustomerName").val(order.name);
      $("#showCustomerEmail").val(order.email);
      $("#showCustomerPhone").val(order.phone);
      $("#showOrder").val(order.order);
      $("#showQuantity").val(order.quantity);
      $("#showTotal").val(order.total);
      $("#showOrderStatus").val(order.orderStatus);
      $("#showPaymentStatus").val(order.paymentStatus);
      $("#showModal").modal("show");
    }
  });

  // Fungsi untuk mengedit data pesanan
  $("#orderTable").on("click", ".edit-btn", function () {
    const id = $(this).data("id");
    const order = orders.find((o) => o.id === id);
    if (order) {
      $("#editCustomerName").val(order.name).data("id", order.id);
      $("#editOrder").val(order.order);
      $("#editQuantity").val(order.quantity);
      $("#editTotal").val(order.total);
      $("#editOrderStatus").val(order.orderStatus);
      $("#editPaymentStatus").val(order.paymentStatus);
      $("#editModal").modal("show");
    }
  });

  // Simpan perubahan setelah edit
  $("#saveChanges").on("click", function () {
    const id = $("#editCustomerName").data("id");
    const order = orders.find((o) => o.id === id);

    if (order) {
      order.orderStatus = $("#editOrderStatus").val();
      order.paymentStatus = $("#editPaymentStatus").val();

      // Update tabel
      table.clear().rows.add(orders).draw();
      $("#editModal").modal("hide");

      Swal.fire({
        icon: "success",
        title: "Berhasil!",
        text: "Perubahan telah disimpan.",
        confirmButtonText: "OK",
      });
    }
  });

  // Fungsi untuk menghapus data pesanan
  $("#orderTable").on("click", ".delete-btn", function () {
    const id = $(this).data("id");
    const index = orders.findIndex((o) => o.id === id);

    if (index !== -1) {
      Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          orders.splice(index, 1);
          table.clear().rows.add(orders).draw();

          Swal.fire("Dihapus!", "Data berhasil dihapus.", "success");
        }
      });
    }
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
    "air": "#87CEEB", 
    "es batu": "#B0C4DE", 
    "gula": "#E65100", 
    "gula pasir": "#FFF8E1",
    "jeruk peras": "#FF8C00", 
    "teh": "#6B4226",
    "susu kental manis": "#F0E68C",
    "sirup": "#FF4C4C",
    "mangga": "#F5A623",
    "alpukat": "#336633",
    "semangka": "#FF0000",
    "melon": "#93C572",
    "nanas": "#FFD700",
    "jambu biji": "#F2545B"
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
            image: "../img/drinks/es-teh.jpg",
            name: "Es Teh",
            price: 5000,
            calories: 100,
            ingredients: [
            { value: "Teh" },
            { value: "gula" },
            { value: "air" },
            { value: "es batu" },
        ],
            description: "Kesegaran teh manis dingin yang sempurna untuk menemani makanan Anda. Manisnya pas, segarnya luar biasa.",
        },
        {
            id: 2,
            image: "../img/drinks/es-jeruk.jpg",
            name: "Es Jeruk",
            price: 6000,
            calories: 120,
            ingredients: [
            { value: "Jeruk peras" },
            { value: "gula" },
            { value: "air" },
            { value: "es batu" },
        ],
            description: "Minuman jeruk segar dengan sentuhan manis alami. Sempurna untuk menghilangkan dahaga di hari panas!",
        },
        {
            id: 3,
            image: "../img/drinks/es-campur.webp",
            name: "Es campur",
            price: 10000,
            calories: 250,
            ingredients: [
            { value: "Sirup" },
            { value: "es batu" },
            { value: "susu kental manis" },
            { value: "gula pasir" },
            { value: "mangga" },
            { value: "alpukat" },
            { value: "semangka" },
            { value: "melon" },
            { value: "nanas" },
        ],
            description: "Perpaduan sempurna antara es batu yang dingin dan segar, susu kental manis, serta sirup manis yang menggoda, disajikan dengan berbagai potongan buah segar.",
        },
        
    ];

    const input = document.querySelector('#menuIngredients');
  const tagify = new Tagify(input, {
    whitelist: ["Air", "Es Batu", "Gula", "Gula Pasir", "Jeruk Peras", "Teh", "Susu Kental Manis", "Sirup", "Mangga", "Alpukat", "Semangka", "Melon", "Nanas", "Jambu Biji"],
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
            whitelist: ["Air", "Es Batu", "Gula", "Gula Pasir", "Jeruk Peras", "Teh", "Susu Kental Manis", "Sirup", "Mangga", "Alpukat", "Semangka", "Melon", "Nanas", "Jambu Biji"],
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
