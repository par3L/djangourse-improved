<?php

require '../../utils/database/helper.php';

session_start();

if (!isset($_GET['id']) && !isset($_GET['lesson'])) {
    echo 'ID harus dilampirkan';
    die;
}

$studentId = $_SESSION['user']['id'];
$courseId = $_GET['id'];
$lessonId = $_GET['lesson'];

$student = fetch("SELECT coin_balance FROM students WHERE id = $studentId")[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Player</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <style>
    @import url('../style.css');

    body {
        background-image: url('../../assets/img/bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: repeat;
        color: #333;
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

    .back-to-course-detail-button {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
        cursor: pointer;
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

    .course-player {
        display: flex;
        height: 100vh;
        flex-direction: row;
        margin-top: 82px;
        padding-bottom: 250px;
    }

    /* Sidebar styling */
    .sidebar {
        position: fixed;
        height: 100%;
        width: 20%;
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 20px;
        overflow: auto;
    }

    .sidebar h2 {
        margin-bottom: 20px;
        font-size: 24px;
        text-align: center;
    }

    .course-list {
        list-style: none;
    }

    .course-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-left: 16px;
        padding-right: 16px;
    }

    .course-list li iconify-icon {
        margin-left: 10px;
        color: green;
        font-size: 24px;
    }

    .course-list a {
        text-decoration: none;
        color: #ecf0f1;
        font-size: 18px;
        display: block;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .course-list li:hover {
        background-color: #34495e;
    }

    .course-list li.active {
        background-color: #34495e;
    }

    /* Video Section Styling */
    .video-section {
        margin-left: 20%;
        width: 80%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-x: hidden;
    }

    .video-controls {
        margin-top: 15px;
    }

    button {
        /* background-color: #2c3e50; */
        /* color: #ecf0f1; */
        background-color: transparent;
        color: white;
        border: none;
        padding: 10px 15px;
        margin: 0 5px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #34495e;
    }

    .next-button-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        width: 80%;
        text-align: right;
        margin-top: 16px;
        position: fixed;
        background-color: #005955;
        bottom: 0;
        right: 0;
        padding: 16px;
        margin-left: 100%;
    }

    .next-button-container button {
        display: flex;
        gap: 8px;
    }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="course-detail.php?id=<?= $courseId ?>" class="back-to-course-detail-button">
        <iconify-icon icon="ep:back"></iconify-icon>
        <p>Kembali ke Detail Kursus</p>
        </a>
        <img src="../../assets/img/logo-django.png" alt="Logo" class="logo" style="  width: 110px; ">
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

    <div class="course-player">
        <div class="sidebar">
            <h2>Modul Kursus</h2>
            <ul class="course-list">
                <li class="active">
                    <a href="#" data-video="assets/videos/lesson1.mp4">Lesson 1: Introduction</a>
                    <iconify-icon icon="lets-icons:check-fill"></iconify-icon>
                </li>
                <li><a href="#" data-video="assets/videos/lesson2.mp4">Lesson 2: Basics</a></li>
                <li><a href="#" data-video="assets/videos/lesson3.mp4">Lesson 3: Advanced Topics</a></li>
            </ul>
        </div>

        <div class="video-section">
            <iframe width="100%" height="100%"
                src="https://www.youtube.com/embed/NBZ9Ro6UKV8?si=Qjuuv5c-2EtEcQxs?autoplay=1&mute=1"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <div class="next-button-container">
                <p></p>
                <p>Lesson 1: Introduction</p>
                <a href="">
                <button>
                    <span>Selanjutnya</span>
                    <iconify-icon style="border: 1px solid #fff; border-radius: 50%" icon="ic:round-navigate-next" id="btn-next-lesson"></iconify-icon>
                </button>
                </a>
                
            </div>
        </div>
    </div>
    <script src="../../navbar.js"></script>
    <script>
    // Select video element and buttons
    const video = document.getElementById("courseVideo");
    const playPauseBtn = document.getElementById("playPauseBtn");
    const restartBtn = document.getElementById("restartBtn");

    // Sidebar navigation links
    const courseLinks = document.querySelectorAll(".course-list a");

    // Change video source on sidebar click
    courseLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const videoSrc = link.getAttribute("data-video");
            video.querySelector("source").src = videoSrc;
            video.load();
            video.play();
            playPauseBtn.textContent = "Pause";
        });
    });
    </script>
</body>

</html>