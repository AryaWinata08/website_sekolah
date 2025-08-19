    <?php
    // Jangan lupa sesuaikan path file koneksi jika perlu
    require_once '../db_conn.php';

    // Kata sandi yang ingin Anda gunakan
    $password_baru = '12345';

    // Enkripsi kata sandi menggunakan BCRYPT
    $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);

    // Perbarui kata sandi di database
    $stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE id = 1");
    $stmt->bind_param("s", $hashed_password);

    if ($stmt->execute()) {
        echo "Kata sandi admin berhasil diperbarui menjadi: " . $password_baru;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    ?>
    