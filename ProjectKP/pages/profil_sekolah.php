

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
  <link rel="stylesheet" href="../assets/css/pesertadidik.css">
  
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
    <h1>Profil Sekolah</h1>
  </header>

  <main>
    <section class="profil-section">
      <div class="profil-img">
        <img src="../assets/images/SMAN2.jpg" alt="Gedung SMAN 2 SINGKEP">
      </div>
      <div class="profil-desc">
        <h2>SMAN 2 SINGKEP</h2>
        <p>
          SMAN 2 Singkep merupakan salah satu sekolah menengah atas negeri yang berlokasi di Dabo Singkep, Kabupaten Lingga, Kepulauan Riau. Berdiri sejak tahun XXXX, sekolah ini berkomitmen untuk memberikan pendidikan berkualitas, membentuk karakter, dan menyiapkan generasi muda yang siap bersaing di era global.
        </p>
        <ul>
          <li><strong>Alamat:</strong> Jl. Pendidikan No. 2, Dabo Singkep, Lingga, Kepulauan Riau</li>
          <li><strong>Akreditasi:</strong> A</li>
          <li><strong>Jumlah Siswa:</strong> ± 600 siswa</li>
          <li><strong>Fasilitas:</strong> Laboratorium, Perpustakaan, Lapangan Olahraga, Ruang Multimedia, dll.</li>
        </ul>
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
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>X</td>
              <td>60</td>
              <td>70</td>
              <td>130</td>
            </tr>
            <tr>
              <td>XI</td>
              <td>55</td>
              <td>65</td>
              <td>120</td>
            </tr>
            <tr>
              <td>XII</td>
              <td>50</td>
              <td>60</td>
              <td>110</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Total</th>
              <th>165</th>
              <th>195</th>
              <th>360</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <p class="peserta-keterangan">
        Data di atas merupakan jumlah peserta didik berdasarkan tingkat dan jenis kelamin pada tahun ajaran 2025/2026.
      </p>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>