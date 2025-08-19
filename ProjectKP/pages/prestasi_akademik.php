<?php 
require_once '../db_conn.php';

// Ambil semua data prestasi akademik dari database
$sql_prestasi = "SELECT * FROM prestasi WHERE tipe = 'akademik' ORDER BY id DESC";
$result_prestasi = $conn->query($sql_prestasi);

?>
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
  </header>

  <main>
    <section class="prestasi-section">
      <h2>Daftar Prestasi Akademik</h2>
      <div class="prestasi-list">
        <?php while($prestasi = $result_prestasi->fetch_assoc()): ?>
        <div class="prestasi-card">
          <img src="<?php echo htmlspecialchars($prestasi['gambar_path']); ?>" alt="<?php echo htmlspecialchars($prestasi['nama_peraih']); ?>" class="prestasi-foto">
          <h3><?php echo htmlspecialchars($prestasi['judul']); ?></h3>
          <p class="prestasi-nama"><?php echo htmlspecialchars($prestasi['nama_peraih']); ?></p>
        </div>
        <?php endwhile; ?>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
