<?php 
require_once '../db_conn.php';

// Ambil semua data galeri dari database
$sql_galeri = "SELECT * FROM galeri ORDER BY id DESC";
$result_galeri = $conn->query($sql_galeri);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Galeri | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/galeri.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <main>
    <section class="galeri-section">
      <h2>Dokumentasi Kegiatan SMAN 2 Singkep</h2>
      <div class="galeri-grid">
        <?php while($galeri = $result_galeri->fetch_assoc()): ?>
        <div class="galeri-item">
          <img src="<?php echo htmlspecialchars($galeri['gambar_path']); ?>" alt="<?php echo htmlspecialchars($galeri['judul']); ?>">
          <p class="galeri-caption"><?php echo htmlspecialchars($galeri['judul']); ?></p>
        </div>
        <?php endwhile; ?>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
