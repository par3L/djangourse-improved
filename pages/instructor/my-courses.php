<?php
session_start();
include '../../utils/database/helper.php';
include '../../utils/middleware.php';

ensureAuthenticated();
ensureRole(2);

$user_id = $_SESSION['user']['id']; // ID instruktur dari sesi pengguna

// Query untuk mengambil kursus berdasarkan ID instruktur
$query = "SELECT id, name, thumbnail, status, price FROM courses WHERE instructor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$instructor = fetch(
    "SELECT instructors.name, credentials.email, instructors.date_of_birth, instructors.phone_number, instructors.bio, instructors.profile_img FROM instructors
    JOIN credentials ON instructors.credential_id = credentials.id
    WHERE instructors.id = $user_id")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Instructor Dashboard</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
    /* Global Styles */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        display: grid;
        grid-template-rows: 60px auto;
        grid-template-columns: 250px 1fr;
        grid-template-areas:
            "navbar navbar"
            "sidebar main";
        width: 100%;
        min-height: 100vh;
    }

    @media (max-width: 768px) {
        .container {
            grid-template-columns: 1fr;
            grid-template-areas:
                "navbar"
                "main";
        }

        .sidebar {
            position: fixed;
            left: -250px;
            top: 60px;
            height: 100%;
            background-color: #ffffff;
            width: 250px;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.open {
            left: 0;
        }

        .navbar .menu {
            display: none;
        }
    }

    /* Navbar */
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

    .navbar nav {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
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

    .hamburger {
        display: none;
        font-size: 24px;
        color: #fff;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .hamburger {
            display: block;
        }

        .navbar ul {
            display: none;
        }
    }

    /* Sidebar */
    .sidebar {
        grid-area: sidebar;
        background-color: #ffffff;
        padding: 20px;
        border-right: 1px solid #ddd;
        transition: all 0.3s ease-in-out;
        margin-top: 20px;
    }

    .sidebar .profile {
        text-align: center;
        margin-bottom: 30px;
    }

    .sidebar .profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid #ccc;
        margin-bottom: 10px;
        object-fit: cover;
    }

    .sidebar .profile h3 {
        font-size: 16px;
        color: #333;
    }

    .sidebar .profile p {
        font-size: 14px;
        color: #888;
    }

    .sidebar .add-course {
        background-color: #245044;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        margin-top: 20px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .sidebar .add-course:hover {
        background-color: #2C8577;
    }

    .sidebar .menu ul {
        list-style: none;
        padding: 0;
    }

    .sidebar .menu ul .section-title {
        font-weight: bold;
        font-size: 14px;
        margin: 15px 0 10px;
    }

    .sidebar .menu ul li a {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-size: 14px;
        padding: 10px 15px;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
        color: #333;
    }

    .sidebar .menu ul li a.active {
        background-color: #2C8577;
        color: white;
    }

    .sidebar .menu ul li a:hover {
        background-color: #2C8577;
        color: white;
    }

    /* Main Content */
    .main-content {
        grid-area: main;
        padding: 20px;
        margin-top: 20px;
        overflow-y: auto;
        /* Membuat konten utama dapat di-scroll */
        height: calc(100vh - 60px);
    }

    .main-content .judul {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background: radial-gradient(closest-side, rgba(33, 108, 104, 1) 0%, rgba(217, 217, 217, 1) 0.7%, rgba(138, 183, 184, 1) 33.5%, rgba(30, 136, 140, 1) 78.2%, rgba(89, 162, 164, 1) 100%);
        padding: 50px;
    }

    .main-content .judul h1 {
        font-size: 24px;
        color: #fff;
    }

    .main-content .judul .breadcrumb {
        font-size: 14px;
        color: #fff;
    }

    .body-content {
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: flex-start;
    }

    .course-list {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        padding: 10px;
        margin: 0 auto;
        overflow: hidden;
    }


    .content-card {
        max-width: 100%;
        overflow: hidden;
        word-wrap: break-word;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .content-header {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .course-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* .img img {
        justify-content: center;
        width: 240px;
        border-radius: 10px;
        max-width: 300px;
        height: 250px;
        margin-bottom: 10px;
    } */

    .content-end {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
    }

    .content-end a {
        margin-right: 10px;
        color: rgba(33, 108, 104, 1);
        text-decoration: none;
    }

    .sunting,
    .hapus {
        text-decoration: none;
        color: rgba(33, 108, 104, 1);
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .sunting:hover,
    .hapus:hover {
        color: #0056b3;
    }

    .content-end a:hover {
        text-decoration: underline;
    }


    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .navbar-info-dropdown {
        position: absolute;
        top: 80px;
        right: 48px;
        width: 220px;
        padding: 16px;
        display: block;
        background-color: #005955;
    }

    .navbar-info-dropdown-content {
        display: flex;
        padding: 16px;
        gap: 16px;
    }

    .navbar-info-dropdown iconify-icon {
        font-size: 24px;
    }

    .navbar-cred {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
    }

    .hide {
        display: none;
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <header class="navbar">
            <img src="../../assets/img/logo-django.png" alt="Logo" class="logo" style="width: 110px;">
            <nav>
                <ul id="navbar-menu">
                    <li><a href="../../index.php">Beranda</a></li>
                    <li><a href="../student/course-list.php">Kursus</a></li>
                    <li><a href="../how-to-use.php">Cara Penggunaan</a></li>
                </ul>
            </nav>
            <div class="navbar-info">
                <div class="navbar-cred">
                    <p>Hai, <?= $_SESSION['user']['name'] ?></p>
                    <iconify-icon icon="iconamoon:arrow-down-2-bold" id="btn-dropdown"></iconify-icon>
                </div>

                <?php if ($_SESSION['user']['role_id'] == 2): ?>
                <div class="navbar-info-dropdown hide" id="navbar-info-dropdown">
                    <a href="dashboard.php">
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
            <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile">
                <img id="profile-pic"
                    src="<?= $instructor['profile_img'] ? '../../assets/' . $instructor['profile_img'] : 'https://artikel.rumah123.com/wp-content/uploads/sites/41/2023/09/12160753/gambar-foto-profil-whatsapp-kosong.jpg' ?>"
                    alt="Profile Picture">
                <h3><?= $instructor['name'] ?></h3>
                <p>Pengajar</p>
                <a href="add-course.php" class="add-course">Tambah Kursus Baru</a>
            </div>
            <div class="menu">
                <ul>
                    <li class="section-title">Dasbor</li>
                    <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dasbor</a></li>
                    <li><a href="profile.php"><i class="fas fa-user"></i> Profil Saya</a></li>
                    <li class="section-title">Pengajar</li>
                    <li><a href="my-courses.php" class="active"><i class="fas fa-chalkboard-teacher"
                                style="color: white;"></i> Kursus Saya</a></li>
                    <li><a href="withdrawal-record.php"><i class="fas fa-wallet"></i> Tarik Saldo</a></li>
                    <li class="section-title">Pengaturan Akun</li>
                    <li><a href="./edit-profile.php"><i class="fas fa-cogs"></i> Edit Profil</a></li>
                    <li><a href="./change-password.php"><i class="fas fa-key"></i> Ubah Kata Sandi</a></li>
                    <li><a href="./withdrawal-setting.php"><i class="fas fa-money-bill-wave"></i> Penarikan</a></li>
                    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="judul">
                <h1>Kursus Saya</h1>
                <span class="breadcrumb">Beranda > Kursus Saya</span>
            </div>

            <?php if (isset($_GET['message']) && $_GET['message'] === 'deleted' && $_SERVER['REQUEST_METHOD'] === 'GET'): ?>
            <div class="alert alert-success">
                Kursus berhasil dihapus.
            </div>
            <?php elseif (isset($_GET['message']) && $_GET['message'] === 'updated' && $_SERVER['REQUEST_METHOD'] === 'GET'): ?>
            <div class="alert alert-success">
                Kursus berhasil diedit.
            </div>
            <?php endif; ?>

            <div class="body-content">
                <h2>Daftar Kursus</h2>
                <?php if ($result->num_rows > 0): ?>
                <div class="course-list">

                    <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="content-card">
                        <div class="content-header"><?= htmlspecialchars($row['name']) ?></div>
                        <div class="img">
                            <?php if (!empty($row['thumbnail']) && file_exists(__DIR__ . '/' . $row['thumbnail'])): ?>
                            <img class="course-image" src="<?= htmlspecialchars($row['thumbnail']) ?>"
                                alt="Thumbnail Kursus">
                            <?php else: ?>
                            <img class="course-image" src="https://via.placeholder.com/150" alt="Gambar Tidak Ada">
                            <?php endif; ?>
                        </div>
                        <div>
                            <p>Status: <strong><?= htmlspecialchars($row['status']) ?></strong></p>
                            <p>Harga: <strong>Rp <?= number_format($row['price'], 0, ',', '.') ?></strong></p>
                        </div>
                        <div class="content-end">
                            <a href="./edit-course.php?id=<?= $row['id'] ?>" class="sunting"><i class="far fa-edit"></i>
                                Sunting</a>
                            <a href="./delete-course.php?id=<?= $row['id'] ?>" class="hapus"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kursus ini?');">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php else: ?>
                <p style="text-align: center; font-size: 18px; color: #888;">Tidak ada kursus ditemukan.</p>
                <?php endif; ?>
            </div>
        </main>
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
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('open');
    }

    const url = new URL(window.location.href);
    if (url.searchParams.get('message') === 'deleted') {
        url.searchParams.delete('message');
        window.history.replaceState(null, null, url.toString());
    }
    </script>
    <script src="../../navbar.js"></script>
</body>

</html>