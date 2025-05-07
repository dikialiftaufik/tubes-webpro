<?php
session_start();
require_once '../configdb.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// ==== TANGANI AJAX REQUEST DI AWAL FILE ====
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM reservation WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    echo json_encode($res->fetch_assoc());
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    $id = (int) $_POST['id'];
    $action = $_POST['action'];

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM reservation WHERE id = ?");
        $stmt->bind_param("i", $id);
        echo $stmt->execute()
            ? json_encode(['message' => 'Berhasil dihapus'])
            : json_encode(['error' => 'Gagal menghapus']);
        exit();
    }

    if ($action === 'update') {
        $nama = $_POST['nama'] ?? '';
        $jumlah_orang = $_POST['jumlah_orang'] ?? 0;
        $tanggal = $_POST['tanggal'] ?? '';
        $jam_mulai = $_POST['jam_mulai'] ?? '';
        $jam_selesai = $_POST['jam_selesai'] ?? '';
        $pesanan = $_POST['pesanan'] ?? '';
        $status = $_POST['status'] ?? '';

        $stmt = $conn->prepare("UPDATE reservation SET nama = ?, jumlah_orang = ?, tanggal = ?, jam_mulai = ?, jam_selesai = ?, pesanan = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sisssssi", $nama, $jumlah_orang, $tanggal, $jam_mulai, $jam_selesai, $pesanan, $status, $id);
        echo $stmt->execute()
            ? json_encode(['message' => 'Berhasil diperbarui'])
            : json_encode(['error' => 'Gagal memperbarui']);
        exit();
    }
}
?>

<!-- ====== SISANYA ADALAH HTML DAN SCRIPT ====== -->
<!-- Ganti sesuai tampilanmu -->
<!DOCTYPE html>
<html>
<head>
  <title>Reservasi</title>
  <!-- Bootstrap + jQuery + DataTables -->
</head>
<body>
  <!-- Tabel Reservasi, Modal Bootstrap, dst. -->

  <!-- Modal Bootstrap ID: showReservationModal -->
  <!-- Isinya form input readonly/non-readonly -->
  
  <!-- Script AJAX -->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    $(document).on('click', '.view-btn', function () {
      const id = $(this).data('id');
      $.get('reservasi.php', { id }, function (data) {
        $('#showNama').val(data.nama).prop('readonly', true);
        $('#showJumlahOrang').val(data.jumlah_orang).prop('readonly', true);
        $('#showTanggal').val(data.tanggal).prop('readonly', true);
        $('#showJamMulai').val(data.jam_mulai).prop('readonly', true);
        $('#showJamSelesai').val(data.jam_selesai).prop('readonly', true);
        $('#showPesanan').val(data.pesanan).prop('readonly', true);
        $('#showStatus').val(data.status).prop('readonly', true);
        $('#saveChangesBtn').addClass('d-none');
        new bootstrap.Modal(document.getElementById('showReservationModal')).show();
      }, 'json');
    });

    $(document).on('click', '.edit-btn', function () {
      const id = $(this).data('id');
      $.get('reservasi.php', { id }, function (data) {
        $('#showNama').val(data.nama).prop('readonly', false);
        $('#showJumlahOrang').val(data.jumlah_orang).prop('readonly', false);
        $('#showTanggal').val(data.tanggal).prop('readonly', false);
        $('#showJamMulai').val(data.jam_mulai).prop('readonly', false);
        $('#showJamSelesai').val(data.jam_selesai).prop('readonly', false);
        $('#showPesanan').val(data.pesanan).prop('readonly', false);
        $('#showStatus').val(data.status).prop('readonly', false);
        $('#saveChangesBtn').removeClass('d-none').data('id', id);
        new bootstrap.Modal(document.getElementById('showReservationModal')).show();
      }, 'json');
    });

    $('#saveChangesBtn').click(function () {
      const id = $(this).data('id');
      const updatedData = {
        action: 'update',
        id,
        nama: $('#showNama').val(),
        jumlah_orang: $('#showJumlahOrang').val(),
        tanggal: $('#showTanggal').val(),
        jam_mulai: $('#showJamMulai').val(),
        jam_selesai: $('#showJamSelesai').val(),
        pesanan: $('#showPesanan').val(),
        status: $('#showStatus').val()
      };
      $.post('reservasi.php', updatedData, function (res) {
        alert(res.message || res.error || 'Terjadi kesalahan');
        location.reload();
      }, 'json');
    });

    $(document).on('click', '.delete-btn', function () {
      const id = $(this).data('id');
      if (confirm('Yakin ingin menghapus?')) {
        $.post('reservasi.php', { action: 'delete', id }, function (res) {
          alert(res.message || res.error || 'Terjadi kesalahan');
          location.reload();
        }, 'json');
      }
    });
  });
  </script>
</body>
</html>
