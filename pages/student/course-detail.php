<?php

require '../../utils/database/helper.php';
require '../../utils/date.php';

session_start();

if (isset($_SESSION["login"])) {
    $student_id = $_SESSION['user']['id'];

    if ($_SESSION['user']['role_id'] == 1) {
        $student = fetch("SELECT coin_balance FROM students WHERE id=$student_id")[0];
    }

    if ($_SESSION['user']['role_id'] == 3) {
        header('Location: pages/admin/views/dashboard.php');
        die;
    }
}

if (!isset($_GET['id'])) {
    echo "ID kursus harus dilampirkan.";
    die;
}

$courseId = $_GET['id'];
$course = fetch("SELECT * FROM courses WHERE id = $courseId");
$enrolledCourse = fetch("SELECT * FROM enrolled_courses WHERE student_id = $student_id AND course_id = $courseId");
$courseMaterials = fetch("SELECT * FROM course_materials WHERE course_id = $courseId");
$courseToolGalleries = fetch(
    "SELECT * FROM course_tool_galleries
    JOIN courses ON course_tool_galleries.course_id = courses.id
    JOIN course_tools ON course_tool_galleries.tool_id = course_tools.id
    WHERE course_tool_galleries.course_id = $courseId");

if ($course) {
    $course = $course[0];
    $instructorId = $course['instructor_id'];
} else {
    echo "Kursus tidak ditemukan.";
    die;
}

if (isset($_POST['buy-course'])) {
    if ($student['coin_balance'] >= ($course['price'] / 1000)) {
        $coursePrice = $course['price'];
        beginTransaction();
            execDML("INSERT INTO transactions (student_id, course_id, price) VALUES ($student_id, $courseId, $coursePrice)");
            execDML("UPDATE students SET coin_balance = coin_balance - ($coursePrice / 1000) WHERE id = $student_id");
            execDML("UPDATE instructors SET balance = balance + ($coursePrice*1000) WHERE id = $instructorId");
            execDML("INSERT INTO enrolled_courses (student_id, course_id) VALUES ($student_id, $courseId)");
        commitTransaction();
        header("Location: course-detail.php?id=$courseId");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Tentang Kelas dan Tools Kelas</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <style>
    /* Global Styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "Poppins", sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header Styling */
    .header {
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 64px;
        background-color: #245044;
        height: 100px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .logo {
        max-width: 120px;
        height: auto;
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
        gap: 30px;
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


    .style-daftar,
    .style-masuk {
        border: none;
        border-radius: 50px;
        padding: 10px 24px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .auth-buttons button {
        margin-left: 10px;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .auth-buttons .style-daftar {
        background-color: #128e8c;
        color: #FFFFFF;
        padding: 0.5rem 1rem;
    }

    .auth-buttons .style-daftar:hover {
        background-color: #fff;
        transform: scale(1.05);
        color: #15A3A1;
    }

    .auth-buttons .style-masuk {
        background-color: #245044;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .auth-buttons .style-masuk:hover {
        background-color: #fff;
        color: #15A3A1;
        transform: scale(1.05);
    }

    /* Hamburger Menu Icon */
    .hamburger {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        z-index: 10000;
    }

    .hamburger div {
        width: 30px;
        height: 3px;
        background: #ffffff;
        border-radius: 3px;
        transition: all 0.3s ease-in-out;
    }

    .hamburger.active div:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .hamburger.active div:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active div:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }

    /* Sliding Menu */
    .menu-collapsed {
        position: fixed;
        top: 0;
        left: -300px;
        width: 300px;
        height: 100vh;
        background-color: #245044;
        display: flex;
        flex-direction: column;
        padding: 20px;
        box-shadow: -2px 0px 10px rgba(0, 0, 0, 0.1);
        gap: 16px;
        transition: left 0.3s ease-in-out;
    }

    .menu-collapsed.active {
        left: 0;
    }

    .menu {
        display: flex;
        gap: 32px;
    }

    .menu-item {
        color: #ffffff;
        text-decoration: none;
        font-size: 16px;
        font-weight: 400;
        transition: color 0.3s ease;
    }

    .menu-item:hover {
        color: #d6e4f8;
    }

    /* Authentication Buttons */
    .auth-buttons {
        display: flex;
        gap: 16px;
    }

    .style-daftar,
    .style-masuk {
        border: none;
        border-radius: 50px;
        padding: 10px 24px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .style-daftar {
        background: #eff3fd;
        color: #245044;
    }

    .style-daftar:hover {
        background: #d6e4f8;
    }

    .style-masuk {
        background: #15a3a1;
        color: #ffffff;
    }

    .style-masuk:hover {
        background: #128e8c;
    }

    /* Content Section */
    .isi-content {
        background-image: url("../../assets/img/bg.png");
        background-size: cover;
        background-position: center;
        background-repeat: repeat;
        min-height: 100vh;
    }


    .description {
        margin-top: 80px;
        text-align: center;
        padding: 20px;
        border-radius: 10px;
    }

    .description h1 {
        font-size: 48px;
        color: #245044;
        line-height: 150%;
        letter-spacing: -0.02em;
        font-weight: 600;
        margin-top: 40px;
    }

    .description p {
        font-size: 18px;
        line-height: 29px;
        letter-spacing: 0.15px;
        font-weight: 500;
        font-family: "Poppins", sans-serif;
        color: rgba(0, 0, 0, 0.95);
    }

    .description .info {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }

    .description .info div {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #000000;
    }

    .description .info i {
        font-size: 18px;
    }

    .content {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .content .left {
        flex: 1;
        background: #245044;
        padding: 20px;
        border-radius: 10px;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }

    .content .left img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .content .left p {
        margin-top: 20px;
        font-size: 16px;
        line-height: 29px;
        text-align: left;
    }

    .content .right {
        flex: 1;
        background-color: transparent;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 2px solid #d9d9d9;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .content .right ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .content .right ul li {
        display: flex;
        flex-direction: column;
        padding: 4px 5px;
        margin-bottom: 10px;
        border-radius: 8px;
        background: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-size: 14px;
    }

    .content .right ul li i {
        margin-right: 10px;
        color: #4a7c59;
        flex-shrink: 0;
    }

    .content .right ul li span {
        font-weight: 500;
        font-size: 14px;
        color: #79747e;
    }

    .content .right ul li .title-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        padding: 5px;
    }

    .content .right ul li .title-wrapper:hover {
        background: #e8f6ef;
        border-radius: 5px;
    }

    .content .right ul li .content {
        display: none;
        margin-top: 10px;
        font-size: 14px;
        color: #4a7c59;
    }

    .content .right .button {
        text-align: center;
    }

    .content .right ul li.active .content {
        display: block;
    }


    .content .right .button button {
        width: 100%;
        color: #fffcfc;
        background-color: #245044;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .content .right .button button:hover {
        background-color: #4a7c59;
    }

    .content .right .button button.disabled {
        background-color: #ccc;
        cursor: not-allowed;
        box-shadow: none;
    }

    .button-lanjut button {
        background-color: #2c8577;
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 30px;
        margin-top: 20px;
        border: none;
        cursor: pointer;
    }

    .button-lanjut button.active {
        background-color: #ef991f;
        color: #ffffff;
    }

    .button-lanjut button:hover {
        background-color: #ef991f;
        color: #ffffff;
    }

    .penggunaan p {
        font-size: 20px;
        letter-spacing: 0.15px;
        font-weight: 500;
        margin-top: 20px;
        text-align: left;
    }

    .penggunaan,
    .alat {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .alat {
        display: none;
    }

    .alat .item {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(2, 300px);
        justify-content: left;
        margin-top: 20px;
    }

    .card {
        width: 300px;
        height: 100px;
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card img {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .card-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .card-content span:first-child {
        font-size: 16px;
        font-weight: 600;
        color: #245044;
    }

    .card-content span:last-child {
        font-size: 14px;
        font-weight: 400;
        color: #79747e;
    }

    footer {
        background-image: url('../../assets/img/bg-footer.png');
        background-size: cover;
        background-position: center;
        color: #fff;
        padding: 2rem 4rem;
        display: flex;
        justify-content: space-between;
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

    /* footer end */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        position: relative;
    }

    /* Styling untuk modal */
    .modal-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Konten modal */
    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }

    /* Pesan konfirmasi */
    #confirmationMessage {
        font-size: 18px;
        margin-bottom: 20px;
        color: #333;
    }

    /* Tombol */
    .modal-content button {
        padding: 7px 10px;
        font-size: 16px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 10px;
    }

    /* Tombol 'Ya' */
    #yesButton {
        background-color: #245044;
        color: #fff;
        border: 1px solid #3E5A5A;
    }

    #yesButton:hover {
        background-color: #005955;
    }

    /* Tombol 'Tidak' */
    #noButton {
        background-color: transparent;
        color: #245044;
        border: 1px solid #245044;
    }

    #noButton:hover {
        background-color: #245044;
        color: #fff;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
        .isi-content {
            background-size: contain;
        }

        .content {
            flex-direction: column;
        }

        .content .left,
        .content .right {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <header>
        <div class="navbar">
            <img src="../../assets/img/logo-django.png" alt="Logo" class="logo" style="  width: 110px; ">
            <nav>
                <ul>
                    <li><a href="../../index.php">Beranda</a></li>
                    <li><a href="course-list.php">Kursus</a></li>
                    <li><a href="../how-to-use.php">Cara Penggunaan</a></li>
                </ul>
            </nav>
            <?php if (isset($_SESSION['login'])): ?>
            <div class="navbar-info">
                <p>Hai, <?= $_SESSION['user']['name'] ?></p>
                <iconify-icon icon="iconamoon:arrow-down-2-bold" id="btn-dropdown"></iconify-icon>
                <?php if ($_SESSION['user']['role_id'] == 1): ?>
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
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="uil:setting"></iconify-icon>
                            <span>Pengaturan</span>
                        </div>
                    </a>
                    <a href="../logout.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="material-symbols:logout" class="sidebar-icon"></iconify-icon>
                            <span>Keluar</span>
                        </div>
                    </a>
                </div>
                <?php elseif ($_SESSION['user']['role_id'] == 2): ?>
                <div class="navbar-info-dropdown hide" id="navbar-info-dropdown">
                    <a href="../instructor/dashboard.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                            <span>Dasbor</span>
                        </div>
                    </a>
                    <a href="../logout.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="material-symbols:logout" class="sidebar-icon"></iconify-icon>
                            <span>Keluar</span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <?php else: ?>
            <div class="auth-buttons">
                <button class="style-daftar" onclick="location.href='pages/auth.php'">Daftar</button>
                <button class="style-masuk" onclick="location.href='pages/auth.php'">Masuk</button>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- DESCRIPTION SECTION -->
    <div class="isi-content">
        <div class="description">
            <h1><?= $course['name'] ?></h1>
            <p>Belajar Struktur Dasar dari Sebuah Website</p>
            <div class="info">
                <div><i class="fas fa-signal"></i> Tingkat Kesulitan: <?= $course['level'] ?></div>
                <div><i class="fas fa-calendar-alt"></i> Dipublikasi: <?= convertToWita($course['created_at']) ?></div>
            </div>
        </div>

        <!-- CONTENT SECTION -->
        <div class="container">
            <div class="content">
                <div class="left">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/NBZ9Ro6UKV8?si=Qjuuv5c-2EtEcQxs"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sem magna, gravida eu eros in,
                        fermentum vulputate sem. Quisque at ipsum pretium, ullamcorper tellus non, feugiat eros. Nunc
                        euismod
                        mauris ipsum.
                    </p>
                </div>

                <!-- Right Section -->
                <div class="right">
                    <ul>
                        <?php foreach ($courseMaterials as $courseMaterial): ?>
                        <li>
                            <div class="title-wrapper" onclick="toggleContent(this)">
                                <div>
                                    <i class="fas fa-play-circle"></i>
                                    <span><?= $courseMaterial['title'] ?></span>
                                </div>
                                <span>5 Menit</span>
                            </div>
                            <div class="content">Penjelasan detail tentang Sejarah HTML.</div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="button">
                        <?php if ($_SESSION['user']['role_id'] == 1): ?>
                        <?php if (empty($enrolledCourse)): ?>
                        <button onclick="<?= ($student['coin_balance'] >= ($course['price'] / 1000)) ? 'showConfirmation()' : 'showErrorModal()' ?>">Gabung Kursus</button>
                        <?php else: ?>
                        <a href="course-player.php?id=<?= $courseId ?>"><button>Masuk ke Dasbor Kursus</button></a>
                        <?php endif; ?>
                        <?php else: ?>
                        <button class="disabled" disabled>Silakan Masuk sebagai Siswa untuk Membeli Kursus</button></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="button-lanjut">
                <button class="active" onclick="showContent('penggunaan')">Tentang Kelas</button>
                <button onclick="showContent('alat')">Alat</button>
            </div>
            <div class="penggunaan" id="penggunaan">
                <p><?= $course['description'] ?></p>
            </div>
            <div class="alat" id="alat">
                <div class="item">
                    <?php foreach ($courseToolGalleries as $courseToolGallery): ?>
                    <div class="card">
                        <img src="assets/<?= $courseToolGallery['logo'] ?>" alt="Visual Studio Code">
                        <div class="card-content">
                            <span><?= $courseToolGallery['name'] ?></span>
                            <span><?= $courseToolGallery['type'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-container" id="confirmationModal" style="display: none;">
        <div class="modal-content">
            <p id="confirmationMessage"></p>
            <form method="POST" id="confirmationForm">
                <input type="hidden" name="buy-course" id="buy-course">
                <button type="submit" id="yesButton">Gabung</button>
                <button type="button" id="noButton" onclick="closeModal('confirmationModal')">Tidak Jadi</button>
            </form>
        </div>
    </div>

    <div class="modal-container" id="errorModal" style="display: none;">
        <div class="modal-content">
            <p id="errorMessage"></p>
                <button type="button" id="noButton" onclick="closeModal('errorModal')">Oke</button>
        </div>
    </div>

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
    function toggleContent(element) {
        const parent = element.parentElement;
        parent.classList.toggle('active');
    }

    function toggleMenu() {
        const hamburger = document.getElementById('hamburger');
        const menu = document.getElementById('menu-collapsed');
        hamburger.classList.toggle('active');
        menu.classList.toggle('active');
    }

    function showContent(section) {

        document.getElementById('penggunaan').style.display = 'none';
        document.getElementById('alat').style.display = 'none';

        document.getElementById(section).style.display = 'block';
        if (section == 'penggunaan') {
            document.querySelector('.button-lanjut button:nth-child(2)').classList.remove('active');
            document.querySelector('.button-lanjut button:nth-child(1)').classList.add('active');
        } else {
            document.querySelector('.button-lanjut button:nth-child(1)').classList.remove('active');
            document.querySelector('.button-lanjut button:nth-child(2)').classList.add('active');
        }
    }

    // modal confirmation
    function showConfirmation() {
        const confirmationMessage = `Yakin bergabung dalam kelas ini?`;
        document.getElementById("confirmationMessage").textContent = confirmationMessage;

        // Tampilkan modal
        document.getElementById("confirmationModal").style.display = "flex";
    }

    function closeModal(id) {
        document.getElementById(id).style.display = "none";
    }

    function showErrorModal() {
        const errorMessage = `Koin yang Anda miliki tidak cukup untuk membeli kelas ini.`;
        document.getElementById("errorMessage").textContent = errorMessage;

        // Tampilkan modal
        document.getElementById("errorModal").style.display = "flex";
    }

    function closeSuccessMessage() {
        const message = document.getElementById("successMessage");
        if (message) {
            message.style.display = "none";
        }
    }
    // modal confirmation end
    </script>
    <script src="../../navbar.js"></script>
</body>

</html>