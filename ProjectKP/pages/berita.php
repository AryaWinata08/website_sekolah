<?php 
require_once '../db_conn.php';

// Ambil semua data berita dari database
$sql_berita = "SELECT * FROM berita ORDER BY tanggal DESC";
$result_berita = $conn->query($sql_berita);

?>
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
  </header>

  <main>
    <section class="berita-section">
      <h2>Informasi & Berita Terbaru</h2>
      <div class="berita-grid">
        <?php while($berita = $result_berita->fetch_assoc()): ?>
        <div class="berita-card">
          <img src="<?php echo htmlspecialchars($berita['gambar_path']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="berita-img">
          <div class="berita-info">
            <h3><?php echo htmlspecialchars($berita['judul']); ?></h3>
            <span class="berita-date"><i class="fa fa-calendar"></i> <?php echo date('d F Y', strtotime($berita['tanggal'])); ?></span>
            <p><?php echo htmlspecialchars($berita['deskripsi']); ?></p>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
