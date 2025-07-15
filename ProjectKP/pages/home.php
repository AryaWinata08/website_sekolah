<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SMAN 2 SINGKEP</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Navbar horizontal */
        .navbar {
            background: #2c3e50;
            padding: 0;
        }

        .navbar ul {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0;
        }

        .navbar ul li {
            margin: 0 15px;
        }

        .navbar ul li a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 14px 18px;
            font-weight: 500;
            border-radius: 4px 4px 0 0;
            transition: background 0.2s;
        }

        .navbar ul li a:hover,
        .navbar ul li a.active {
            background: #34495e;
        }

        /* Slider */
        .slider-container {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 8px;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slider-img {
            max-width: 100%;
            display: block;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar-logo">
                <img src="../assets/images/logosma.png" alt="Logo SMAN 2 SINGKEP">
            </div>
            <div class="navbar-menu">
                <ul>
                    <li><a href="home.php">Beranda</a></li>
                    <li><a href="berita.php">Berita</a></li>
                    <li><a href="jadwal.php">Jadwal</a></li>
                    <li><a href="ekstrakurikuler.php">Ekstrakurikuler</a></li>
                    <li><a href="prestasi.php">Prestasi</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </nav>
        <h1 class="judul-sekolah">SMAN 2 SINGKEP</h1>
        <div class="slider-container">
            <button class="slider-btn prev" onclick="prevSlide()">&#10094;</button>
            <div class="slider">
                <img class="slider-img" src="../assets/images/SMAN2.jpg" alt="Foto SMAN 2 SINGKEP">
                <img class="slider-img" src="../assets/images/SMAN2_2.jpg" alt="Foto Kegiatan 1">
                <img class="slider-img" src="../assets/images/SMAN2_3.jpg" alt="Foto Kegiatan 2">
            </div>
            <button class="slider-btn next" onclick="nextSlide()">&#10095;</button>
        </div>
    </header>
    <main>
        <section id="profil-sekolah">
            <h2>Profil Sekolah</h2>
            <p>
                SMAN 2 SINGKEP adalah sekolah menengah atas yang berkomitmen untuk memberikan pendidikan berkualitas dan membentuk generasi muda yang berprestasi, berkarakter, dan siap menghadapi tantangan global.
            </p>
        </section>
        <section id="informasi">
            <h2>Informasi Umum</h2>
            <ul>
                <li>Berita dan Pengumuman</li>
                <li>Jadwal Pelajaran</li>
                <li>Ekstrakurikuler</li>
                <li>Prestasi Siswa</li>
                <li>Kontak & Lokasi</li>
            </ul>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> SMAN 2 SINGKEP. All rights reserved.</p>
    </footer>

    <script>
        let currentSlide = 0;

        function showSlide(index) {
            const slides = document.querySelectorAll('.slider-img');
            const totalSlides = slides.length;

            if (index >= totalSlides) {
                currentSlide = 0;
            } else if (index < 0) {
                currentSlide = totalSlides - 1;
            } else {
                currentSlide = index;
            }

            const newTransformValue = -currentSlide * 100;
            document.querySelector('.slider').style.transform = `translateX(${newTransformValue}%)`;
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }
    </script>
</body>
</html>