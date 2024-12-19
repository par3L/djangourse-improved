<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['user']['role_id'] != 1) {
    header('Location: ../auth.php');
    exit;
}

require '../../utils/database/helper.php';

$studentId = $_SESSION['user']['id'];

if (!isset($_GET['id'])) {
    echo 'ID harus dilampirkan';
    die;
}

if (!isset($_GET['lesson'])) {
    $lessonOrdinal = 1;
} else {
    $lessonOrdinal = $_GET['lesson'];
}

if (isset($_GET['from'])) {
    $fromCourse = $_GET['from'];
    $checkMaterial = fetch("SELECT course_material_id FROM course_finished_materials WHERE student_id = $studentId AND course_material_id = $fromCourse");
    if (!$checkMaterial) {
        execDML("INSERT INTO course_finished_materials (student_id, course_material_id) VALUES ($studentId, $fromCourse)");
    }
}

$courseId = $_GET['id'];
$student = fetch("SELECT coin_balance FROM students WHERE id = $studentId")[0];
$courseMaterials = fetch(
    "SELECT * FROM course_materials WHERE course_id = $courseId ORDER BY ordinal ASC"
);
$courseMaterial = fetch(
    "SELECT * FROM course_materials WHERE ordinal = $lessonOrdinal AND course_id = $courseId"
)[0];
$courseFinishedMaterial = fetch(
    "SELECT * FROM course_finished_materials
    JOIN course_materials ON course_finished_materials.course_material_id = course_materials.id
    WHERE course_finished_materials.student_id = $studentId AND course_materials.course_id = $courseId"
);

if (isset($_POST['finish-class'])) {
    $courseMaterialId = $courseMaterial['id'];
    $checkMaterial = fetch("SELECT course_material_id FROM course_finished_materials WHERE student_id = $studentId AND course_material_id = $courseMaterialId");
    if (!$checkMaterial) {
        execDML("INSERT INTO course_finished_materials (student_id, course_material_id) VALUES ($studentId, $courseMaterialId)");
        execDML("UPDATE enrolled_courses SET finished_at = NOW() WHERE student_id = $studentId AND course_id = $courseId");
    }
    header("Location: course-player.php?id=$courseId&lesson=$lessonOrdinal");

}

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

    .course-list a {
        display: inline-block;
    }

    .course-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding: 8px 16px 8px 16px;
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

    .next-button-container a {
        text-decoration: none;
    }

    .next-button-container button {
        display: flex;
        gap: 8px;
    }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="../course-detail.php?id=<?= $courseId ?>" class="back-to-course-detail-button">
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
                <?php foreach ($courseMaterials as $material): ?>
                <a href="?id=<?= $courseId ?>&lesson=<?=$material['ordinal'] ?>">
                    <li class="<?= ($material['ordinal'] == $lessonOrdinal) ? 'active' : ''  ?>">
                        <?= $material['title'] ?>
                        <?= (in_array($material['id'], array_column($courseFinishedMaterial, 'course_material_id'))) ? '<iconify-icon icon="lets-icons:check-fill"></iconify-icon>' : '' ?>
                    </li>
                </a>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="video-section">
            <iframe width="100%" height="84%" src="https://www.youtube.com/embed/<?= $courseMaterial['video_link'] ?>"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <div class="next-button-container">
                <?php if ($lessonOrdinal > 1 && $lessonOrdinal <= count($courseMaterials)): ?>
                <a href="?id=<?= $courseId ?>&lesson=<?=$lessonOrdinal-1?>">
                    <button>
                        <iconify-icon style="border: 1px solid #fff; border-radius: 50%" icon="ic:round-navigate-before"
                            id="btn-next-lesson"></iconify-icon>
                        <span>Sebelumnya</span>
                    </button>
                </a>
                <?php else: ?>
                <p></p>
                <?php endif; ?>
                <p><?= $courseMaterial['title'] ?></p>
                <?php if ($lessonOrdinal < count($courseMaterials)): ?>
                <a href="?id=<?= $courseId ?>&lesson=<?=$lessonOrdinal+1?>&from=<?= $courseMaterial['id'] ?>">
                    <button>
                        <span>Selanjutnya</span>
                        <iconify-icon style="border: 1px solid #fff; border-radius: 50%" icon="ic:round-navigate-next"
                            id="btn-next-lesson"></iconify-icon>
                    </button>
                </a>
                <?php else: ?>
                <form action="" method="post">
                    <button name="finish-class">
                        <span>Selesaikan Kelas</span>
                        <iconify-icon style="border: 1px solid #fff; border-radius: 50%" icon="ic:round-navigate-next"
                            id="btn-next-lesson"></iconify-icon>
                    </button>
                </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <script src="../../navbar.js"></script>
</body>

</html>