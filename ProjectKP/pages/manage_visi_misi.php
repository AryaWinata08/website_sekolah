<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Logika untuk menyimpan perubahan
if (isset($_POST['save_visi_misi'])) {
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];

    $stmt = $conn->prepare("UPDATE visi_misi SET visi = ?, misi = ? WHERE id = 1");
    $stmt->bind_param("ss", $visi, $misi);
    $stmt->execute();
    echo "<script>alert('Visi dan Misi berhasil diperbarui.');</script>";
}

// Ambil data visi dan misi dari database
$result = $conn->query("SELECT * FROM visi_misi WHERE id = 1");
$data = $result->fetch_assoc();
?>

<div class="management-container">
    <h2>Manajemen Visi & Misi</h2>

    <div class="form-container">
        <h3>Edit Visi dan Misi Sekolah</h3>
        <form method="post">
            <label for="visi">Visi:</label>
            <textarea id="visi" name="visi" rows="3" required><?php echo htmlspecialchars($data['visi']); ?></textarea>
            
            <label for="misi">Misi:</label>
            <textarea id="misi" name="misi" rows="10" required><?php echo htmlspecialchars($data['misi']); ?></textarea>
            
            <button type="submit" name="save_visi_misi">Simpan Perubahan</button>
        </form>
    </div>
</div>
