<?php 
require_once '../db_conn.php';

// Ambil semua data agenda dari database
$sql_agenda = "SELECT * FROM agenda ORDER BY tanggal_mulai DESC";
$result_agenda = $conn->query($sql_agenda);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/agenda.css">
</head>
<body>
  <header>
   <?php include 'navbar.php'; ?>
  </header>
  <main>
    <section class="agenda-section">
      <h2>Daftar Agenda & Kegiatan</h2>
      <div class="agenda-grid">
        <?php while($agenda = $result_agenda->fetch_assoc()): ?>
        <div class="agenda-card">
            <img src="<?php echo htmlspecialchars($agenda['gambar_path']); ?>" alt="<?php echo htmlspecialchars($agenda['judul']); ?>" class="agenda-img">
            <div class="agenda-info">
                <h3><?php echo htmlspecialchars($agenda['judul']); ?></h3>
                <p><i class="fa fa-calendar"></i> <?php echo date('d F Y', strtotime($agenda['tanggal_mulai'])); ?> <?php echo $agenda['tanggal_selesai'] ? 's/d ' . date('d F Y', strtotime($agenda['tanggal_selesai'])) : ''; ?></p>
                <p class="agenda-desc"><?php echo htmlspecialchars($agenda['deskripsi']); ?></p>
            </div>
        </div>
        <?php endwhile; ?>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
