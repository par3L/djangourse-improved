<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penggunaan Website</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="how-to-use.css">
</head>

<body>
    <header>
        <div class="navbar">
            <img src="../assets/img/logo-django.png" alt="Logo" class="logo" style="  width: 110px; ">
            <nav>
                <ul>
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="student/course-list.php">Kursus</a></li>
                    <li><a href="how-to-use.php">Cara Penggunaan</a></li>
                </ul>
            </nav>
            <?php if (isset($_SESSION['login'])): ?>
            <div class="navbar-info">
                <p>Hai, <?= $_SESSION['user']['name'] ?></p>
                <iconify-icon icon="iconamoon:arrow-down-2-bold" id="btn-dropdown"></iconify-icon>
                <p>0 Koin</p>
                <div class="navbar-info-dropdown hide" id="navbar-info-dropdown">
                    <a href="../student/kursus-course.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                            <span>Profil</span>
                        </div>
                    </a>
                    <a href="../student/favourite-course.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="weui:like-filled"></iconify-icon>
                            <span>Wishlist</span>
                        </div>

                    </a>
                    <a href="../siswa/pengaturan_profil.php">
                        <div class=" navbar-info-dropdown-content">
                            <iconify-icon icon="uil:setting"></iconify-icon>
                            <span>Pengaturan</span>
                        </div>
                    </a>
                    <a href="../auth.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="material-symbols:logout" class="sidebar-icon"></iconify-icon>
                            <span>Keluar</span>
                        </div>
                    </a>
                </div>
            </div>

            <?php else: ?>
            <div class="auth-buttons">
                <button class="style-daftar" onclick="location.href='../auth.php'">Daftar</button>
                <button class="style-masuk" onclick="location.href='../auth.php'">Masuk</button>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <div class="content">
            <h1 class="main-title">Cara Penggunaan Website</h1>
            <p class="subtitle">Berikut adalah tata cara penggunaan Djangourse</p>

            <section class="steps">
                <div class="step">
                    <h2>Langkah 1: Daftar atau Masuk</h2>
                    <img src="https://via.placeholder.com/200x150?text=Cara" alt="Langkah 1" class="step-image">
                    <p style="color: white;">
                        Anda perlu mendaftar terlebih dahulu ketika ingin menikmati layanan dari Djangourse.
                        Klik tombol Daftar atau Masuk yang berada di bagian navigation bar. Lalu isi informasi
                        yang sesuai ketentuan.
                    </p>
                </div>

                <div class="step">
                    <h2>Langkah 2: Eksplorasi</h2>
                    <img src="https://via.placeholder.com/200x150?text=Cara" alt="Langkah 2" class="step-image">
                    <p style="color: white;">
                        Setelah mendaftar, Anda dapat memilih untuk membeli kursus menggunakan koin atau belajar dengan
                        kursus
                        gratis di website kami. Koin dapat diisi melalui laman Saldo.
                    </p>
                </div>
        </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="../assets/img/logo-django.png" alt="Logo" class="footer-logo">
                <p>Bergabunglah bersama kami untuk menguasai<br> berbagai keahlian
                    dibidang teknologi dan membuka<br>peluang karier di dunia teknologi
                    yang terus berkembang.<br><br> Kami menyediakan kursus
                    berkualitas yang membantu <br> kamu berkembang dari pemula
                    hingga ahli.</p>
                <div class="hak-cipta">
                    <p>© 2024 Django Course. Semua hak cipta dilindungi.</p>
                </div>
            </div>
            <div class="links-section">
                <h3>Instruktur</h3>
                <ul>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Register</a></li>
                    <li><a href="#">Instructor</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
            <div class="links-section">
                <h3>Siswa</h3>
                <ul>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">Jelajahi Kursus</a></li>
                    <li><a href="#">Wishlist Kursus</a></li>
                    <li><a href="#">Student</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
            <div class="contact-section">
                <h3>Alamat</h3>
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    <a href="https://www.google.com/maps?q=Jalan+Gubeng+Surabaya" target="_blank">Jalan Gubeng,
                        Surabaya</a>
                </p>
                <p>
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:info@dingcourse.com">info@dingcourse.com</a>
                </p>
                <p>
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:+62123456789">+62 123 456 789</a>
                </p>
            </div>
        </div>
    </footer>
    <script>
    document.getElementById('btn-dropdown').addEventListener('click', () => {
        console.log('click')
        document.getElementById('navbar-info-dropdown').classList.toggle('hide')
    })
    </script>
</body>

</html>