<?php

require '../../utils/database/helper.php';

session_start();

// temporary code
if (isset($_SESSION['login'])) {
    if ($_SESSION['user']['role_id'] == 3) {
        header('Location: pages/admin/views/dashboard.php');
    }
}

$studentId = $_SESSION['user']['id'];
$student = fetch("SELECT * FROM students WHERE id=$studentId")[0];

$query = "SELECT c.*
          FROM courses c
          JOIN favourite_courses fc ON c.id = fc.course_id
          WHERE fc.student_id = $studentId";

$courses = fetch($query);

// Tangani pembelian kursus
$success_message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);
    $student_id = $_SESSION['user']['id']; // ID siswa dari session

    // Ambil harga kursus
    $course = fetch("SELECT price, name FROM courses WHERE id = '$course_id' AND status = 'Disetujui'");
    if (empty($course)) {
        die("Kursus tidak ditemukan atau belum disetujui.");
    }
    $price = floatval($course[0]['price'] / 1000); // Harga kursus dalam koin
    $course_name = $course[0]['name'];

    // Cek saldo koin siswa
    $student = fetch("SELECT coin_balance FROM students WHERE id = '$student_id'");
    if (empty($student)) {
        die("Data siswa tidak ditemukan.");
    }
    $saldo_koin = intval($student[0]['coin_balance']);

    // Debugging saldo dan harga
    $log_message = "Saldo koin siswa: $saldo_koin, Harga kursus: $price";
    error_log($log_message);

    if ($saldo_koin < $price) {
        die("Saldo koin Anda tidak mencukupi untuk membeli kursus ini.");
    }

    // Cek apakah kursus sudah dibeli
    $existing_purchase = fetch("SELECT * FROM transactions WHERE student_id = '$student_id' AND course_id = '$course_id'");
    if (!empty($existing_purchase)) {
        die("Anda sudah membeli kursus ini.");
    }

    // Kurangi saldo koin siswa
    $query_update_balance = "
        UPDATE students
        SET coin_balance = coin_balance - $price
        WHERE id = '$student_id'";
    execDML($query_update_balance);

    // Catat pembelian di tabel transactions
    $query_transaction = "
        INSERT INTO transactions (student_id, course_id, price)
        VALUES ('$student_id', '$course_id', '$price')";
    execDML($query_transaction);

    // Pesan sukses
    $success_message = "Anda berhasil membeli kursus: $course_name.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=, initial-scale=1.0" />
    <title>Instructor View - Dashboard</title>
    <link rel="shortcut icon" href="../../assets/img/django-3.png" type="image/x-icon">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="./css/favourite-course.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    #main-structure {
        display: flex;
        flex-direction: column;
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

    .auth-buttons button {
        margin-left: 10px;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        background-color: #245044;
        color: #fff;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .auth-buttons button:hover {
        background-color: #15A3A1;
        transform: scale(1.05);
    }

    .content {
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), linear-gradient(180deg, rgba(217, 217, 217, 0.65) 0%, rgba(44, 133, 119, 0.65) 67.5%);
        flex: none;
        order: 1;
        flex-grow: 0;
        z-index: 1;
        height: auto;
    }

    .card-wrapper {
        margin-top: 2.8rem;
        text-align: center;
        padding: 2rem;
    }

    .card-wrapper h2 {
        font-family: "Poppins", Helvetica;
        font-size: 60px;
        color: rgba(72, 98, 132, 1);
        margin-bottom: 2rem;

    }


    .pilihan {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        justify-content: center;
        margin: 0 auto;
        max-width: 100px;
        padding-top: 50px;
        padding-bottom: 40px;
    }

    .catalog {
        background: #ffffff;
        border-radius: 10px;
        width: 260px;
        height: 340px;
        flex-direction: column;
        padding: 20px;
        position: relative;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .catalog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .catalog-title {
        color: #1a202c;
        font-family: "Poppins-Bold", sans-serif;
        font-size: 20px;
        font-weight: 700;
    }

    .heart {
        font-size: 24px;
        color: black;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .heart.active {
        color: #ff4d6d;

    }

    .heart:hover {
        transform: scale(1.3);
    }

    .course-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 10px;
        margin: 20px 0;
    }

    .catalog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .koin {
        color: #1a202c;
        font-family: "Poppins-Bold", sans-serif;
        font-size: 20px;
        font-weight: 700;
    }

    .button-rental {
        background: #1e888c;
        border-radius: 4px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-rental:hover {
        background-color: #128e8c;
    }
</style>

<body>
    <div id="main-structure">
        <header>
            <div class="navbar">
                <img src="../../assets/img/logo-django.png" alt="Logo" class="logo"
                    style="  width: 110px; ">
                <nav>
                    <ul>
                        <li><a href="../../index.php">Beranda</a></li>
                        <li><a href="./course-list.php">Kursus</a></li>
                        <li><a href="#">Cara Penggunaan</a></li>
                    </ul>
                </nav>
                <?php if (isset($_SESSION['login'])): ?><div class="navbar-info">
                        <p>Hai,
                            <?= $_SESSION['user']['name'] ?></p>
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
                    </div>
                <?php else: ?>
                    <div class="auth-buttons"><button class="style-daftar"
                            onclick="location.href='pages/auth.php'">Daftar</button><button class="style-masuk"
                            onclick="location.href='pages/auth.php'">Masuk</button></div><?php endif;
                                                                                            ?>
            </div>
        </header>
        <div class="content">
            <div class="card-wrapper">
                <div class="wrap-head">
                    <h2>Kelas Difavoritkan</h2>

                    <?php if (!empty($courses)): ?>
                        <div class="pilihan" id="courses-container">
                            <?php foreach ($courses as $course): ?>
                                <div class="catalog">
                                    <div class="catalog-header">
                                        <a href="../student/course-detail.php?id=<?= $course['id'] ?>" class="catalog-link">
                                            <div class="catalog-title"><?= $course['name'] ?></div>
                                        </a>
                                        <form method="POST">
                                            <input type="hidden" name='course-fav' value="<?= $course['id'] ?>">
                                            <button class="heart active" name="heart">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <img class="course-image" src="<?= $course['thumbnail'] ? "../instructor/" . $course['thumbnail'] : "https://placehold.co/600x400?text=Tidak+Ada+Gambar" ?>" alt="Thumbnail Kursus">
                                    <div class="catalog-footer">
                                        <div class="koin"><?= number_format($course['price'] / 1000, 0, ',', '.') ?> Koin</div>
                                        <form method="POST" action="course-list.php" style="display: inline;">
                                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                            <button type="submit" class="button-rental">Beli</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="height: 300px; padding-top: 24px;">Belum ada kursus yang tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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
                    <a href="mailto:info@djangourse.com">info@djangourse.com</a>
                </p>
                <p>
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:+62123456789">+62 123 456 789</a>
                </p>
            </div>

        </div>
    </footer>
    <script src="./js/favourite-course.js"></script>
</body>

</html>