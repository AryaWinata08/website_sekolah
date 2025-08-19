<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Path penyimpanan gambar
$target_dir = "../assets/images/staf/";

// Pastikan folder staf ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Logika Tambah Data Staf
if (isset($_POST['add_staf'])) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $kategori = $_POST['kategori'];
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0;

    $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar.'); window.location.href = 'admin.php?page=manage_staf';</script>";
        $uploadOk = 0;
    }
    
    // Cek ukuran file (maks 5MB)
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar.'); window.location.href = 'admin.php?page=manage_staf';</script>";
        $uploadOk = 0;
    }

    // Izinkan format tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.'); window.location.href = 'admin.php?page=manage_staf';</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO staf (nama, nip, jabatan, kategori, gambar_path, is_pinned) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $nama, $nip, $jabatan, $kategori, $target_file, $is_pinned);
            $stmt->execute();
            echo "<script>alert('Data staf berhasil ditambahkan.'); window.location.href = 'admin.php?page=manage_staf';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file.'); window.location.href = 'admin.php?page=manage_staf';</script>";
        }
    }
}

// Logika Edit Data Staf
if (isset($_POST['edit_staf'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $kategori = $_POST['kategori'];
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0;
    
    // Cek apakah ada file gambar baru diupload
    if ($_FILES["gambar"]["name"]) {
        // Logika upload gambar baru
        $file_name = uniqid() . '-' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek gambar lama untuk dihapus
        $stmt_old = $conn->prepare("SELECT gambar_path FROM staf WHERE id = ?");
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        $row_old = $result_old->fetch_assoc();
        if ($row_old && file_exists($row_old['gambar_path'])) {
            unlink($row_old['gambar_path']);
        }
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE staf SET nama = ?, nip = ?, jabatan = ?, kategori = ?, gambar_path = ?, is_pinned = ? WHERE id = ?");
            $stmt->bind_param("sssssii", $nama, $nip, $jabatan, $kategori, $target_file, $is_pinned, $id);
            $stmt->execute();
            echo "<script>alert('Data staf berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_staf';</script>";
        } else {
            echo "<script>alert('Maaf, ada error saat mengupload file baru.'); window.location.href = 'admin.php?page=manage_staf';</script>";
        }

    } else {
        // Jika tidak ada gambar baru, hanya update teks
        $stmt = $conn->prepare("UPDATE staf SET nama = ?, nip = ?, jabatan = ?, kategori = ?, is_pinned = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $nama, $nip, $jabatan, $kategori, $is_pinned, $id);
        $stmt->execute();
        echo "<script>alert('Data staf berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_staf';</script>";
    }
}

// Logika Hapus Data Staf
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT gambar_path FROM staf WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        if (file_exists($row['gambar_path'])) {
            unlink($row['gambar_path']);
        }
        $stmt_delete = $conn->prepare("DELETE FROM staf WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();
        echo "<script>alert('Data staf berhasil dihapus.'); window.location.href = 'admin.php?page=manage_staf';</script>";
    }
}

// Ambil data staf untuk diedit
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM staf WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
}

// Ambil semua data staf
$result = $conn->query("SELECT * FROM staf ORDER BY kategori, nama");
?>

<div class="management-container">
    <h2>Manajemen Data Staf</h2>

    <div class="form-container">
        <h3><?php echo $edit_data ? 'Edit Data Staf' : 'Tambah Data Staf Baru'; ?></h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
            <label for="nama">Nama Staf:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama']) : ''; ?>" required>

            <label for="nip">NIP / NRPTK:</label>
            <input type="text" id="nip" name="nip" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nip']) : ''; ?>">
            
            <label for="jabatan">Jabatan:</label>
            <input type="text" id="jabatan" name="jabatan" value="<?php echo $edit_data ? htmlspecialchars($edit_data['jabatan']) : ''; ?>" required>

            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="kepala_sekolah" <?php echo ($edit_data && $edit_data['kategori'] == 'kepala_sekolah') ? 'selected' : ''; ?>>Kepala Sekolah</option>
                <option value="wakil_kepala_sekolah" <?php echo ($edit_data && $edit_data['kategori'] == 'wakil_kepala_sekolah') ? 'selected' : ''; ?>>Wakil Kepala Sekolah</option>
                <option value="tata_usaha" <?php echo ($edit_data && $edit_data['kategori'] == 'tata_usaha') ? 'selected' : ''; ?>>Tata Usaha</option>
                <option value="laboratorium" <?php echo ($edit_data && $edit_data['kategori'] == 'laboratorium') ? 'selected' : ''; ?>>Laboratorium</option>
                <option value="wali_kelas" <?php echo ($edit_data && $edit_data['kategori'] == 'wali_kelas') ? 'selected' : ''; ?>>Wali Kelas</option>
                <option value="guru_pengajar" <?php echo ($edit_data && $edit_data['kategori'] == 'guru_pengajar') ? 'selected' : ''; ?>>Guru Pengajar</option>
                <option value="pembina_ekstrakurikuler" <?php echo ($edit_data && $edit_data['kategori'] == 'pembina_ekstrakurikuler') ? 'selected' : ''; ?>>Pembina Ekstrakurikuler</option>
            </select>

            <label for="gambar">Pilih Foto:</label>
            <input type="file" id="gambar" name="gambar" <?php echo $edit_data ? '' : 'required'; ?>>
            <?php if ($edit_data && $edit_data['gambar_path']): ?>
                <img src="<?php echo htmlspecialchars($edit_data['gambar_path']); ?>" alt="Foto Staf Saat Ini" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>
            
            <label for="is_pinned">
                <input type="checkbox" id="is_pinned" name="is_pinned" <?php echo ($edit_data && $edit_data['is_pinned']) ? 'checked' : ''; ?>>
                Pin Staf ini (akan selalu muncul di bagian atas)
            </label>

            <button type="submit" name="<?php echo $edit_data ? 'edit_staf' : 'add_staf'; ?>"><?php echo $edit_data ? 'Simpan Perubahan' : 'Tambah Staf'; ?></button>
            <?php if ($edit_data): ?>
                <a href="admin.php?page=manage_staf" class="action-btn">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>NIP / NRPTK</th>
                    <th>Jabatan</th>
                    <th>Kategori</th>
                    <th>Pin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['gambar_path']); ?>" alt="Staf Image" class="thumbnail"></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['nip']); ?></td>
                    <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td><?php echo $row['is_pinned'] ? 'Ya' : 'Tidak'; ?></td>
                    <td>
                        <a href="admin.php?page=manage_staf&action=edit&id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                        <a href="admin.php?page=manage_staf&action=delete&id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus data staf ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
