

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
  <link rel="stylesheet" href="../assets/css/tenagakependidikan.css">
  
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
    <h1>Struktur Organisasi</h1>
  </header>

  <main>
    <section class="struktur-section">
      <h2>Struktur Organisasi SMAN 2 Singkep</h2>
      <div class="struktur-img">
        <img src="../assets/images/struktur_organisasi.jpg" alt="Struktur Organisasi SMAN 2 Singkep">
      </div>
      <div class="struktur-list">
        <ul>
          <li><strong>Kepala Sekolah:</strong> Frans Adwinata, S.Pd</li>
          <li><strong>Wakil Kepala Sekolah:</strong> Bapak Ahmad Fauzi, M.Pd</li>
          <li><strong>Kepala Tata Usaha:</strong> Bapak Ahmad</li>
          <li><strong>Bendahara:</strong> Ibu Siti</li>
          <li><strong>Koordinator Kesiswaan:</strong> Ibu Rina</li>
          <li><strong>Koordinator Kurikulum:</strong> Bapak Joko</li>
          <li><strong>Koordinator Sarpras:</strong> Ibu Maya</li>
          <!-- Tambahkan jabatan lain sesuai kebutuhan -->
        </ul>
      </div>
    </section>

    <section class="tenaga-section">
      <h2>Daftar Tenaga Kependidikan SMAN 2 Singkep</h2>
      <div class="tenaga-grid">
        <div class="tenaga-card">
          <img src="../assets/images/tenaga1.jpg" alt="Bapak Ahmad" class="tenaga-foto">
          <h3>Bapak Ahmad</h3>
          <p>Kepala Tata Usaha</p>
        </div>
        <div class="tenaga-card">
          <img src="../assets/images/tenaga2.jpg" alt="Ibu Siti" class="tenaga-foto">
          <h3>Ibu Siti</h3>
          <p>Bendahara Sekolah</p>
        </div>
        <div class="tenaga-card">
          <img src="../assets/images/tenaga3.jpg" alt="Pak Budi" class="tenaga-foto">
          <h3>Pak Budi</h3>
          <p>Petugas Kebersihan</p>
        </div>
        <!-- Tambahkan tenaga kependidikan lain sesuai kebutuhan -->
      </div>
    </section>

    <?php include 'footer.php'; ?>
  </main>
</body>
</html>