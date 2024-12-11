<?php

require '../../utils/database/helper.php';
require '../../utils/date.php';

session_start();

// Pastikan pengguna sudah login
if (isset($_SESSION['login'])) {
    if ($_SESSION['user']['role_id'] == 3) {
        header('Location: pages/admin/views/dashboard.php');
    }
}

$userName = htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8');

$studentId = $_SESSION['user']['id'];
$student = fetch("SELECT * FROM students WHERE id=$studentId")[0];

$certificates = fetch(
    "SELECT courses.name AS course_name, enrolled_courses.finished_at FROM enrolled_courses
    JOIN courses ON enrolled_courses.course_id = courses.id
    WHERE enrolled_courses.student_id=$studentId AND enrolled_courses.finished_at IS NOT NULL"
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Sertifikat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
</head>
<style>
*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: "poppins", sans-serif;
    margin: 0;
    background-color: #f5f5f5;
    line-height: 1.6;
}

.navbar {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 4rem;
    background-color: #245044;
}

.navbar ul {
    display: flex;
    list-style: none;
}

.navbar ul li {
    margin-left: 20px;
}

.navbar a {
    text-decoration: none;
    color: #fff;
    transition: color 0.3s ease, border-bottom 0.3s ease;
}

.navbar a:hover {
    color: #A1D1B6;
    border-bottom: 2px solid #A1D1B6;
}

.navbar-info {
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
}

.navbar-info-dropdown {
    position: absolute;
    top: 80px;
    right: 48px;
    width: 220px;
    display: block;
    padding: 16px;
    background-color: #005955;
}

.hide {
    display: none;
}


.navbar-info-dropdown a {
    display: block;
    padding: 16px;
}

.navbar-info-dropdown iconify-icon {
    font-size: 24px;
}

.navbar-info-dropdown .navbar-info-dropdown-content {
    display: flex;
    gap: 16px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #2b4e4e;
    padding: 20px;
    color: #ffffff;
}

header .logo img {
    width: 100px;
}

header nav a {
    margin: 0 15px;
    color: #ffffff;
    text-decoration: none;
}

header .user-info {
    display: flex;
    align-items: center;
}

header .user-info img {
    margin-left: 10px;
    width: 20px;
}

/* Profile Section */
.profil {
    background-color: #f4f4f4;
    background-image: url('./assets/bgsiswa.png');
    background-size: cover;
    background-position: center;
    padding: 150px 60px 90px;
    text-align: center;
    color: white;
}

.profile-container {
    display: flex;
    align-items: center;
    padding: 20px 70px;
}

.profile-container img {
    width: 150px;
}

.profile-picture {
    margin-right: 15px;
    width: 150px;
}

.profile-name {
    color: #FFFFFF;
    margin: 0;
    font-size: 37px;
    letter-spacing: 0.5px;
    font-weight: 500;
    margin-left: 32px;
}

.tabs-section {
    display: flex;
    margin-top: 32px;
    gap: 20px;
    margin-left: 7.5rem;
}

.tab {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background-color: #e0e0e0;
    border-radius: 20px;
    text-decoration: none;
    color: rgb(0, 0, 0);
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.tab.active {
    background-color: #2b4e4e;
    color: white;
}

.tab:hover {
    color: white;
    background-color: #2b4e4e;
}

.tab.active:hover {
    color: white;
    background-color: #2b4e4e;
}


.certificates-section {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

.certificate-card {
    background-color: #d9e6e6;
    padding: 20px;
    width: 221px;
    text-align: center;
    border-radius: 0px;
}

.certificate-card h3 {
    margin-bottom: 10px;
}

.certificate-card p {
    font-size: 1rem;
    margin: 5px 0;
}

.certificate-card img {
    max-width: 100px;
    height: auto;
    margin-top: 10px;
    padding-bottom: 15px;
}

.courses-container {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 25px;
    padding-bottom: 50px;
    max-width: 1200px;
    margin: 0 auto;
}

.course-card {
    background: #DEE5ED;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 15px;
    height: 350px;
    text-align: center;
}

.course-card img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

.course-card h3 {
    font-size: 16px;
    font-weight: 600;
    margin-top: 5px;
    margin-bottom: 30px;
    color: #333;
}

.progress-bar {
    background-color: #e0e0e0;
    border-radius: 10px;
    overflow: hidden;
    margin: 20px 0;
    height: 8px;
    position: relative;
}

.progress-bar .progress {
    background-color: #1abc9c;
    height: 100%;
    width: 78%;
}

.progress-percentage {
    font-size: 14px;
    font-weight: 500;
    color: #333;
    text-align: right;
}

footer {
    background-image: url('../../assets/img/footer.png');
    background-size: cover;
    background-position: center;
    color: #fff;
    padding: 2rem 4rem;
    display: flex;
    justify-content: space-between;
    margin-top: 32px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.footer-content .logo-section p {
    padding-left: 10px;
    margin-top: 10px;
}

.footer-logo {
    width: 100px;
}

.links-section a {
    text-decoration: none;
    color: #fff;
    transition: color 0.3s ease, border-bottom 0.3s ease;
}

.links-section a:hover {
    color: #A1D1B6;
    border-bottom: 2px solid #A1D1B6;
}

.links-section ul {
    list-style: none;
    margin-top: 20px;
    padding-left: 0;
}

.links-section ul li {
    margin: 20px 0;
}

.contact-section p {
    margin: 20px 0;
}

.contact-section i {
    margin-right: 5px;
}

.contact-section a {
    text-decoration: none;
    color: #fff;
    transition: color 0.3s ease;
}

.contact-section a:hover {
    color: #A1D1B6;
    text-decoration: underline;
}
</style>

<body>
    <!-- Navbar Section -->
    <header class="navbar">
        <img src="../../assets/img/logo-django.png" alt="Logo" class="logo" style="width: 110px;">
        <nav>
            <ul>
                <li><a href="../../index.php">Beranda</a></li>
                <li><a href="./course-list.php">Kursus</a></li>
                <li><a href="#">Cara Penggunaan</a></li>
            </ul>
        </nav>
        <?php if (isset($_SESSION['login'])): ?>
        <div class="navbar-info">
            <p>Hai, <?= $_SESSION['user']['name'] ?></p>
            <iconify-icon icon="iconamoon:arrow-down-2-bold" id="btn-dropdown"></iconify-icon>
            <a href="coin-dashboard.php"><?= $student['coin_balance'] ?> Koin</a>
            <div class="navbar-info-dropdown hide" id="navbar-info-dropdown">
                <a href="profile.php">
                    <div class="navbar-info-dropdown-content">
                        <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                        <span>Profil</span>
                    </div>
                </a>
                <a href="favourite-course.php">
                    <div class="navbar-info-dropdown-content">
                        <iconify-icon icon="weui:like-filled"></iconify-icon>
                        <span>Wishlist</span>
                    </div>
                </a>
                <a href="setting.php">
                    <div class=" navbar-info-dropdown-content">
                        <iconify-icon icon="uil:setting"></iconify-icon>
                        <span>Pengaturan</span>
                    </div>
                </a>
                <a href="pages/logout.php">
                    <div class="navbar-info-dropdown-content">
                        <iconify-icon icon="material-symbols:logout" class="sidebar-icon"></iconify-icon>
                        <span>Keluar</span>
                    </div>
                </a>
            </div>
        </div>
        <?php endif; ?>
    </header>

    <!-- Profile Section -->
    <div class="profil">
        <div class="profile-container">
            <img src="./assets/pictprofil.png" alt="Profile Picture">
            <p class="profile-name"><?= $userName; ?></p>
        </div>
    </div>

    <!-- Tabs Section -->
    <section class="tabs-section">
        <a href="profile.php" class="tab">
            <i class="fa fa-bookmark"></i> Kursus Saya
        </a>
        <a href="profile-certificate.php" class="tab active">
            <i class="fa-solid fa-award"></i> Sertifikat
        </a>
    </section>


    <?php if (!empty($certificates)): ?>
    <!-- sertifikat section  -->
    <section class="certificates-section">
        <?php foreach ($certificates as $certificate): ?>
            <div class="certificate-card">
                <h3>Sertifikat Penyelesaian</h3>
                <p><?= $certificate['course_name'] ?></p>
                <img src="./assets/sertif.png" alt="Certificate Icon">
                <p><?= convertToIndonesianDate($certificate['finished_at']) ?></p>
            </div>
        <?php endforeach; ?>
    </section>
    <?php else: ?>
    <p style="margin-left:7.5rem; margin-top: 16px; font-size: 24px; margin-bottom: 6.5rem">Kamu belum menyelesaikan satu pun kursus.</p>
    <?php endif; ?>
    <footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="../../assets/img/logo-django.png" alt="Logo" class="footer-logo">
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
                    <a href="mailto:info@djangourse.com">info@dingcourse.com</a>
                </p>
                <p>
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:+62123456789">+62 123 456 789</a>
                </p>
            </div>

        </div>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnDropdown = document.getElementById('btn-dropdown');
        const dropdown = document.getElementById('navbar-info-dropdown');

        if (btnDropdown) {
            btnDropdown.addEventListener('click', function() {
                dropdown.classList.toggle('hide');
            });
        }
    });
    </script>
</body>

</html>