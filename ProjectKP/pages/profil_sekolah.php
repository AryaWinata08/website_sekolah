<?php 
require_once '../db_conn.php';

// Ambil 4 berita terbaru
$sql_berita = "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 4";
$result_berita = $conn->query($sql_berita);

// Ambil data siswa untuk ringkasan di tabel
$sql_siswa = "SELECT kelas, 
              COUNT(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 END) AS laki_laki, 
              COUNT(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 END) AS perempuan, 
              COUNT(CASE WHEN agama = 'Islam' THEN 1 END) AS islam,
              COUNT(CASE WHEN agama = 'Kristen' THEN 1 END) AS kristen,
              COUNT(CASE WHEN agama = 'Katolik' THEN 1 END) AS katolik,
              COUNT(CASE WHEN agama = 'Buddha' THEN 1 END) AS buddha,
              COUNT(*) AS jumlah 
              FROM siswa GROUP BY kelas ORDER BY kelas";
$result_siswa = $conn->query($sql_siswa);

$total_laki = 0;
$total_perempuan = 0;
$total_islam = 0;
$total_kristen = 0;
$total_katolik = 0;
$total_buddha = 0;
$total_siswa = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Sekolah | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/profil_sekolah.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
  </header>

  <main class="main-content-layout">
    <!-- Kolom Kiri: Konten Profil Sekolah -->
    <div class="left-column">
      <section class="profil-section">
        <div class="profil-header">
          <div class="profil-img">
            <img src="../assets/images/SMAN2.jpg" alt="Gedung SMAN 2 SINGKEP">
          </div>
          <h2>SMAN 2 SINGKEP</h2>
        </div>
        <div class="profil-desc">
          <p>
            SMAN 2 Singkep merupakan salah satu sekolah menengah atas negeri yang berlokasi di Dabo Singkep, Kabupaten Lingga, Kepulauan Riau. Berdiri sejak tahun XXXX, sekolah ini berkomitmen untuk memberikan pendidikan berkualitas, membentuk karakter, dan menyiapkan generasi muda yang siap bersaing di era global.
          </p>
          <div class="profil-detail">
            <h3>Informasi Sekolah</h3>
            <ul>
              <li><strong>Alamat:</strong> Jl. Pendidikan No. 2, Dabo Singkep, Lingga, Kepulauan Riau</li>
              <li><strong>Telepon / Fax:</strong> (0776) 123456</li>
              <li><strong>Email:</strong> info@sman2singkep.sch.id</li>
              <li><strong>Akreditasi:</strong> A</li>
              <li><strong>Fasilitas:</strong> Laboratorium, Perpustakaan, Lapangan Olahraga, Ruang Multimedia, dll.</li>
            </ul>
          </div>
          <p>
            Dengan tenaga pendidik profesional dan lingkungan belajar yang kondusif, SMAN 2 Singkep terus berinovasi dalam proses pembelajaran serta aktif dalam berbagai kegiatan akademik maupun non-akademik.
          </p>
        </div>
      </section>

      <section class="peserta-section">
        <h2>Data Peserta Didik SMAN 2 Singkep</h2>
        <div class="peserta-table-wrapper">
          <table class="peserta-table">
            <thead>
              <tr>
                <th>Kelas</th>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Islam</th>
                <th>Kristen</th>
                <th>Katolik</th>
                <th>Buddha</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $result_siswa->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                <td><?php echo htmlspecialchars($row['laki_laki']); ?></td>
                <td><?php echo htmlspecialchars($row['perempuan']); ?></td>
                <td><?php echo htmlspecialchars($row['islam']); ?></td>
                <td><?php echo htmlspecialchars($row['kristen']); ?></td>
                <td><?php echo htmlspecialchars($row['katolik']); ?></td>
                <td><?php echo htmlspecialchars($row['buddha']); ?></td>
                <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
              </tr>
              <?php 
                $total_laki += $row['laki_laki'];
                $total_perempuan += $row['perempuan'];
                $total_islam += $row['islam'];
                $total_kristen += $row['kristen'];
                $total_katolik += $row['katolik'];
                $total_buddha += $row['buddha'];
                $total_siswa += $row['jumlah'];
              endwhile; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Total</th>
                <th><?php echo $total_laki; ?></th>
                <th><?php echo $total_perempuan; ?></th>
                <th><?php echo $total_islam; ?></th>
                <th><?php echo $total_kristen; ?></th>
                <th><?php echo $total_katolik; ?></th>
                <th><?php echo $total_buddha; ?></th>
                <th><?php echo $total_siswa; ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <p class="peserta-keterangan">
          Data di atas merupakan jumlah peserta didik berdasarkan tingkat, jenis kelamin, dan agama pada tahun ajaran 2025/2026.
        </p>
      </section>
    </div>

    <!-- Kolom Kanan: Berita Utama -->
    <div class="right-column">
      <section class="berita-utama-section">
        <h2>Berita Terbaru</h2>
        <div class="berita-list">
          <?php while($berita = $result_berita->fetch_assoc()): ?>
            <div class="berita-card-home">
              <img src="<?php echo htmlspecialchars($berita['gambar_path']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="berita-img-home">
              <div class="berita-info">
                <h3><?php echo htmlspecialchars($berita['judul']); ?></h3>
                <span class="berita-date"><i class="fa fa-calendar"></i> <?php echo date('d F Y', strtotime($berita['tanggal'])); ?></span>
                <p><?php echo htmlspecialchars($berita['deskripsi']); ?></p>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </section>
    </div>
  </main>
  <?php include 'footer.php'; ?>
</body>
</html>
