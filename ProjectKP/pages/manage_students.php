<?php
// Pastikan admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once '../db_conn.php';

// Logika untuk Tambah/Edit Data Siswa (berdasarkan total jumlah)
if (isset($_POST['save_student_counts'])) {
    $kelas = $_POST['kelas'];
    $jumlah_laki = (int)$_POST['jumlah_laki_laki'];
    $jumlah_perempuan = (int)$_POST['jumlah_perempuan'];
    $jumlah_islam = (int)$_POST['jumlah_islam'];
    $jumlah_kristen = (int)$_POST['jumlah_kristen'];
    $jumlah_katolik = (int)$_POST['jumlah_katolik'];
    $jumlah_buddha = (int)$_POST['jumlah_buddha'];

    // Validasi sederhana: Total jenis kelamin harus sama dengan total agama
    if (($jumlah_laki + $jumlah_perempuan) !== ($jumlah_islam + $jumlah_kristen + $jumlah_katolik + $jumlah_buddha)) {
        echo "<script>alert('Error: Total jenis kelamin tidak sama dengan total agama. Data tidak disimpan.'); window.location.href = 'admin.php?page=manage_students';</script>";
    } else {
        // Hapus data siswa yang lama untuk kelas ini
        $stmt_delete = $conn->prepare("DELETE FROM siswa WHERE kelas = ?");
        $stmt_delete->bind_param("s", $kelas);
        $stmt_delete->execute();

        // Siapkan data untuk dimasukkan
        $insert_data = [];

        // Masukkan data laki-laki
        for ($i = 0; $i < $jumlah_laki; $i++) {
            $insert_data[] = ['nama' => "Siswa-Laki-laki-" . ($i + 1), 'jenis_kelamin' => 'Laki-laki'];
        }

        // Masukkan data perempuan
        for ($i = 0; $i < $jumlah_perempuan; $i++) {
            $insert_data[] = ['nama' => "Siswa-Perempuan-" . ($i + 1), 'jenis_kelamin' => 'Perempuan'];
        }

        // Distribusikan agama secara acak/berurutan
        $agama_counts = ['Islam' => $jumlah_islam, 'Kristen' => $jumlah_kristen, 'Katolik' => $jumlah_katolik, 'Buddha' => $jumlah_buddha];
        $current_index = 0;
        foreach ($agama_counts as $agama => $count) {
            for ($i = 0; $i < $count; $i++) {
                if ($current_index < count($insert_data)) {
                    $insert_data[$current_index]['agama'] = $agama;
                    $current_index++;
                }
            }
        }

        // Masukkan data ke database
        $stmt_insert = $conn->prepare("INSERT INTO siswa (nama, kelas, jenis_kelamin, agama) VALUES (?, ?, ?, ?)");
        $kelas_param = $kelas;
        foreach ($insert_data as $student) {
            $stmt_insert->bind_param("ssss", $student['nama'], $kelas_param, $student['jenis_kelamin'], $student['agama']);
            $stmt_insert->execute();
        }

        echo "<script>alert('Data siswa untuk kelas " . htmlspecialchars($kelas) . " berhasil diperbarui.'); window.location.href = 'admin.php?page=manage_students';</script>";
    }
}

// Logika Hapus Data Siswa per Kelas
if (isset($_GET['action']) && $_GET['action'] == 'delete_by_class' && isset($_GET['kelas'])) {
    $kelas = $_GET['kelas'];
    $stmt = $conn->prepare("DELETE FROM siswa WHERE kelas = ?");
    $stmt->bind_param("s", $kelas);
    $stmt->execute();
    echo "<script>alert('Data siswa untuk kelas " . htmlspecialchars($kelas) . " berhasil dihapus.'); window.location.href = 'admin.php?page=manage_students';</script>";
}

// Ambil semua data siswa yang sudah terkelompok
$result_grouped = $conn->query("SELECT kelas, COUNT(CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 END) AS laki_laki, COUNT(CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 END) AS perempuan, COUNT(*) AS total_siswa, COUNT(CASE WHEN agama = 'Islam' THEN 1 END) AS islam, COUNT(CASE WHEN agama = 'Kristen' THEN 1 END) AS kristen, COUNT(CASE WHEN agama = 'Katolik' THEN 1 END) AS katolik, COUNT(CASE WHEN agama = 'Buddha' THEN 1 END) AS buddha FROM siswa GROUP BY kelas ORDER BY kelas");
?>

<div class="management-container">
    <h2>Manajemen Data Peserta Didik</h2>

    <div class="form-container">
        <h3>Kelola Data Siswa Berdasarkan Kelas</h3>
        <form method="post">
            <label for="kelas">Pilih Kelas:</label>
            <select id="kelas" name="kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <?php
                $kelas_list = ['X.A', 'X.B', 'X.C', 'XI.A', 'XI.B', 'XI.C', 'XII MIPA 1', 'XII MIPA 2', 'XII IPS 1', 'XII IPS 2'];
                foreach ($kelas_list as $kelas) {
                    echo "<option value='{$kelas}'>{$kelas}</option>";
                }
                ?>
            </select>
            <hr style="margin: 20px 0;">

            <label for="jumlah_laki_laki">Jumlah Laki-laki:</label>
            <input type="number" id="jumlah_laki_laki" name="jumlah_laki_laki" min="0" required>

            <label for="jumlah_perempuan">Jumlah Perempuan:</label>
            <input type="number" id="jumlah_perempuan" name="jumlah_perempuan" min="0" required>
            <hr style="margin: 20px 0;">
            
            <label for="jumlah_islam">Jumlah Agama Islam:</label>
            <input type="number" id="jumlah_islam" name="jumlah_islam" min="0" required>
            
            <label for="jumlah_kristen">Jumlah Agama Kristen:</label>
            <input type="number" id="jumlah_kristen" name="jumlah_kristen" min="0" required>

            <label for="jumlah_katolik">Jumlah Agama Katolik:</label>
            <input type="number" id="jumlah_katolik" name="jumlah_katolik" min="0" required>

            <label for="jumlah_buddha">Jumlah Agama Buddha:</label>
            <input type="number" id="jumlah_buddha" name="jumlah_buddha" min="0" required>

            <button type="submit" name="save_student_counts">Simpan Data Kelas</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Laki-laki</th>
                    <th>Perempuan</th>
                    <th>Islam</th>
                    <th>Kristen</th>
                    <th>Katolik</th>
                    <th>Buddha</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result_grouped->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                    <td><?php echo htmlspecialchars($row['laki_laki']); ?></td>
                    <td><?php echo htmlspecialchars($row['perempuan']); ?></td>
                    <td><?php echo htmlspecialchars($row['islam']); ?></td>
                    <td><?php echo htmlspecialchars($row['kristen']); ?></td>
                    <td><?php echo htmlspecialchars($row['katolik']); ?></td>
                    <td><?php echo htmlspecialchars($row['buddha']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_siswa']); ?></td>
                    <td>
                        <a href="admin.php?page=manage_students&action=delete_by_class&kelas=<?php echo $row['kelas']; ?>" class="action-btn delete" onclick="return confirm('Yakin ingin menghapus semua data siswa di kelas ini?');">Hapus Kelas</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
