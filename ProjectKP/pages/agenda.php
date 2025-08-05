
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AGENDA SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>
  <header>
   <?php include 'navbar.php'; ?>
    <h1>Agenda Sekolah</h1>
  </header>

  <main>
    <section class="agenda-section">
      <h2>Daftar Agenda & Kegiatan</h2>
      <ul class="agenda-list">
        <li>
          <div class="agenda-date">
            <span class="agenda-day">21</span>
            <span class="agenda-month">Jul</span>
          </div>
          <div class="agenda-info">
            <h3>Masa Pengenalan Lingkungan Sekolah (MPLS)</h3>
            <p>21 - 23 Juli 2025 | Aula SMAN 2 Singkep</p>
            <p>Pengenalan lingkungan sekolah untuk siswa baru.</p>
          </div>
        </li>
        <li>
          <div class="agenda-date">
            <span class="agenda-day">1</span>
            <span class="agenda-month">Agu</span>
          </div>
          <div class="agenda-info">
            <h3>Upacara Hari Kemerdekaan RI</h3>
            <p>17 Agustus 2025 | Lapangan SMAN 2 Singkep</p>
            <p>Memperingati HUT RI ke-80 dengan upacara bendera dan lomba-lomba.</p>
          </div>
        </li>
        <li>
          <div class="agenda-date">
            <span class="agenda-day">5</span>
            <span class="agenda-month">Sep</span>
          </div>
          <div class="agenda-info">
            <h3>Try Out UTBK</h3>
            <p>5 September 2025 | Ruang Kelas XII</p>
            <p>Simulasi ujian masuk perguruan tinggi untuk kelas XII.</p>
          </div>
        </li>
        <!-- Tambahkan agenda lain sesuai kebutuhan -->
      </ul>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>