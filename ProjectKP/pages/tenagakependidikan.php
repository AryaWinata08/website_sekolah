
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tenaga Kependidikan | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/tenagakependidikan.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
    <h1>Tenaga Kependidikan</h1>
  </header>

  <main>
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