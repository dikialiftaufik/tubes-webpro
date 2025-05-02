document.getElementById("payButton").addEventListener("click", function() {
    
    alert("Pembayaran berhasil! Anda akan diarahkan ke halaman selanjutnya.");
    
 
    window.location.href = "pembayaran-selesai.html";
  });
  
  document.getElementById("backButton").addEventListener("click", function() {
    // Kembali ke halaman sebelumnya
    window.history.back();
  });
  