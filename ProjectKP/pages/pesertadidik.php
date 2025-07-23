
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Peserta Didik | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/pesertadidik.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
    <h1>Peserta Didik</h1>
  </header>

  <main>
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