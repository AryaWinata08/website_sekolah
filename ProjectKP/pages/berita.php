
<link rel="stylesheet" href="../assets/css/navbar.css">
<link rel="stylesheet" href="../assets/css/berita.css">

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Berita | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/berita.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
    <h1>Berita Sekolah</h1>
  </header>

  <main>
    <section class="berita-section">
      <h2>Informasi & Berita Terbaru</h2>
      <div class="berita-list">
        <div class="berita-card">
          <img src="../assets/images/SMAN2.jpg" alt="MPLS 2025" class="berita-img">
          <div class="berita-info">
            <h3>MPLS 2025 Berjalan Lancar</h3>
            <span class="berita-date"><i class="fa fa-calendar"></i> 22 Juli 2025</span>
            <p>Masa Pengenalan Lingkungan Sekolah (MPLS) di SMAN 2 Singkep berlangsung meriah dan penuh semangat. Siswa baru mengikuti berbagai kegiatan edukatif dan kreatif.</p>
          </div>
        </div>
        <div class="berita-card">
          <img src="../assets/images/SMAN2.jpg" alt="Juara Futsal" class="berita-img">
          <div class="berita-info">
            <h3>Tim Futsal Raih Juara 1 Tingkat Kabupaten</h3>
            <span class="berita-date"><i class="fa fa-calendar"></i> 10 Juni 2025</span>
            <p>Tim futsal SMAN 2 Singkep berhasil meraih juara 1 dalam turnamen futsal antar SMA se-Kabupaten Lingga.</p>
          </div>
        </div>
        <div class="berita-card">
          <img src="../assets/images/SMAN2.jpg" alt="Literasi" class="berita-img">
          <div class="berita-info">
            <h3>Gerakan Literasi Sekolah</h3>
            <span class="berita-date"><i class="fa fa-calendar"></i> 5 Mei 2025</span>
            <p>SMAN 2 Singkep mengadakan kegiatan literasi untuk meningkatkan minat baca siswa melalui pojok baca dan lomba menulis cerpen.</p>
          </div>
        </div>
        <!-- Tambahkan berita lain sesuai kebutuhan -->
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>