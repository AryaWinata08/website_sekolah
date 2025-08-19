<?php 
require_once '../db_conn.php';

// Ambil semua data staf dari database
$sql_staf = "SELECT * FROM staf ORDER BY id ASC";
$result_staf = $conn->query($sql_staf);

$staf_by_kategori_unsorted = [];
while($row = $result_staf->fetch_assoc()) {
    // Kelompokkan staf menggunakan nama kategori mentah dari database
    $staf_by_kategori_unsorted[$row['kategori']][] = $row;
}

// Definisikan urutan kategori yang diinginkan (menggunakan nama mentah)
$desired_order = [
    'kepala_sekolah',
    'wakil_kepala_sekolah',
    'tata_usaha',
    'laboratorium',
    'wali_kelas',
    'guru_pengajar',
    'pembina_ekstrakurikuler'
];

// Buat array baru dengan urutan yang benar
$staf_by_kategori = [];
foreach ($desired_order as $kategori_slug) {
    if (isset($staf_by_kategori_unsorted[$kategori_slug])) {
        // Sortir di dalam kategori berdasarkan `is_pinned`
        usort($staf_by_kategori_unsorted[$kategori_slug], function($a, $b) {
            return $b['is_pinned'] <=> $a['is_pinned'];
        });
        $kategori_display_name = str_replace('_', ' ', ucwords($kategori_slug));
        $staf_by_kategori[$kategori_display_name] = $staf_by_kategori_unsorted[$kategori_slug];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Struktur Organisasi | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/struktur_organisasi.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <main>
    <section class="struktur-section">
      <div class="struktur-list">
        <?php foreach ($staf_by_kategori as $kategori => $list_staf): ?>
          <h3><?php echo htmlspecialchars($kategori); ?></h3>
          <ul>
            <?php foreach ($list_staf as $staf): ?>
              <li>
                <?php if ($staf['gambar_path']): ?>
                  <img src="<?php echo htmlspecialchars($staf['gambar_path']); ?>" alt="<?php echo htmlspecialchars($staf['nama']); ?>" class="staf-foto">
                <?php endif; ?>
                <strong><?php echo htmlspecialchars($staf['jabatan']); ?></strong><br>
                <?php echo htmlspecialchars($staf['nama']); ?><br>
                <span class="nip"><?php echo htmlspecialchars($staf['nip'] ?? 'NIP: -'); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
