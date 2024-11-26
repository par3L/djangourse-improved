<?php

require '../../utils/database/helper.php';

session_start();

if (isset($_SESSION["login"])) {
    $userId = $_SESSION['user']['id'];

    if ($_SESSION['user']['role_id'] == 1) {
        $student = fetch("SELECT coin_balance FROM students WHERE id=$userId")[0];
    }

    if ($_SESSION['user']['role_id'] == 3) {
        header('Location: pages/admin/views/dashboard.php');
        die;
    }
}

// Ambil kategori dari database
$categories = fetch("SELECT * FROM course_categories");

// Validasi $categories
if (!isset($categories) || !is_array($categories)) {
    $categories = [];
}

// Ambil kursus sesuai kategori
$kategori = $_GET['kategori'] ?? null;
$offset = intval($_GET['offset'] ?? 0);
$limit = 4;

$query = "SELECT c.*, cc.name AS category_name
          FROM courses c
          JOIN course_categories cc ON c.category_id = cc.id
          WHERE c.status = 'Disetujui'";

if ($kategori) {
    $query .= " AND cc.name = '$kategori'";
}

$query .= " LIMIT $limit OFFSET $offset";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Daftar Kursus - Djangourse</title>
    <style>
    /* Global Box Sizing */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* Body Styling */
    body {
        font-family: "poppins", sans-serif;
        line-height: 1.6;
        background:
            linear-gradient(to left, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
            linear-gradient(180deg,
                rgba(217, 217, 217, 0.65) 0%,
                rgba(44, 133, 119, 0.65) 67.49714612960815%);
        color: #333;
        margin: 0;
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

    .auth-buttons .style-daftar {
        background-color: #128e8c;
        padding: 0.5rem 1rem;
    }

    .auth-buttons .style-daftar:hover,
    .style-masuk:hover {
        background-color: #fff;
        transform: scale(1.05);
        color: #15A3A1;
    }

    .main-content {
        padding: 120px 20px;
        text-align: center;
        padding-bottom: 0;

    }

    .main-content h1 {
        color: #000000;
        font-size: 36px;
        margin-bottom: 10px;
    }

    .main-content p {
        font-size: 18px;
        color: rgba(0, 0, 0, 0.95);
        margin-bottom: 30px;
    }

    .search-bar {
        margin-bottom: 30px;
    }

    .search-bar input {
        width: 50%;
        padding: 10px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .tabs {
        display: flex;
        gap: 100px;
        margin-top: 20px;
        justify-content: center;
    }

    .tabs a {
        text-decoration: none;
        color: #245044;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        line-height: 150%;
        transition: all 0.3s ease;
        position: relative;
    }

    .tabs a::after {
        content: '';
        position: absolute;
        width: 0%;
        height: 2px;
        background-color: #245044;
        left: 0;
        bottom: -3px;
        transition: width 0.3s ease;
    }

    .tabs a:hover::after,
    .tabs a.active::after {
        width: 100%;
    }

    .tabs a:hover {
        color: #245044;
        font-weight: bold;
        font-size: 18px;
        transform: scale(1.05);
    }

    .pilihan {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        justify-content: center;
        margin: 0 auto;
        max-width: 1000px;
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
        background: var(--coloractive-button, #1e888c);
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

    #loadMore {
        margin: 20px auto;
        margin-bottom: 40px;
        margin-top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px 12px 20px;
        font-size: 18px;
        font-weight: bold;
        background: #245044;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #loadMore:hover {
        background-color: #1e888c;
    }

    #loadLess {
        margin: 20px auto;
        margin-bottom: 40px;
        margin-top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px 12px 20px;
        font-size: 18px;
        font-weight: bold;
        background: #245044;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #loadLess:hover {
        background-color: #1e888c;
    }

    .controls {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin: 0 auto;
        width: 100%;
    }

    .catalog.hidden {
        display: none !important;
    }

    footer {
        background-image: url('../../assets/img/footer.png');
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
            padding: 16px 32px;
        }

        .menu {
            flex-direction: column;
            gap: 16px;
            margin-top: 16px;
        }

        .auth-buttons {
            margin-top: 16px;
            width: 100%;
            justify-content: flex-start;
            gap: 12px;
        }

        .style-daftar,
        .style-masuk {
            width: 100%;
            text-align: center;
        }

        .main-content h1 {
            font-size: 28px;
        }

        .search-bar input {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <!-- HEADER -->
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
                        <div class=" navbar-info-dropdown-content">
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
                    <a href="../../pages/instructor/dashboard.php">
                        <div class="navbar-info-dropdown-content">
                            <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                            <span>Dasbor</span>
                        </div>
                    </a>
                    <a href="../../pages/logout.php">
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
                <button class="style-daftar" onclick="location.href='../auth.php'">Daftar</button>
                <button class="style-masuk" onclick="location.href='../auth.php'">Masuk</button>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <main class="main-content">
        <h1>Daftar Kursus</h1>
        <p>Pelajari semua kursus yang tersedia di Djangourse</p>
        <?php if (isset($success_message)): ?>
        <p style="color: green; text-align: center;"><?= $success_message ?></p>
        <?php endif; ?>
        <div class="search-bar">
            <input placeholder="Cari..." type="text" id="searchInput" />
        </div>

        <div class="tabs">
            <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
            <a href="#" class="tab <?= (isset($kategori) && $kategori === $category['name']) ? 'active' : '' ?>"
                onclick="loadCourses('<?= htmlspecialchars($category['name']) ?>', true); return false;">
                <?= htmlspecialchars($category['name']) ?>
            </a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($courses)): ?>
        

        <div class="pilihan" id="courses-container">
            
            <?php foreach ($courses as $course): ?>
            <div class="catalog" data-category="<?= htmlspecialchars($course['category_name']) ?>">
                <div class="catalog-header">
                    <a href="../student/course-detail.php?id=<?= $course['id'] ?>" class="catalog-link">
                        <div class="catalog-title"><?= htmlspecialchars($course['name']) ?></div>
                    </a>
                    <button class="heart"><i class="far fa-heart"></i></button>
                </div>
                <img class="course-image" src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="Thumbnail Kursus">
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
            <p style="height: 300px;">Belum ada kursus yang tersedia.</p>
        <?php endif; ?>
    </main>

    <!-- Tombol untuk Tampilkan Lebih Banyak -->
    <div class="controls">
        <?php if (count($courses) === $limit): ?>
        <a href="?kategori=<?= urlencode($kategori) ?>&offset=<?= $offset + $limit ?>" id="loadMore">Tampilkan Lebih
            Banyak</a>
        <?php endif; ?>
        <?php if ($offset > 0): ?>
        <a href="?kategori=<?= urlencode($kategori) ?>&offset=<?= max($offset - $limit, 0) ?>" id="loadLess">Tampilkan
            Lebih Sedikit</a>
        <?php endif; ?>
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
                    <a href="mailto:info@dingcourse.com">info@dingcourse.com</a>
                </p>
                <p>
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:+62123456789">+62 123 456 789</a>
                </p>
            </div>

        </div>
    </footer>
    <script src="./js/course-list.js"></script>
</body>

</html>