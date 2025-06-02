<?php if(isset($_SESSION['info'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    iziToast.info({
        title: 'Info!',
        message: '<?= addslashes($_SESSION["info"]) ?>',
        position: 'topRight',
        timeout: 5000
    });
});
</script>
<?php unset($_SESSION['info']); endif; ?>

<?php
if (isset($_SESSION['reservation_success'])) {
    echo '<script>
        iziToast.success({
            title: "Sukses!",
            message: "Reservasi berhasil dikirim.",
            position: "topRight"
        });
    </script>';
    unset($_SESSION['reservation_success']);
}
if (isset($_SESSION['reservation_error'])) {
    echo '<script>
        iziToast.error({
            title: "Gagal!",
            message: "' . $_SESSION['reservation_error'] . '",
            position: "topRight"
        });
    </script>';
    unset($_SESSION['reservation_error']);
}
?>