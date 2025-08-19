<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Path penyimpanan gambar
$target_dir = "../assets/images/agenda/";

// Pastikan folder agenda ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Logika Tambah Agenda
if (isset($_POST['add_agenda'])) {
    $judul = $_POST['judul'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
        $uploadOk = 0;
    }
    
    // Cek ukuran file (maks 5MB)
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
        $uploadOk = 0;
    }

    // Izinkan format tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO agenda (judul, gambar_path, tanggal_mulai, lokasi, deskripsi) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $judul, $target_file, $tanggal_mulai, $lokasi, $deskripsi);
            $stmt->execute();
            echo "<script>alert('Agenda baru berhasil ditambahkan.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
        }
    }
}

// Logika Edit Agenda
if (isset($_POST['edit_agenda'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    
    // Cek apakah ada file gambar baru diupload
    if ($_FILES["gambar"]["name"]) {
        // Logika upload gambar baru
        $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek gambar lama untuk dihapus
        $stmt_old = $conn->prepare("SELECT gambar_path FROM agenda WHERE id = ?");
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        $row_old = $result_old->fetch_assoc();
        if ($row_old && file_exists($row_old['gambar_path'])) {
            unlink($row_old['gambar_path']);
        }
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE agenda SET judul = ?, gambar_path = ?, tanggal_mulai = ?, lokasi = ?, deskripsi = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $judul, $target_file, $tanggal_mulai, $lokasi, $deskripsi, $id);
            $stmt->execute();
            echo "<script>alert('Agenda berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file baru.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
        }

    } else {
        // Jika tidak ada gambar baru, hanya update teks
        $stmt = $conn->prepare("UPDATE agenda SET judul = ?, tanggal_mulai = ?, lokasi = ?, deskripsi = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $judul, $tanggal_mulai, $lokasi, $deskripsi, $id);
        $stmt->execute();
        echo "<script>alert('Agenda berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
    }
}

// Logika Hapus Agenda
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT gambar_path FROM agenda WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        if (file_exists($row['gambar_path'])) {
            unlink($row['gambar_path']);
        }
        $stmt_delete = $conn->prepare("DELETE FROM agenda WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        echo "<script>alert('Agenda berhasil dihapus.'); window.location.href = 'admin.php?page=manage_agenda';</script>";
    }
}

// Ambil data agenda untuk diedit
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM agenda WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
}

// Ambil semua data agenda
$result = $conn->query("SELECT * FROM agenda ORDER BY tanggal_mulai DESC");
?>

<div class="management-container">
    <h2>Manajemen Agenda</h2>

    <div class="form-container">
        <h3><?php echo $edit_data ? 'Edit Agenda' : 'Tambah Agenda Baru'; ?></h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
            <label for="judul">Judul Agenda:</label>
            <input type="text" id="judul" name="judul" value="<?php echo $edit_data ? htmlspecialchars($edit_data['judul']) : ''; ?>" required>
            
            <label for="gambar">Gambar Agenda:</label>
            <input type="file" id="gambar" name="gambar" <?php echo $edit_data ? '' : 'required'; ?>>
            <?php if ($edit_data && $edit_data['gambar_path']): ?>
                <img src="<?php echo htmlspecialchars($edit_data['gambar_path']); ?>" alt="Gambar Agenda Saat Ini" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>
            
            <label for="tanggal_mulai">Tanggal Mulai:</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $edit_data ? $edit_data['tanggal_mulai'] : ''; ?>" required>
            
            <label for="lokasi">Lokasi Kegiatan:</label>
            <input type="text" id="lokasi" name="lokasi" value="<?php echo $edit_data ? htmlspecialchars($edit_data['lokasi']) : ''; ?>" required>

            <label for="deskripsi">Deskripsi Singkat:</label>
            <textarea id="deskripsi" name="deskripsi" rows="5" required><?php echo $edit_data ? htmlspecialchars($edit_data['deskripsi']) : ''; ?></textarea>

            <button type="submit" name="<?php echo $edit_data ? 'edit_agenda' : 'add_agenda'; ?>"><?php echo $edit_data ? 'Simpan Perubahan' : 'Tambah Agenda'; ?></button>
            <?php if ($edit_data): ?>
                <a href="admin.php?page=manage_agenda" class="action-btn">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['gambar_path']); ?>" alt="Agenda Image" class="thumbnail"></td>
                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                    <td><?php echo htmlspecialchars($row['tanggal_mulai']); ?></td>
                    <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
                    <td>
                        <a href="admin.php?page=manage_agenda&action=edit&id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                        <a href="admin.php?page=manage_agenda&action=delete&id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus agenda ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
