<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Path penyimpanan gambar
$target_dir = "../assets/images/ekstrakurikuler/";

// Pastikan folder ekstrakurikuler ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Logika Tambah Ekstrakurikuler
if (isset($_POST['add_ekstra'])) {
    $nama_ekstra = $_POST['nama_ekstra'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah_anggota = $_POST['jumlah_anggota'];
    $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
        $uploadOk = 0;
    }
    
    // Cek ukuran file (maks 5MB)
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
        $uploadOk = 0;
    }

    // Izinkan format tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO ekstrakurikuler (nama_ekstra, deskripsi, gambar_path, jumlah_anggota) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nama_ekstra, $deskripsi, $target_file, $jumlah_anggota);
            $stmt->execute();
            echo "<script>alert('Ekstrakurikuler baru berhasil ditambahkan.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
        }
    }
}

// Logika Edit Ekstrakurikuler
if (isset($_POST['edit_ekstra'])) {
    $id = $_POST['id'];
    $nama_ekstra = $_POST['nama_ekstra'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah_anggota = $_POST['jumlah_anggota'];
    
    // Cek apakah ada file gambar baru diupload
    if ($_FILES["gambar"]["name"]) {
        $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek gambar lama untuk dihapus
        $stmt_old = $conn->prepare("SELECT gambar_path FROM ekstrakurikuler WHERE id = ?");
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        $row_old = $result_old->fetch_assoc();
        if ($row_old && file_exists($row_old['gambar_path'])) {
            unlink($row_old['gambar_path']);
        }
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE ekstrakurikuler SET nama_ekstra = ?, deskripsi = ?, gambar_path = ?, jumlah_anggota = ? WHERE id = ?");
            $stmt->bind_param("sssii", $nama_ekstra, $deskripsi, $target_file, $jumlah_anggota, $id);
            $stmt->execute();
            echo "<script>alert('Ekstrakurikuler berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file baru.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
        }

    } else {
        // Jika tidak ada gambar baru, hanya update teks
        $stmt = $conn->prepare("UPDATE ekstrakurikuler SET nama_ekstra = ?, deskripsi = ?, jumlah_anggota = ? WHERE id = ?");
        $stmt->bind_param("ssii", $nama_ekstra, $deskripsi, $jumlah_anggota, $id);
        $stmt->execute();
        echo "<script>alert('Ekstrakurikuler berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
    }
}

// Logika Hapus Ekstrakurikuler
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT gambar_path FROM ekstrakurikuler WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        if (file_exists($row['gambar_path'])) {
            unlink($row['gambar_path']);
        }
        $stmt_delete = $conn->prepare("DELETE FROM ekstrakurikuler WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        echo "<script>alert('Ekstrakurikuler berhasil dihapus.'); window.location.href = 'admin.php?page=manage_ekstrakurikuler';</script>";
    }
}

// Ambil data ekstrakurikuler untuk diedit
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM ekstrakurikuler WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
}

// Ambil semua data ekstrakurikuler
$result = $conn->query("SELECT * FROM ekstrakurikuler ORDER BY nama_ekstra");
?>

<div class="management-container">
    <h2>Manajemen Ekstrakurikuler</h2>

    <div class="form-container">
        <h3><?php echo $edit_data ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler Baru'; ?></h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
            <label for="nama_ekstra">Nama Ekstrakurikuler:</label>
            <input type="text" id="nama_ekstra" name="nama_ekstra" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_ekstra']) : ''; ?>" required>
            
            <label for="deskripsi">Deskripsi Singkat:</label>
            <textarea id="deskripsi" name="deskripsi" rows="3" required><?php echo $edit_data ? htmlspecialchars($edit_data['deskripsi']) : ''; ?></textarea>

            <label for="jumlah_anggota">Jumlah Anggota:</label>
            <input type="number" id="jumlah_anggota" name="jumlah_anggota" value="<?php echo $edit_data ? htmlspecialchars($edit_data['jumlah_anggota']) : ''; ?>" required>
            
            <label for="gambar">Gambar Ekstrakurikuler:</label>
            <input type="file" id="gambar" name="gambar" <?php echo $edit_data ? '' : 'required'; ?>>
            <?php if ($edit_data && $edit_data['gambar_path']): ?>
                <img src="<?php echo htmlspecialchars($edit_data['gambar_path']); ?>" alt="Gambar Ekstrakurikuler Saat Ini" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>

            <button type="submit" name="<?php echo $edit_data ? 'edit_ekstra' : 'add_ekstra'; ?>"><?php echo $edit_data ? 'Simpan Perubahan' : 'Tambah Ekstrakurikuler'; ?></button>
            <?php if ($edit_data): ?>
                <a href="admin.php?page=manage_ekstrakurikuler" class="action-btn">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Jumlah Anggota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['gambar_path']); ?>" alt="Ekstra Image" class="thumbnail"></td>
                    <td><?php echo htmlspecialchars($row['nama_ekstra']); ?></td>
                    <td><?php echo htmlspecialchars($row['jumlah_anggota']); ?></td>
                    <td>
                        <a href="admin.php?page=manage_ekstrakurikuler&action=edit&id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                        <a href="admin.php?page=manage_ekstrakurikuler&action=delete&id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus ekstrakurikuler ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
                    