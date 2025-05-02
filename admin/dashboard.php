<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../img/logo/logo-alt.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css">
    <style>
      @media (max-width: 768px) {
    .sidebar {
      width: 100%;
      height: auto;
      position: relative;
    }

    .sidebar.collapsed {
      display: none;
    }

    .content {
      margin-left: 0;
    }
    .logo-container {
      display: none; /* Sembunyikan logo pada desktop view */
    }
    #sidebar .d-flex.align-items-center.justify-content-between {
      display: flex;
    }
    .row {
      gap: 15px;
    }
  }

  @media (max-width: 576px) {
    .card-title {
      font-size: 1.5rem;
    }

    .chart-controls {
      flex-direction: column;
    }
  }
      .chart-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
      }
      .stat-card {
        transition: transform 0.3s;
      }
      .stat-card:hover {
        transform: translateY(-5px);
      }
      .chart-controls {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
      }
      .chart-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 15px;
      }

     .footer-custom {
  background-color: #dcdcdc; /* Warna latar */
  padding: 15px 0; /* Padding vertikal */
  font-size: 0.875rem; /* Ukuran font */
  color: #000; /* Warna teks */
  display: flex; /* Gunakan flexbox */
  justify-content: center; /* Pusatkan horizontal */
  align-items: center; /* Pusatkan vertikal */
  text-align: center; /* Pusatkan teks */
  width: 100%; /* Lebar penuh */
  position: relative; /* Posisi default */
}
.footer-custom a {
  text-decoration: none;
  color: inherit;
}
.footer-custom a:hover {
  text-decoration: underline;
}
    </style>
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

      <div class="menu-item active-menu-item">
        <a href="dashboard.php"
          ><i class="bi bi-house-door me-2"></i> <span>Dashboard</span></a
        >
      </div>
       <div class="menu-item">
        <a href="report.php"
          ><i class="bi bi-bar-chart-line me-2"></i> <span>Report</span></a
        >
      </div>
      <div class="menu-item">
        <a href="mainCourse.php"
          ><i class="bi bi-egg-fried me-2"></i> <span>Main Course</span></a>
      </div>
      <div class="menu-item">
        <a href="drinks.php"
          ><i class="bi bi-cup me-2"></i> <span>Drinks</span></a>
      </div>
      <div class="menu-item">
        <a href="sideDish.php"
          ><i class="bi bi-egg me-2"></i></i> <span>Side Dish</span></a>
      </div>
      <div class="menu-item">
        <a href="package.php"
          ><i class="bi bi-basket3 me-2"></i></i> <span>Paket</span></a>
      </div>
      <div class="menu-item">
        <a href="order.php"
          ><i class="bi bi-cart3 me-2"></i> <span>Pesanan</span></a>
      </div>
      <div class="menu-item">
        <a href="reservation.php"
          ><i class="bi bi-calendar2-check me-2"></i> <span>Reservasi</span></a>
      </div>
      <div class="menu-item">
        <a href="users.php"
          ><i class="bi bi-person me-2"></i> <span>Users</span></a
        >
      </div>
      <div class="menu-item">
        <a href="notification.php"
          ><i class="bi bi-bell me-2"></i> <span>Notifikasi</span></a
        >
      </div>
<div class="menu-item dropdown" id="dropdownMenu">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-briefcase me-2"></i> <span>Karir</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-start">
        <li>
            <a class="dropdown-item" href="jobs.php">
                <i class="bi bi-person-badge me-2"></i>Lowongan
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="applicant.php">
                <i class="bi bi-person-badge me-2"></i>Pelamar
            </a>
        </li>
    </ul>
</div>
      
    </div>

    <!-- Main Content -->
    <div id="content" class="content">
      <!-- Navbar -->
      <nav
        class="navbar navbar-expand-lg navbar-light bg-light shadow-sm rounded"
      >
        <div class="container-fluid">

    <!-- Tombol toggle sidebar untuk desktop -->
    <button id="toggleSidebar" class="btn btn-outline-secondary me-3 d-none d-md-inline">
      <i class="bi bi-list"></i>
    </button>
      <a class="navbar-brand" href="#">Admin Dashboard</a>
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

  <!-- Profile -->
  <div class="dropdown">
    <button
      class="profile-button rounded"
      type="button"
      id="profileDropdown"
      data-bs-toggle="dropdown"
      aria-expanded="false"
    >
      <img
        src="../img/profile-pic.png"
        alt="Profile"
        class="rounded-circle"
      />
      <div class="text-start">
        <strong>Diki Alif</strong><br />
        <small class="text-muted">Super Admin</small>
      </div>
    </button>
    <ul
      class="dropdown-menu dropdown-menu-end profile-dropdown shadow"
      aria-labelledby="profileDropdown"
    >
      <li>
        <a
          class="dropdown-item"
          href="#"
          data-bs-toggle="modal"
          data-bs-target="#profileModal"
        >
          <i class="bi bi-person me-2"></i>Profil
        </a>
      </li>
      <li><hr class="dropdown-divider" /></li>
      <li>
        <a class="dropdown-item text-danger" href="login.php"
          ><i class="bi bi-box-arrow-right me-2"></i>Keluar</a
        >
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
            aria-hidden="true"
          >
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <form id="profileForm">
                    <div class="mb-3 text-center">
                      <img
                        id="profilePicturePreview"
                        src="../img/profile-pic.png"
                        alt="Profile Picture"
                        class="rounded-circle mb-2"
                        style="width: 100px; height: 100px"
                      /><br />
                      <button
                        type="button"
                        id="editPictureButton"
                        class="btn btn-outline-primary btn-sm mt-2"
                        style="display: none"
                      >
                        Change Picture</button
                      ><br /><br />
                      <input
                        type="file"
                        id="profilePictureInput"
                        class="form-control"
                        style="display: none"
                        accept="image/*"
                      />
                    </div>

                    <!-- Two-Column Layout -->
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="username" class="form-label"
                          >Username</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="bi bi-person"></i>
                          </span>
                          <input
                            type="text"
                            id="username"
                            class="form-control"
                            value="Diki Alif"
                            disabled
                          />
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
                            disabled
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="password" class="form-label"
                          >Password</label
                        >
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                          </span>
                          <input
                            type="password"
                            id="password"
                            class="form-control"
                            value="password123"
                            disabled
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="level" class="form-label">Level</label>
                        <div class="input-group">
                          <span class="input-group-text">
                            <i class="bi bi-people"></i>
                          </span>
                          <select id="level" class="form-select" disabled>
                            <option value="Super Admin" selected>
                              Super Admin
                            </option>
                            <option value="Kasir">Kasir</option>
                            <option value="Kitchen">Kitchen</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="button" id="editButton" class="btn btn-success">
                    Edit
                  </button>
                  <button
                    type="button"
                    id="saveButton"
                    class="btn btn-success"
                    style="display: none"
                  >
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <!-- Dashboard Content -->
      <div class="container mt-4">
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="card text-white bg-primary stat-card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="card-subtitle mb-2">Total Customers</h6>
                    <h3 class="card-title mb-0">1,200</h3>
                    <small>+8.5% dari bulan lalu</small>
                  </div>
                  <i class="bi bi-people fs-1"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-white bg-success stat-card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="card-subtitle mb-2">Revenue</h6>
                    <h3 class="card-title mb-0">Rp 20M</h3>
                    <small>+12.3% dari bulan lalu</small>
                  </div>
                  <i class="bi bi-currency-dollar fs-1"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-white bg-warning stat-card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="card-subtitle mb-2">Pending Orders</h6>
                    <h3 class="card-title mb-0">15</h3>
                    <small>5 membutuhkan tindakan</small>
                  </div>
                  <i class="bi bi-exclamation-triangle fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Chart Controls -->
        <div class="chart-controls">
          <div class="d-flex justify-content-between align-items-center">
            <div class="chart-title">Analisis Penjualan</div>
            <div class="d-flex gap-2">
              <select id="timeRange" class="form-select" style="width: 125px">
                <option value="week">Mingguan</option>
                <option value="month">Bulanan</option>
                <option value="year">Tahunan</option>
              </select>
              <select id="yearSelect" class="form-select" style="width: 100px">
                <option value="2024">2024</option>
              </select>
            </div>
          </div>
        </div>

        <div class="chart-container">
          <canvas id="salesChart" width="756px" height="312px"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.getElementById("toggleSidebarMobile").addEventListener("click", () => {
  document.getElementById("sidebar").classList.toggle("collapsed");
});

      // Sidebar toggle
      document.getElementById("toggleSidebar").addEventListener("click", () => {
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");
        sidebar.classList.toggle("collapsed");
        content.classList.toggle("collapsed");
      });

      // Active menu item
      document.querySelectorAll(".menu-item").forEach((item) => {
        item.addEventListener("click", function () {
          document
            .querySelector(".active-menu-item")
            .classList.remove("active-menu-item");
          this.classList.add("active-menu-item");
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
            title: "Profile Updated",
            text: "Your profile has been successfully updated.",
            // timer: 2000, // (2000ms = 2 detik)
            // showConfirmButton: false,
            confirmButtonText: "OK"
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

      // Sample data
      const weeklyData = {
        labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"],
        data: [
          5000000, 7000000, 8000000, 6000000, 7500000, 8500000, 9000000,
          8000000, 8500000, 9500000, 10000000, 9500000,
        ],
      };

      const monthlyData = {
        labels: [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ],
        data: [
          15000000, 17000000, 20000000, 18000000, 22000000, 25000000, 23000000,
          26000000, 28000000, 27000000, 30000000, 32000000,
        ],
      };

      const yearlyData = {
        labels: ["2024"],
        data: [280000000],
      };

      // Initialize chart
      const ctx = document.getElementById("salesChart").getContext("2d");
      const salesChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: weeklyData.labels,
          datasets: [
            {
              label: "Penjualan (IDR)",
              data: weeklyData.data,
              backgroundColor: "rgba(75, 192, 192, 0.6)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: "top",
            },
            title: {
              display: true,
              text: "Grafik Penjualan 2024",
            },
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function (value) {
                  return "Rp " + (value / 1000000).toFixed(1) + "M";
                },
              },
            },
          },
        },
      });

      // Handle time range changes
      document.getElementById("timeRange").addEventListener("change", (e) => {
        let data;
        let title;
        switch (e.target.value) {
          case "week":
            data = weeklyData;
            title = "Grafik Penjualan Mingguan 2024";
            break;
          case "month":
            data = monthlyData;
            title = "Grafik Penjualan Bulanan 2024";
            break;
          case "year":
            data = yearlyData;
            title = "Total Penjualan 2024";
            break;
        }
        salesChart.data.labels = data.labels;
        salesChart.data.datasets[0].data = data.data;
        salesChart.options.plugins.title.text = title;
        salesChart.update();
      });
    </script>
  </body>
</html>
