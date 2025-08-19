<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Path penyimpanan gambar
$target_dir = "../assets/images/galeri/";

// Pastikan folder galeri ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Logika Tambah Foto
if (isset($_POST['add_galeri'])) {
    $judul = $_POST['judul'];
    $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
        $uploadOk = 0;
    }
    
    // Cek ukuran file (maks 5MB)
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
        $uploadOk = 0;
    }

    // Izinkan format tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO galeri (judul, gambar_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $judul, $target_file);
            $stmt->execute();
            echo "<script>alert('Foto galeri berhasil ditambahkan.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
        }
    }
}

// Logika Edit Foto
if (isset($_POST['edit_galeri'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    
    // Cek apakah ada file gambar baru diupload
    if ($_FILES["gambar"]["name"]) {
        $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;

        $stmt_old = $conn->prepare("SELECT gambar_path FROM galeri WHERE id = ?");
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        $row_old = $result_old->fetch_assoc();
        if ($row_old && file_exists($row_old['gambar_path'])) {
            unlink($row_old['gambar_path']);
        }
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE galeri SET judul = ?, gambar_path = ? WHERE id = ?");
            $stmt->bind_param("ssi", $judul, $target_file, $id);
            $stmt->execute();
            echo "<script>alert('Foto galeri berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file baru.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
        }

    } else {
        // Jika tidak ada gambar baru, hanya update judul
        $stmt = $conn->prepare("UPDATE galeri SET judul = ? WHERE id = ?");
        $stmt->bind_param("si", $judul, $id);
        $stmt->execute();
        echo "<script>alert('Foto galeri berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
    }
}

// Logika Hapus Foto
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT gambar_path FROM galeri WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        if (file_exists($row['gambar_path'])) {
            unlink($row['gambar_path']);
        }
        $stmt_delete = $conn->prepare("DELETE FROM galeri WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        echo "<script>alert('Foto galeri berhasil dihapus.'); window.location.href = 'admin.php?page=manage_galeri';</script>";
    }
}

// Ambil data foto untuk diedit
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM galeri WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
}

// Ambil semua data galeri
$result = $conn->query("SELECT * FROM galeri ORDER BY id DESC");
?>

<div class="management-container">
    <h2>Manajemen Galeri</h2>

    <div class="form-container">
        <h3><?php echo $edit_data ? 'Edit Foto Galeri' : 'Tambah Foto Galeri Baru'; ?></h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
            <label for="judul">Judul Foto:</label>
            <input type="text" id="judul" name="judul" value="<?php echo $edit_data ? htmlspecialchars($edit_data['judul']) : ''; ?>" required>
            
            <label for="gambar">Pilih Gambar:</label>
            <input type="file" id="gambar" name="gambar" <?php echo $edit_data ? '' : 'required'; ?>>
            <?php if ($edit_data && $edit_data['gambar_path']): ?>
                <img src="<?php echo htmlspecialchars($edit_data['gambar_path']); ?>" alt="Gambar Galeri Saat Ini" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>

            <button type="submit" name="<?php echo $edit_data ? 'edit_galeri' : 'add_galeri'; ?>"><?php echo $edit_data ? 'Simpan Perubahan' : 'Tambah Foto'; ?></button>
            <?php if ($edit_data): ?>
                <a href="admin.php?page=manage_galeri" class="action-btn">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['gambar_path']); ?>" alt="Galeri Image" class="thumbnail"></td>
                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                    <td>
                        <a href="admin.php?page=manage_galeri&action=edit&id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                        <a href="admin.php?page=manage_galeri&action=delete&id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus foto ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
