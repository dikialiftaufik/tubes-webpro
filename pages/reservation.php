<?php
// pages/reservasi.php
session_start();
require_once '../configdb.php';

// Cek auth admin
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}


// Konfigurasi pagination
$per_page_options = [10, 25, 50, 100];
$selected_per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], $per_page_options) 
                    ? (int)$_GET['per_page'] 
                    : 10;

$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;

// Parameter pencarian dan sorting
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort_column = in_array($_GET['sort'] ?? '', ['id','nama','jumlah_orang','tanggal','jam_mulai','jam_selesai','status']) ? $_GET['sort'] : 'tanggal';
$sort_order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

$search_term = "%$search%";
$offset = ($page - 1) * $selected_per_page;

// Query data (FIXED)
$query = "SELECT * FROM reservation 
          WHERE nama LIKE ? 
             OR pesanan LIKE ? 
             OR status LIKE ? 
          ORDER BY $sort_column $sort_order 
          LIMIT $selected_per_page OFFSET $offset";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
$reservations = $result->fetch_all(MYSQLI_ASSOC);

// Total data
$total_query = "SELECT COUNT(*) AS total FROM reservation 
                WHERE nama LIKE ? 
                   OR pesanan LIKE ? 
                   OR status LIKE ?";
$stmt_total = $conn->prepare($total_query);
$stmt_total->bind_param("sss", $search_term, $search_term, $search_term);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_reservations = $total_row['total'];
$total_pages = ceil($total_reservations / $selected_per_page);

if ($total_pages > 0 && $page > $total_pages) {
    $query_params = [
        'search' => $search,
        'sort' => $sort_column,
        'order' => $sort_order,
        'per_page' => $selected_per_page,
        'page' => $total_pages
    ];
    header("Location: reservasi.php?" . http_build_query($query_params));
    exit();
}

$title = "Data Reservasi";
include '../views/header.php';
include '../views/navbar.php';
include '../views/sidebar.php';
?>

<div class="main-content">
    <?php include '../views/alerts.php'; ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">Show</span>
                        <select class="form-select" name="per_page" onchange="this.form.submit()">
                            <?php foreach($per_page_options as $option): ?>
                            <option value="<?= $option ?>" <?= $selected_per_page == $option ? 'selected' : '' ?>>
                                <?= $option ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari reservasi..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="reservasi.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jumlah Orang</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Pesanan</th>
                            <th>Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservations as $res): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['id']) ?></td>
                            <td><?= htmlspecialchars($res['nama']) ?></td>
                            <td><?= htmlspecialchars($res['jumlah_orang']) ?></td>
                            <td><?= htmlspecialchars($res['tanggal']) ?></td>
                            <td><?= htmlspecialchars($res['jam_mulai']) ?></td>
                            <td><?= htmlspecialchars($res['jam_selesai']) ?></td>
                            <td><?= htmlspecialchars($res['pesanan']) ?></td>
                            <td><?= htmlspecialchars($res['status']) ?></td>
                            <td>
                            <a href="view_reservation.php?id=<?= $res['id'] ?>" class="btn btn-sm btn-info show-btn" data-id="<?= $res['id'] ?>">
                            <a href="edit_reservation.php?id=<?= $res['id'] ?>" class="btn btn-sm btn-warning edit-btn" data-id="<?= $res['id'] ?>">
                            <button ... class="btn btn-sm btn-danger delete-btn" data-id="<?= $res['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus reservasi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
          // ================= FITUR SHOW =================
          function showReservation(id) {
        const reservation = reservationData.find(r => r.id === id);
        
        // Format tanggal
        const options = { 
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        };
        const formattedDate = new Date(reservation.tanggalWaktu).toLocaleDateString('id-ID', options);
        
        // Format status
        const statusBadge = reservation.status === 'Tersedia' ? 
          '<span class="badge bg-success">Tersedia</span>' : 
          '<span class="badge bg-danger">Tidak Tersedia</span>';

        // Update modal
        document.getElementById('showNama').value = reservation.nama;
        document.getElementById('showJumlahOrang').value = reservation.jumlahOrang;
        document.getElementById('showTanggalWaktu').innerHTML = formattedDate;
        document.getElementById('showStatus').innerHTML = statusBadge;
        document.getElementById('showPesanan').value = reservation.pesanan;

        $('#showReservationModal').modal('show');
      }

      // Event listener untuk tombol show
      $('#reservationTable').on('click', '.show-btn', function() {
        const id = $(this).data('id');
        showReservation(id);
      });

      // Add Reservation
      document.getElementById('saveReservation').addEventListener('click', () => {
        const newReservation = {
          id: Date.now(),
          nama: document.getElementById('nama').value,
          jumlahOrang: parseInt(document.getElementById('jumlahOrang').value),
          tanggalWaktu: document.getElementById('tanggalWaktu').value,
          pesanan: document.getElementById('pesanan').value,
          status: document.getElementById('status').value
        };

        reservationData.push(newReservation);
        table.clear().rows.add(reservationData).draw();
        $('#addReservationModal').modal('hide');
        document.getElementById('addReservationForm').reset();
        
        Swal.fire({
          icon: 'success',
          title: 'Reservasi Berhasil!',
          text: 'Data reservasi telah ditambahkan'
        });
      });

       // Edit Reservation
       $('#reservationTable').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const reservation = reservationData.find(r => r.id === id);
        
        document.getElementById('editReservationId').value = id;
        document.getElementById('editNama').value = reservation.nama;
        document.getElementById('editJumlahOrang').value = reservation.jumlahOrang;
        document.getElementById('editTanggalWaktu').value = reservation.tanggalWaktu;
        document.getElementById('editPesanan').value = reservation.pesanan;
        document.getElementById('editStatus').value = reservation.status;
        
        $('#editReservationModal').modal('show');
      });

      // Update Reservation
      document.getElementById('updateReservation').addEventListener('click', () => {
        const id = parseInt(document.getElementById('editReservationId').value);
        const index = reservationData.findIndex(r => r.id === id);
        
        reservationData[index] = {
          id: id,
          nama: document.getElementById('editNama').value,
          jumlahOrang: parseInt(document.getElementById('editJumlahOrang').value),
          tanggalWaktu: document.getElementById('editTanggalWaktu').value,
          pesanan: document.getElementById('editPesanan').value,
          status: document.getElementById('editStatus').value
        };

        table.clear().rows.add(reservationData).draw();
        $('#editReservationModal').modal('hide');
        
        Swal.fire({
          icon: 'success',
          title: 'Perubahan Tersimpan!',
          text: 'Data reservasi telah diperbarui'
        });
      });

      // Delete Reservation
      $('#reservationTable').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        
        Swal.fire({
          title: 'Hapus Reservasi?',
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus!'

        }).then((result) => {
          if (result.isConfirmed) {
            reservationData = reservationData.filter(r => r.id !== id);
            table.clear().rows.add(reservationData).draw();
            
            Swal.fire(
              'Terhapus!',
              'Data reservasi telah dihapus',
              'success'
            );
        }
        });
</script>

<?php 
include '../views/footer.php';
$conn->close();
?>
