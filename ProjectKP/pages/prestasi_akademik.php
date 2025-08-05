

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Prestasi Akademik | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/prestasi.css">
</head>
<body>
  <header>
     <?php include 'navbar.php'; ?>
    <h1>Prestasi Akademik</h1>
  </header>

  <main>
    <section class="prestasi-section">
      <h2>Daftar Prestasi Akademik</h2>
      <div class="prestasi-list">
        <div class="prestasi-card">
          <img src="../assets/images/SMAN2.jpg" alt="Andi Saputra" class="prestasi-foto">
          <h3>Juara 1 Olimpiade Matematika Tingkat Kabupaten</h3>
          <p class="prestasi-nama">Andi Saputra</p>
        </div>
        <div class="prestasi-card">
          <img src="../assets/images/SMAN2.jpg" alt="Siti Rahmawati" class="prestasi-foto">
          <h3>Juara 2 Lomba Cerdas Cermat IPA Provinsi</h3>
          <p class="prestasi-nama">Siti Rahmawati</p>
        </div>
        <div class="prestasi-card">
          <img src="../assets/images/SMAN2.jpg" alt="Budi Santoso" class="prestasi-foto">
          <h3>Finalis KSN (Kompetisi Sains Nasional) Bidang Fisika</h3>
          <p class="prestasi-nama">Budi Santoso</p>
        </div>
        <!-- Tambahkan prestasi lain sesuai kebutuhan -->
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>