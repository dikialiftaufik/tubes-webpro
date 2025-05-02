// Mendapatkan modal
var modal = document.getElementById("myModal");

// Mendapatkan semua tombol "Apply Now"
var applyButtons = document.querySelectorAll(".apply");

// Mendapatkan elemen <span> yang menutup modal
var span = document.getElementsByClassName("close")[0];

// Ketika pengguna mengklik tombol "Apply Now", buka modal
applyButtons.forEach(function(button) {
    button.onclick = function() {
        modal.style.display = "block";
    }
});

// Ketika pengguna mengklik <span> (x), tutup modal
span.onclick = function() {
    modal.style.display = "none";
}

// Ketika pengguna mengklik di luar modal, tutup modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Menangani pengiriman form
document.getElementById("applicationForm").onsubmit = function(event) {
    event.preventDefault(); // Mencegah pengiriman form default
    alert("Aplikasi telah dikirim!");
    modal.style.display = "none"; // Tutup modal setelah pengiriman
}

// Get all "Apply Now" buttons
var applyButtons = document.querySelectorAll(".apply");

// Add event listeners for mouseover and mouseout
applyButtons.forEach(function(button) {
    button.addEventListener("mouseover", function() {
        // scale up
        button.style.transform = "scale(1.05)"; // Slightly enlarge
        button.style.transition = "background-color 0.3s ease, transform 0.3s ease"; // Add transition
    });

    button.addEventListener("mouseout", function() {
        // scale back
        button.style.transform = "scale(1)"; // Reset scale
    });
});