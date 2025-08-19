<?php 
require_once '../db_conn.php';

// Ambil data visi dan misi dari database
$result = $conn->query("SELECT * FROM visi_misi WHERE id = 1");
$data = $result->fetch_assoc();

// Ubah string misi menjadi array
$misi_list = explode("\n", $data['misi']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Visi & Misi | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/visi_misi.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <main>
    <section class="visi-misi-section">
      <div class="visi-block">
        <h2 class="visi-title">VISI</h2>
        <p class="visi-text">
          <strong><?php echo htmlspecialchars($data['visi']); ?></strong>
        </p>
      </div>
      <div class="misi-block">
        <h2 class="misi-title">MISI</h2>
        <ol class="misi-list">
          <?php foreach ($misi_list as $misi_item): ?>
            <li><?php echo htmlspecialchars($misi_item); ?></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
