<?php
session_start();

// Atur waktu habis sesi (dalam detik)
$session_timeout = 600; // 10 menit

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

// Cek waktu terakhir berinteraksi
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Sesi habis, alihkan ke halaman login
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}

// Perbarui waktu terakhir berinteraksi
$_SESSION['last_activity'] = time();

// Menghubungkan ke database
require_once '../db_conn.php';

// Menentukan halaman yang akan dimuat
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
</head>
<body>
    <header>
   <?php include 'navbar.php'; ?>
  </header>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="admin.php?page=manage_slider" class="<?= $page == 'manage_slider' ? 'active' : '' ?>">Manajemen Slider</a></li>
            <li><a href="admin.php?page=manage_students" class="<?= $page == 'manage_students' ? 'active' : '' ?>">Data Siswa</a></li>
            <li><a href="admin.php?page=manage_staf" class="<?= $page == 'manage_staf' ? 'active' : '' ?>">Data Staf</a></li>
            <li><a href="admin.php?page=manage_berita" class="<?= $page == 'manage_berita' ? 'active' : '' ?>">Manajemen Berita</a></li>
            <li><a href="admin.php?page=manage_agenda" class="<?= $page == 'manage_agenda' ? 'active' : '' ?>">Manajemen Agenda</a></li>
            <li><a href="admin.php?page=manage_galeri" class="<?= $page == 'manage_galeri' ? 'active' : '' ?>">Manajemen Galeri</a></li>
            <li><a href="admin.php?page=manage_prestasi" class="<?= $page == 'manage_prestasi' ? 'active' : '' ?>">Manajemen Prestasi</a></li>
            <li><a href="admin.php?page=manage_visi_misi" class="<?= $page == 'manage_visi_misi' ? 'active' : '' ?>">Manajemen Visi & Misi</a></li>
            <li><a href="admin.php?page=manage_ekstrakurikuler" class="<?= $page == 'manage_ekstrakurikuler' ? 'active' : '' ?>">Manajemen Ekstrakurikuler</a></li>
            <li><a href="admin.php?page=manage_kontak" class="<?= $page == 'manage_kontak' ? 'active' : '' ?>">Manajemen Pesan Kontak</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="content">
        <?php
        switch($page) {
            case 'dashboard':
                echo '<h1>Dashboard Admin</h1>';
                break;
            case 'manage_slider':
                include 'manage_slider.php';
                break;
            case 'manage_students':
                include 'manage_students.php';
                break;
            case 'manage_staf':
                include 'manage_staf.php';
                break;
            case 'manage_berita':
                include 'manage_berita.php';
                break;
            case 'manage_agenda':
                include 'manage_agenda.php';
                break;
            case 'manage_galeri':
                include 'manage_galeri.php';
                break;
            case 'manage_prestasi':
                include 'manage_prestasi.php';
                break;
            case 'manage_visi_misi':
                include 'manage_visi_misi.php';
                break;
            case 'manage_ekstrakurikuler':
                include 'manage_ekstrakurikuler.php';
                break;
            case 'manage_kontak':
                include 'manage_kontak.php';
                break;
            default:
                echo '<h1>Selamat Datang di Dashboard Admin</h1>';
                echo '<p>Pilih menu di samping untuk mulai mengelola konten website.</p>';
                break;
        }
        ?>
    </div>
</body>
</html>
