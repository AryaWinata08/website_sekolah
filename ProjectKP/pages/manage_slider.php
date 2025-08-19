<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Path penyimpanan gambar
$target_dir = "../assets/images/slider/";

// Pastikan folder slider ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Logika Tambah Slider
if (isset($_POST['add_slider'])) {
    $caption = $_POST['caption'];
    $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar.'); window.location.href = 'admin.php?page=manage_slider';</script>";
        $uploadOk = 0;
    }
    
    // Cek ukuran file (maks 5MB)
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar.'); window.location.href = 'admin.php?page=manage_slider';</script>";
        $uploadOk = 0;
    }

    // Izinkan format tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.'); window.location.href = 'admin.php?page=manage_slider';</script>";
        $uploadOk = 0;
    }

    // Jika semua valid, upload file dan simpan ke database
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO slider (gambar_path, caption) VALUES (?, ?)");
            $stmt->bind_param("ss", $target_file, $caption);
            $stmt->execute();
            echo "<script>alert('Slider baru berhasil ditambahkan.'); window.location.href = 'admin.php?page=manage_slider';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file.'); window.location.href = 'admin.php?page=manage_slider';</script>";
        }
    }
}

// Logika Hapus Slider
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT gambar_path FROM slider WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        // Hapus file gambar dari server
        if (file_exists($row['gambar_path'])) {
            unlink($row['gambar_path']);
        }
        // Hapus data dari database
        $stmt_delete = $conn->prepare("DELETE FROM slider WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        echo "<script>alert('Slider berhasil dihapus.'); window.location.href = 'admin.php?page=manage_slider';</script>";
    }
}

// Ambil semua data slider
$result = $conn->query("SELECT * FROM slider ORDER BY tanggal_upload DESC");
?>

<div class="management-container">
    <h2>Manajemen Slider</h2>

    <div class="form-container">
        <h3>Tambah Gambar Slider Baru</h3>
        <form method="post" enctype="multipart/form-data">
            <label for="caption">Keterangan Gambar:</label>
            <input type="text" id="caption" name="caption">
            <label for="gambar">Pilih Gambar:</label>
            <input type="file" id="gambar" name="gambar" required>
            <button type="submit" name="add_slider">Tambah Slider</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo $row['gambar_path']; ?>" alt="Slider Image" class="thumbnail"></td>
                    <td><?php echo $row['caption']; ?></td>
                    <td>
                        <a href="admin.php?page=manage_slider&action=delete&id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus slider ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
