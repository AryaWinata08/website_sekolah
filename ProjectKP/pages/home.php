<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/navbar.css">
<link rel="stylesheet" href="../assets/css/home.css">

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
    <h1>SMAN 2 SINGKEP</h1>
    <div class="slider-container">
  <button class="slider-btn prev" onclick="prevSlide()">&#10094;</button>
  <div class="slider" id="slider">
    <img class="slider-img" src="../assets/images/SMAN2.jpg" alt="Foto SMAN 2">
    <img class="slider-img" src="../assets/images/SMAN2_2.png" alt="Kegiatan 1">
    <img class="slider-img" src="../assets/images/SMAN2_3.png" alt="Kegiatan 2">
  </div>
  <button class="slider-btn next" onclick="nextSlide()">&#10095;</button>
</div>
  </header>

  <main>
    <section id="profil-sekolah">
      <h2>Profil Sekolah</h2>
      <p>SMAN 2 SINGKEP adalah sekolah menengah atas yang berkomitmen untuk memberikan pendidikan berkualitas dan membentuk generasi muda yang berprestasi, berkarakter, dan siap menghadapi tantangan global.</p>
    </section>
    <section id="informasi">
      <h2>Informasi Umum</h2>
      <ul>
        <li>Berita dan Pengumuman</li>
        <li>Jadwal Pelajaran</li>
        <li>Ekstrakurikuler</li>
        <li>Prestasi Siswa</li>
        <li>Kontak & Lokasi</li>
      </ul>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 SMAN 2 SINGKEP. All rights reserved.</p>
  </footer>

  <script>
let currentSlide = 0;
const slides = document.querySelectorAll('.slider-img');
const totalSlides = slides.length;
const slider = document.getElementById('slider');
let autoSlideInterval;

function updateSliderPosition() {
  slider.style.transform = `translateX(-${currentSlide * 100}%)`;
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
  autoSlideInterval = setInterval(nextSlide, 3000);
}

function stopAutoSlide() {
  clearInterval(autoSlideInterval);
}

updateSliderPosition();
startAutoSlide();

document.querySelector('.slider-container').addEventListener('mouseenter', stopAutoSlide);
document.querySelector('.slider-container').addEventListener('mouseleave', startAutoSlide);
</script>
</body>
</html>