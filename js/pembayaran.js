// Fungsi untuk tombol kembali
function goBack() {
    window.history.back();
}

// Fungsi untuk menampilkan logo yang diunggah
function displayLogo(event) {
    const logoPreview = document.getElementById("logo-preview");
    const file = event.target.files[0];

    if (file && file.type === "image/jpeg") {
        const reader = new FileReader();
        reader.onload = function (e) {
            logoPreview.src = e.target.result;
            logoPreview.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        alert("Harap unggah file dengan format .jpg!");
    }
}

// Fungsi untuk menghitung total harga
function hitungHarga() {
    const menu = document.getElementById("menu").value;
    const jumlah = document.getElementById("jumlah").value;
    const totalField = document.getElementById("total");

    if (menu && jumlah) {
        const total = parseInt(menu) * parseInt(jumlah);
        totalField.value = `Rp ${total.toLocaleString("id-ID")}`;
    }
}
