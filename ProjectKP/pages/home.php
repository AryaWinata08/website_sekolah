<?php 
require_once '../db_conn.php';

// Ambil data slider
$sql_slider = "SELECT * FROM slider ORDER BY tanggal_upload DESC";
$result_slider = $conn->query($sql_slider);
$sliders = [];
while($row = $result_slider->fetch_assoc()) {
    $sliders[] = $row;
}

// Ambil 4 berita terbaru
$sql_berita = "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 4";
$result_berita = $conn->query($sql_berita);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <div class="slider-container">
    <button class="slider-btn prev" onclick="prevSlide()">&#10094;</button>
    <div class="slider" id="slider">
      <?php foreach($sliders as $slider): ?>
        <img class="slider-img" src="<?php echo htmlspecialchars($slider['gambar_path']); ?>" alt="<?php echo htmlspecialchars($slider['caption']); ?>">
      <?php endforeach; ?>
    </div>
    <button class="slider-btn next" onclick="nextSlide()">&#10095;</button>
  </div>

  <main class="main-content-layout">
    <!-- Kolom Kiri: Berita Utama -->
    <div class="left-column">
      <section class="berita-utama-section">
        <h2>Berita Terbaru</h2>
        <div class="berita-list">
          <?php while($berita = $result_berita->fetch_assoc()): ?>
            <div class="berita-card-home">
              <img src="<?php echo htmlspecialchars($berita['gambar_path']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="berita-img-home">
              <div class="berita-info">
                <h3><?php echo htmlspecialchars($berita['judul']); ?></h3>
                <span class="berita-date"><i class="fa fa-calendar"></i> <?php echo date('d F Y', strtotime($berita['tanggal'])); ?></span>
                <p><?php echo htmlspecialchars($berita['deskripsi']); ?></p>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </section>
    </div>

    <!-- Kolom Kanan: Informasi & Sambutan Kepala Sekolah (statis) -->
    <div class="right-column">
      <section class="info-card-home">
        <h2>Akreditasi</h2>
        <p class="akreditasi-label">A</p>
      </section>

      <section class="info-card-home">
        <h2>Jurusan</h2>
        <div class="jurusan-list">
          <span>IPA</span>
          <span>IPS</span>
        </div>
      </section>

      <section class="info-card-home">
        <h2>Profil Sekolah</h2>
        <p>SMAN 2 Singkep berlokasi di Jl. Pendidikan No. 2, Dabo Singkep, Lingga, Kepulauan Riau. Sekolah ini berkomitmen memberikan pendidikan berkualitas dan menyiapkan generasi muda yang siap bersaing.</p>
      </section>
      
      <section class="sambutan-section">
        <div class="sambutan-foto">
          <img src="../assets/images/KEPSEK.png" alt="Kepala Sekolah SMAN 2 Singkep">
        </div>
        <div class="sambutan-text">
          <h2>Sambutan Kepala Sekolah</h2>
          <p>
            Assalamu’alaikum Warahmatullahi Wabarakatuh.<br><br>
            Selamat datang di website resmi SMAN 2 Singkep. Kami berkomitmen memberikan pendidikan terbaik, membentuk karakter, dan menyiapkan generasi muda yang unggul, berakhlak mulia, serta berwawasan lingkungan. Semoga website ini menjadi sarana informasi dan komunikasi yang bermanfaat bagi seluruh warga sekolah dan masyarakat.<br><br>
            Wassalamu’alaikum Warahmatullahi Wabarakatuh.
          </p>
          <p class="sambutan-nama"><strong>Frans Adwinata, S.Pd</strong><br>Kepala Sekolah</p>
        </div>
      </section>
    </div>
  </main>

  <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slider-img');
    const totalSlides = slides.length;
    const slider = document.getElementById('slider');
    let autoSlideInterval;
    
    function updateSliderPosition() {
      if (totalSlides > 0) {
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
      }
    }
    
    function nextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides;
      updateSliderPosition();
    }
    
    function prevSlide() {
      currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
      updateSliderPosition();
    }
    
    function startAutoSlide() {
      if (totalSlides > 1) {
        autoSlideInterval = setInterval(nextSlide, 3000);
      }
    }
    
    function stopAutoSlide() {
      clearInterval(autoSlideInterval);
    }
    
    updateSliderPosition();
    startAutoSlide();
    
    document.querySelector('.slider-container').addEventListener('mouseenter', stopAutoSlide);
    document.querySelector('.slider-container').addEventListener('mouseleave', startAutoSlide);
  </script>
  <?php include 'footer.php'; ?>
</body>
</html>
