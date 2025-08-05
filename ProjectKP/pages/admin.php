<?php
// filepath: c:\xampp\htdocs\website_sekolah\admin.php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "website_sekolah";
$conn = mysqli_connect($host, $user, $pass, $db);

// Tambah konten
if (isset($_POST['tambah'])) {
  $judul = $_POST['judul'];
  $tipe = $_POST['tipe'];
  $isi = $_POST['isi'];
  $sql = "INSERT INTO konten (judul, tipe, isi) VALUES ('$judul', '$tipe', '$isi')";
  mysqli_query($conn, $sql);
  header("Location: admin.php");
  exit;
}

// Edit konten
if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $judul = $_POST['judul'];
  $tipe = $_POST['tipe'];
  $isi = $_POST['isi'];
  $sql = "UPDATE konten SET judul='$judul', tipe='$tipe', isi='$isi' WHERE id=$id";
  mysqli_query($conn, $sql);
  header("Location: admin.php");
  exit;
}

// Hapus konten
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $sql = "DELETE FROM konten WHERE id=$id";
  mysqli_query($conn, $sql);
  header("Location: admin.php");
  exit;
}

// Ambil data konten (kecuali navbar, footer, visi_misi, kontak)
$query = "SELECT * FROM konten WHERE tipe NOT IN ('navbar','footer','visi_misi','kontak')";
$result = mysqli_query($conn, $query);

// Untuk form edit
$editData = null;
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $editQuery = "SELECT * FROM konten WHERE id=$id";
  $editResult = mysqli_query($conn, $editQuery);
  $editData = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Halaman Admin - Manajemen Konten</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f7fa; margin: 0; padding: 0; }
    .container { max-width: 900px; margin: 32px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);}
    h2 { color: #0072bc; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px;}
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left;}
    th { background: #0072bc; color: #fff;}
    tr:nth-child(even) { background: #f2f2f2;}
    .form-section { margin-top: 32px; }
    input[type=text], textarea, select { width: 100%; padding: 8px; margin: 6px 0 12px 0; border: 1px solid #ccc; border-radius: 4px;}
    button { background: #0072bc; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;}
    button:hover { background: #005fa3;}
    .aksi-link { color: #0072bc; text-decoration: none; margin-right: 8px;}
    .aksi-link:hover { text-decoration: underline;}
  </style>
</head>
<body>
  <div class="container">
    <h2>Manajemen Konten Website</h2>
    <table>
      <tr>
        <th>Judul</th>
        <th>Tipe</th>
        <th>Isi</th>
        <th>Aksi</th>
      </tr>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['judul']) ?></td>
        <td><?= htmlspecialchars($row['tipe']) ?></td>
        <td><?= htmlspecialchars(substr($row['isi'],0,60)) ?>...</td>
        <td>
          <a class="aksi-link" href="admin.php?edit=<?= $row['id'] ?>">Edit</a>
          <a class="aksi-link" href="admin.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>

    <div class="form-section">
      <?php if ($editData): ?>
      <h3>Edit Konten</h3>
      <form method="post">
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        <label>Judul</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($editData['judul']) ?>" required>
        <label>Tipe</label>
        <select name="tipe" required>
          <option value="berita_mingguan" <?= $editData['tipe']=='berita_mingguan'?'selected':'' ?>>Berita Mingguan</option>
          <option value="kegiatan_sekolah" <?= $editData['tipe']=='kegiatan_sekolah'?'selected':'' ?>>Kegiatan Sekolah</option>
          <option value="pencapaian_anak" <?= $editData['tipe']=='pencapaian_anak'?'selected':'' ?>>Pencapaian Anak</option>
        </select>
        <label>Isi</label>
        <textarea name="isi" rows="5" required><?= htmlspecialchars($editData['isi']) ?></textarea>
        <button type="submit" name="edit">Simpan Perubahan</button>
        <a href="admin.php" style="margin-left:12px;">Batal</a>
      </form>
      <?php else: ?>
      <h3>Tambah Konten Baru</h3>
      <form method="post">
        <label>Judul</label>
        <input type="text" name="judul" required>
        <label>Tipe</label>
        <select name="tipe" required>
          <option value="berita_mingguan">Berita Mingguan</option>
          <option value="kegiatan_sekolah">Kegiatan Sekolah</option>
          <option value="pencapaian_anak">Pencapaian Anak</option>
        </select>
        <label>Isi</label>
        <textarea name="isi" rows="5" required></textarea>
        <button type="submit" name="tambah">Tambah Konten</button>
      </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>