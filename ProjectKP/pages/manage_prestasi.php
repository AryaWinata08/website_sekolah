<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Path penyimpanan gambar
$target_dir = "../assets/images/prestasi/";

// Pastikan folder prestasi ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Logika Tambah Prestasi
if (isset($_POST['add_prestasi'])) {
    $judul = $_POST['judul'];
    $nama_peraih = $_POST['nama_peraih'];
    $tipe = $_POST['tipe'];
    $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar.');</script>";
        $uploadOk = 0;
    }
    
    // Cek ukuran file (maks 5MB)
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar.');</script>";
        $uploadOk = 0;
    }

    // Izinkan format tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.');</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO prestasi (judul, nama_peraih, gambar_path, tipe) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $judul, $nama_peraih, $target_file, $tipe);
            $stmt->execute();
            echo "<script>alert('Prestasi baru berhasil ditambahkan.');</script>";
            header("Location: admin.php?page=manage_prestasi");
            exit;
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file.');</script>";
        }
    }
}

// Logika Edit Prestasi
if (isset($_POST['edit_prestasi'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $nama_peraih = $_POST['nama_peraih'];
    $tipe = $_POST['tipe'];
    
    // Cek apakah ada file gambar baru diupload
    if ($_FILES["gambar"]["name"]) {
        $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek gambar lama untuk dihapus
        $stmt_old = $conn->prepare("SELECT gambar_path FROM prestasi WHERE id = ?");
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        $row_old = $result_old->fetch_assoc();
        if ($row_old && file_exists($row_old['gambar_path'])) {
            unlink($row_old['gambar_path']);
        }
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE prestasi SET judul = ?, nama_peraih = ?, gambar_path = ?, tipe = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $judul, $nama_peraih, $target_file, $tipe, $id);
            $stmt->execute();
            echo "<script>alert('Prestasi berhasil diperbarui.');</script>";
            header("Location: admin.php?page=manage_prestasi");
            exit;
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file baru.');</script>";
        }

    } else {
        // Jika tidak ada gambar baru, hanya update teks
        $stmt = $conn->prepare("UPDATE prestasi SET judul = ?, nama_peraih = ?, tipe = ? WHERE id = ?");
        $stmt->bind_param("sssi", $judul, $nama_peraih, $tipe, $id);
        $stmt->execute();
        echo "<script>alert('Prestasi berhasil diperbarui.');</script>";
        header("Location: admin.php?page=manage_prestasi");
        exit;
    }
}

// Logika Hapus Prestasi
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT gambar_path FROM prestasi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        if (file_exists($row['gambar_path'])) {
            unlink($row['gambar_path']);
        }
        $stmt_delete = $conn->prepare("DELETE FROM prestasi WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        echo "<script>alert('Prestasi berhasil dihapus.');</script>";
        header("Location: admin.php?page=manage_prestasi");
        exit;
    }
}

// Ambil data prestasi untuk diedit
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM prestasi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
}

// Ambil semua data prestasi
$result = $conn->query("SELECT * FROM prestasi ORDER BY id DESC");
?>

<div class="management-container">
    <h2>Manajemen Prestasi</h2>

    <div class="form-container">
        <h3><?php echo $edit_data ? 'Edit Prestasi' : 'Tambah Prestasi Baru'; ?></h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
            <label for="judul">Judul Prestasi:</label>
            <input type="text" id="judul" name="judul" value="<?php echo $edit_data ? htmlspecialchars($edit_data['judul']) : ''; ?>" required>
            
            <label for="nama_peraih">Nama Peraih Prestasi:</label>
            <input type="text" id="nama_peraih" name="nama_peraih" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_peraih']) : ''; ?>" required>
            
            <label for="gambar">Pilih Gambar:</label>
            <input type="file" id="gambar" name="gambar" <?php echo $edit_data ? '' : 'required'; ?>>
            <?php if ($edit_data && $edit_data['gambar_path']): ?>
                <img src="<?php echo htmlspecialchars($edit_data['gambar_path']); ?>" alt="Gambar Prestasi Saat Ini" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>

            <label for="tipe">Tipe Prestasi:</label>
            <select id="tipe" name="tipe" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="akademik" <?php echo ($edit_data && $edit_data['tipe'] == 'akademik') ? 'selected' : ''; ?>>Akademik</option>
                <option value="non-akademik" <?php echo ($edit_data && $edit_data['tipe'] == 'non-akademik') ? 'selected' : ''; ?>>Non-Akademik</option>
            </select>

            <button type="submit" name="<?php echo $edit_data ? 'edit_prestasi' : 'add_prestasi'; ?>"><?php echo $edit_data ? 'Simpan Perubahan' : 'Tambah Prestasi'; ?></button>
            <?php if ($edit_data): ?>
                <a href="admin.php?page=manage_prestasi" class="action-btn">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Nama Peraih</th>
                    <th>Gambar</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_peraih']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['gambar_path']); ?>" alt="Prestasi Image" class="thumbnail"></td>
                    <td><?php echo htmlspecialchars($row['tipe']); ?></td>
                    <td>
                        <a href="admin.php?page=manage_prestasi&action=edit&id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                        <a href="admin.php?page=manage_prestasi&action=delete&id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus prestasi ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
