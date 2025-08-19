<?php 
require_once '../db_conn.php';

// Ambil semua data ekstrakurikuler dari database
$sql_ekstrakurikuler = "SELECT * FROM ekstrakurikuler ORDER BY nama_ekstra";
$result_ekstrakurikuler = $conn->query($sql_ekstrakurikuler);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ekstrakurikuler | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/ekstrakurikuler.css">
</head>
<body>
  <header>
   <?php include 'navbar.php'; ?>
  <main>
    <section class="ekstra-section">
      <h2>Kegiatan Ekstrakurikuler SMAN 2 Singkep</h2>
      <div class="ekstra-list">
        <?php while($ekstrakurikuler = $result_ekstrakurikuler->fetch_assoc()): ?>
        <div class="ekstra-card">
          <img src="<?php echo htmlspecialchars($ekstrakurikuler['gambar_path']); ?>" alt="<?php echo htmlspecialchars($ekstrakurikuler['nama_ekstra']); ?>">
          <h3><?php echo htmlspecialchars($ekstrakurikuler['nama_ekstra']); ?></h3>
          <p><?php echo htmlspecialchars($ekstrakurikuler['deskripsi']); ?></p>
        </div>
        <?php endwhile; ?>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
