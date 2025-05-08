<?php
session_start();
require_once 'views/header-land-page.php';
require_once 'views/navbar-land-page.php';
require_once 'views/alerts-land-page.php';
?>  
  <!-- About -->
    <section id="about">
      <div class="welcome-grid">
        <div class="welcome-image">
          <img
            src="img/welcome-section.jpg"
          />
        </div>
        <div class="welcome-text">
          <h1>Selamat Datang di BOLOOO!</h1>
          <p style="text-align: justify">
            Selamat datang di restoran keluarga kami, tempat cita rasa bertemu
            dengan tradisi selama lebih dari 50 tahun. Kami bangga menyajikan
            hidangan istimewa yang dibuat dengan bahan-bahan segar pilihan dan
            dimasak dengan penuh keahlian untuk menghadirkan kelezatan di setiap
            sajian.
          </p>
          <p style="text-align: justify">
            Jelajahi menu kami yang beragam, dirancang untuk memanjakan lidah
            Anda dengan berbagai pilihan masakan yang menggugah selera. Nikmati
            pengalaman kuliner yang tak terlupakan bersama kami!
          </p>

          <!-- <div class="graphic-icons">
            <img
              src="https://cdn-icons-png.flaticon.com/128/2941/2941555.png"
              alt="Fresh Ingredients"
            />
            <img
              src="https://cdn-icons-png.flaticon.com/128/2947/2947124.png"
              alt="Traditional Cooking"
            />
            <img
              src="https://cdn-icons-png.flaticon.com/128/5231/5231591.png"
              alt="Family Restaurant"
            />
          </div> -->
        </div>
      </div>
    </section>

    <section id="menu">
      <div class="menu main-container">
        <!-- New Menu -->
        <div class="sub-menu">
          <div class="sub-section-title" data-aos="fade-up">
            <h2>Menu Baru</h2>
            <p>Teman Ngumpul yang Pasti Bikin Ketagihan</p>
            <div class="standing-line"></div>
          </div>
          <div class="menu-details">
            <div class="menu-detail" data-aos="fade-up">
              <div class="menu-item">
                <div>
                  <h4>Sate Goreng Ayam</h4>
                  <p>Daging ayam, bumbu kacang, kecap, lada bubuk</p>
                </div>
                <div>Rp. 25k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Ayam Geprek</h4>
                  <p>Daging ayam, cabai, bawang</p>
                </div>
                <div>Rp. 12k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Sosis Solo</h4>
                  <p>Daging ayam, telur, bumbu</p>
                </div>
                <div>Rp. 3k</div>
              </div>
            </div>
            <div class="menu-detail" data-aos="fade-up">
              <div class="menu-item">
                <div>
                  <h4>Tongseng Kering Sapi</h4>
                  <p>Daging sapi, santan, rempah, kecap</p>
                </div>
                <div>Rp. 25k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Tengkleng Kambing</h4>
                  <p>Iga kambing, santan, rempah, kecap</p>
                </div>
                <div>Rp. 30k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Nasi Goreng Kambing</h4>
                  <p>Daging kambing, nasi, rempah, kecap</p>
                </div>
                <div>Rp. 28k</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- New Menu Carousel -->
    <div
      class="menu-carousel new-menu-carousel"
      data-aos="fade-up"
      data-aos-duration="500"
      data-aos-delay="100"
    >
      <div class="menu-carousel-slide new-menu-carousel-slide">
        <span class="menu-img">
          <img src="img/new-menu/sate-goreng.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Sate Goreng Ayam</a></span
          >
        </span>
        <span class="menu-img">
          <img src="img/new-menu/tongseng-kering-sapi.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Tongseng Kering Sapi</a></span
          > </span
        ><span class="menu-img">
          <img src="img/new-menu/ayam-geprek.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Ayam Geprek</a></span
          > </span
        ><span class="menu-img">
          <img src="img/new-menu/tengkleng-kambing.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Tengkleng Kambing</a></span
          > </span
        ><span class="menu-img">
          <img src="img/new-menu/sosis-solo.webp" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Sosis Solo</a></span
          >
        </span>
        <span class="menu-img">
          <img src="img/new-menu/nasi-goreng.jpg" alt="Nasgor" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Nasi Goreng</a></span
          >
        </span>
      </div>
    </div>

    <!-- Best Seller -->
    <section id="menu">
      <div class="menu main-container">
        <div class="sub-menu">
          <div class="sub-section-title" data-aos="fade-up">
            <h2>Terlaris</h2>
            <p>Teman Ngumpul yang Pasti Bikin Ketagihan</p>
            <div class="standing-line"></div>
          </div>
          <div class="menu-details">
            <div class="menu-detail" data-aos="fade-up">
              <div class="menu-item">
                <div>
                  <h4>Sate Ayam</h4>
                  <p>Daging ayam, bumbu kacang, kecap, lada bubuk</p>
                </div>
                <div>Rp. 22k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Sate Sapi</h4>
                  <p>Daging sapi, bumbu kacang, kecap, lada bubuk</p>
                </div>
                <div>Rp. 35k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Sate Kambing</h4>
                  <p>Daging kambing, bumbu kacang, kecap, lada bubuk</p>
                </div>
                <div>Rp. 35k</div>
              </div>
            </div>
            <div class="menu-detail" data-aos="fade-up">
              <div class="menu-item">
                <div>
                  <h4>Tongseng Ayam</h4>
                  <p>Daging ayam, santan, rempah, kecap</p>
                </div>
                <div>Rp. 25k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Tonseng Sapi</h4>
                  <p>Daging sapi, santan, rempah, kecap</p>
                </div>
                <div>Rp. 25k</div>
              </div>
              <div class="menu-item">
                <div>
                  <h4>Tongseng Kambing</h4>
                  <p>Daging kambing, santan, rempah, kecap</p>
                </div>
                <div>Rp. 25k</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Best Seller Carousel -->
    <div
      class="menu-carousel best-seller-carousel"
      data-aos="fade-up"
      data-aos-duration="500"
      data-aos-delay="100"
    >
      <div class="menu-carousel-slide best-seller-carousel-slide">
        <span class="menu-img">
          <img src="img/best-seller/sate-ayam.jpg" alt="Sate" />
          <span class="tooltip-text">
            <a href="formPemesanan.html">Sate Ayam</a></span
          >
        </span>
        <span class="menu-img">
          <img src="img/best-seller/tongseng-ayam.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Tongseng Ayam</a></span
          >
        </span>
        <span class="menu-img">
          <img src="img/best-seller/sate-sapi.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Sate Sapi</a></span
          > </span
        ><span class="menu-img">
          <img src="img/best-seller/tongseng-sapi.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Tongseng Sapi</a></span
          > </span
        ><span class="menu-img">
          <img src="img/best-seller/sate-kambing.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Sate Kambing</a></span
          > </span
        ><span class="menu-img">
          <img src="img/best-seller/tongseng-kambing.jpg" alt="Sate" />
          <span class="tooltip-text"
            ><a href="formPemesanan.html">Tongseng Kambing</a></span
          >
        </span>
      </div>
    </div>

    <!-- Reservation -->
    <section id="reservation">
      <div class="reservation main-container">
        <div class="section-title" data-aos="fade-up">
          <br />
          <h1>Reservasi</h1>
          <p>Hubungi kami untuk menemukan meja terbaik untuk Anda</p>
        </div>

        <div class="reservation-items">
          <div class="reservation-item-info" data-aos="fade-up">
            <div class="reservation-info">
              <p>Kami akan mengkonfirmasi reservasi Anda dalam waktu 24 jam</p>
            </div>

            <div class="opening-times">
              <h3>Jam Buka</h3>
              <div class="opening-times-schedule">
                <div>
                  <p>Senin - Minggu | 10AM - 9PM</p>
                
                  <br />
                </div>
              </div>
            </div>

            <div class="social-media">
              <div class="image-slider">
            <div class="slides">
              <img src="img/reserv-slider/1.jpg" alt="Suasana Rumah Makan 1">
              <img src="img/reserv-slider/2.jpg" alt="Suasana Rumah Makan 2">
              <img src="img/reserv-slider/3.jpg" alt="Suasana Rumah Makan 3">
            </div>
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>
          </div>
<br>
              <h3>Sosial Media Kami</h3>
              <div class="contact-info-social">
                <a href="https://facebook.com"
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="#fff"
                      d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"
                    /></svg>
                </a>

                <a href="https://instagram.com"
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="#fff"
                      d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                    /></svg>
                </a>

                <a href="https://x.com"
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="#fff"
                      d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"
                    /></svg>
                </a>

                <a href="https://youtube.com"
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="#fff"
                      d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"
                    /></svg>
                </a>
              </div>
            </div>
          </div>

          <form class="reservation-item-form" ... action="process_reservation.php" method="POST">
            <div class="form-row">
              <div class="form-group">
                <label for="table_name">Nama Lengkap</label>
                <input type="text" name="table_name" id="table_name" placeholder="Masukkan Nama Lengkap Anda" required>
              </div>
              <div class="form-group">
                <label for="table_capacity">Jumlah Orang</label>
                <input type="number" name="table_capacity" id="table_capacity" placeholder="Masukkan Jumlah Orang" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="order_date">Tanggal</label>
                <input type="text" name="order_date" id="order_date" placeholder="Pilih Tanggal" class="form-control" required>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="start-time">Jam Mulai</label>
                  <input type="time" name="start_time" id="start-time" placeholder="Masukkan Jam" required>
                </div>
                <div class="form-group">
                  <label for="end-time">Jam Selesai</label>
                  <input type="time" name="end_time" id="end-time" placeholder="Masukkan Jam" required>
                </div>
              </div>
            </div>

            <div class="form-column">
              <div class="form-group">
                <label for="order">Pesan Disini</label>
                <textarea name="order" id="order" placeholder="Kosongkan jika Anda ingin memesan di tempat" cols="30" rows="10"></textarea>
              </div>

              <div class="form-group">
                <button type="submit" name="submit_reservation">Kirim</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- Location -->
    <section id="location">
      <div class="location">
        <div class="map" data-aos="fade-up">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31682.76105736427!2d107.61965053955078!3d-6.968548700000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e9b22a7c041d%3A0xf61de0f3037c02f0!2sSate%20Solo%20Pak%20Komar!5e0!3m2!1sid!2sid!4v1731338445953!5m2!1sid!2sid"
            width="100%"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php
    require_once 'views/footer-land-page.php';
    ?>