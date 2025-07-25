<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/navbar.css">
<link rel="stylesheet" href="../assets/css/kontak.css">

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kontak | SMAN 2 SINGKEP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header>
    <?php include 'navbar.php'; ?>
    <h1>Kontak Kami</h1>
  </header>

  <main>
    <section class="kontak-section">
      <div class="kontak-info">
        <h2>Informasi Kontak</h2>
        <ul>
          <li><i class="fas fa-map-marker-alt"></i> Jl. Pendidikan No. 2, Dabo Singkep, Lingga, Kepulauan Riau</li>
          <li><i class="fas fa-phone"></i> (0776) 123456</li>
          <li><i class="fas fa-envelope"></i> info@sman2singkep.sch.id</li>
        </ul>
        <div class="kontak-maps">
          <iframe src="https://www.google.com/maps?q=SMAN+2+Singkep&output=embed" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
      <div class="kontak-form">
        <h2>Kirim Pesan</h2>
        <form action="#" method="post">
          <input type="text" name="nama" placeholder="Nama Anda" required>
          <input type="email" name="email" placeholder="Email Anda" required>
          <textarea name="pesan" rows="5" placeholder="Tulis pesan Anda..." required></textarea>
          <button type="submit">Kirim</button>
        </form>
      </div>
    </section>
    <?php include 'footer.php'; ?>
  </main>
</body>
</html>
