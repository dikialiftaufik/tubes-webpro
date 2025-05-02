<!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm rounded">
        <div class="container-fluid">
          <button id="toggleSidebar" class="btn btn-outline-secondary me-3">
            <i class="bi bi-list"></i>
          </button>
          <a class="navbar-brand" href="#">Main Course</a>
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