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
$student = fetch(
    "SELECT * FROM students
    JOIN credentials ON students.credential_id = credentials.id
    WHERE students.id=$studentId")[0];

if (isset($_POST['change-password'])) {
    $email = $student['email'];
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);

    if (password_verify($currentPassword, $student['password'])) {
        $updatePasswordSql = execDML("UPDATE credentials SET password='$newPasswordHashed' WHERE email='$email'");
        if ($updatePasswordSql) {
            echo "<script>alert('Kata sandi berhasil diubah.')</script>";
        } else {
            echo "<script>alert('Kata sandi gagal diubah.')</script>";
        }
    } else {
        echo "<script>alert('Kata sandi saat ini salah.')</script>";
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fo.css" />
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    @import url('../style.css');

    body {
        line-height: 1.6;
        overflow-x: hidden;
        /* padding-top: 100px; */
        background: linear-gradient(to right, #e0f3f5, #c1dcd6);

    }

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
        width: 100%;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .logo {
        max-width: 120px;
        height: auto;
    }

    .box_setting {
        position: absolute;
        width: 920px;
        height: 440px;
        left: 292px;
        top: 150px;
        padding: 16px;
        flex: none;
        order: 3;
        flex-grow: 0;
        z-index: 3;
        border-radius: 4px;
        border: 1px solid black;
        margin-top: 0px;
        margin-bottom: 0px;

    }


    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 4rem;
        background-color: #245044;
    }

    .header ul {
        display: flex;
        list-style: none;
        gap: 30px;
    }

    .header ul li {
        margin-left: 20px;
    }

    .header a {
        text-decoration: none;
        color: #fff;
        transition: color 0.3s ease, border-bottom 0.3s ease;
    }

    .header a:hover {
        color: #A1D1B6;
        border-bottom: 2px solid #A1D1B6;
    }

    .django-3 {
        width: 120px;
        height: auto;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #244b3f;
        color: #fff;
    }

    .header .logo {
        font-size: 20px;
        font-weight: bold;
    }

    .nav-links {
        list-style: none;
        display: flex;
        gap: 20px;
        margin: 0;
        padding: 0;
    }

    form .form-group input {
        background: #FFFFFF;
        opacity: 0.44;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 93%;
        box-sizing: border-box;
        margin-top: 5px;
    }

    form .form-group-nama input {
        background: #FFFFFF;
        opacity: 0.44;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        width: 93%;
        max-width: 869px;
        margin-left: 32px;
        box-sizing: border-box;
        margin-top: 5px;
    }

    form .form-group-nama label {
        padding-left: 32px;
    }

    .form-group-nama {
        margin-bottom: 15px;
    }


    form .form-row {
        display: flex;
        gap: 0px;
        padding-left: 16px;

    }

    form .form-row input {
        width: 93%;
    }

    form .form-group {
        flex: 1;
        padding-left: 16px;
    }

    .pengaturan_setting h3 {
        font-size: 16px;
        margin: 4px;
        font-weight: bold;
        color: black;
    }

    .pengaturan_setting iconify-icon {
        font-size: 20px;
    }

    .pengaturan_setting ul li.active {
        background-color: #333;
        color: #fff;

    }

    .pengaturan_setting ul li {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 7px;
        font-size: 16px;
        cursor: pointer;
        padding-left: 31px;
        padding-right: 31px;
        list-style: none;
        white-space: nowrap;
    }

    .pengaturan_setting {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        list-style: none;
        padding: 8px 0px;
        gap: 0px;
        position: absolute;
        width: 178px;
        height: 120px;
        left: 114px;
        top: 150px;
        background: #D7DADE;
    }


    .nav-links li a {
        text-decoration: none;
        color: #fff;
        font-size: 14px;
    }

    .nav-links li a:hover {
        text-decoration: underline;
    }

    .user-info {
        display: flex;
        gap: 10px;
        font-size: 14px;
        color: #ffffff;
    }

    .container {
        display: flex;
        height: calc(100vh - 50px);
        flex-direction: column;
        margin-bottom: 10px;
        padding: 0;
    }


    .sidebar h3 {
        margin-top: 0;
        font-size: 18px;
    }

    .pengaturan_setting ul {
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar li {
        padding: 10px;
        margin: 10px 0;
        cursor: pointer;
        border-radius: 4px;
    }

    .user-info {
        position: relative;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .user-info span {
        font-size: 16px;
        margin-right: 5px;
    }

    .user-info .arrow {
        font-size: 12px;
    }

    /* Gaya untuk menu drop-down */
    .dropdown {
        position: absolute;
        top: 130%;
        left: 0;
        padding-top: 0px;
        margin-top: 8px;
        gap: 8px;
        background-color: #B3B3B3;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 0 0 8px 8px;
        overflow: hidden;
        width: 150px;
        display: none;
        flex-direction: column;
        transform: translateY(20px);
        z-index: 1;
    }

    .dropdown a {
        padding: 10px 15px;
        text-decoration: none;
        color: #245044;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .dropdown a:hover {
        background-color: #fff;
        color: #333;
    }

    .user-info:hover .dropdown {
        display: flex;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 20px;
        color: white;
    }

    .sidebar li.active {
        background-color: #333;
        color: #fff;
    }

    .content {
        flex: 1;
        padding: 40px;
        background-image: url(asset/bg.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
    }

    .container .pengaturan_setting {
        margin-left: 20px;
    }

    .container .content .box_setting {
        margin-left: 20px;
    }

    form .form-group input {
        width: 93%;
        max-width: 440px;
        padding-left: 16px;

    }

    h2 {
        font-size: 30px;
        margin-bottom: 20px;
    }

    .content h2 {
        text-align: center;
    }

    /* Form */
    .form-group {
        margin-bottom: 15px;
    }

    .form-row {
        display: flex;
    }

    label {
        display: block;
        margin-bottom: 0px;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    button {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
    }

    .box_pengaturan {
        position: absolute;
        width: 902px;
        height: 619px;
        left: 292px;
        top: 253px;
        flex: none;
        order: 3;
        flex-grow: 0;
        z-index: 3;
    }

    .delete-button {
        background-color: #e74c3c;
        color: #fff;
        margin-top: 20px;
        margin-left: 32px;
    }

    .save-button {
        color: #fff;
        border-radius: 8px;
        margin-top: 20px;
        margin-left: 680px;
        background: #245044;
        padding: 12px 20px;
        gap: 10px;
    }

    .note {
        font-size: 12px;
        color: #666;
        margin-top: 10px;
        margin-left: 32px;
    }


    /* Navigation Menu */
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

    a {
        text-decoration: none;
        color: inherit;
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

    .auth-buttons {
        display: flex;
        gap: 16px;
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

    .links-section h3,
    .contact-section h3 {
        margin-top: 0;
        margin-bottom: 0;
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


    /* Responsif untuk layar sedang */
    @media screen and (max-width: 1024px) {
        .isi {
            gap: 30px;
        }

        .penjelasan,
        .instruktur,
        .siswa,
        .alamat {
            flex: 1 1 45%;
        }
    }

    /* Responsif untuk layar kecil */
    @media screen and (max-width: 768px) {
        .isi {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .penjelasan,
        .instruktur,
        .siswa,
        .alamat {
            flex: 1 1 100%;
        }

        .django-3 {
            margin-bottom: 20px;
        }
    }

    /* Responsif untuk layar sangat kecil */
    @media screen and (max-width: 480px) {
        .footer {
            padding: 20px;
        }

        .penjelasan1,
        .penjelasan2,
        .alamat p {
            font-size: 12px;
            line-height: 1.4;
        }
    }

    @media screen and (max-width: 768px) {

        .menu,
        .auth-buttons {
            display: none;
        }

        .hamburger {
            display: flex;
        }
    }

    @media screen and (min-width: 769px) {
        .menu {
            display: flex;
            gap: 32px;
        }

        .auth-buttons {
            display: flex;
            flex-direction: row;
            gap: 16px;
            align-items: center;
        }

        .menu-collapsed {
            display: none;
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
            <div class="auth-buttons">
                <button class="style-daftar" onclick="location.href='pages/auth.php'">Daftar</button>
                <button class="style-masuk" onclick="location.href='pages/auth.php'">Masuk</button>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <script>
    function toggleMenu() {
        const hamburger = document.getElementById('hamburger');
        const menu = document.getElementById('menu-collapsed');
        hamburger.classList.toggle('active');
        menu.classList.toggle('active');
    }
    </script>
    <div class="container">
        <div class="pengaturan_setting">
            <h3>Pengaturan</h3>
            <ul>
                <li>
                    <iconify-icon icon="gg:profile"></iconify-icon><a href="setting.php">Profil</a>
                </li>
                <li class="active">
                    <iconify-icon icon="icon-park-outline:keyhole"></iconify-icon>Kata Sandi
                </li>
            </ul>
        </div>
        <div class="content">
            <div class="box_setting">
                <h2>Ubah Kata Sandi</h2>
                <form method="post">
                    <div class="form-group-nama">
                        <label for="nama">Kata Sandi Saat Ini</label>
                        <input type="password" name="current-password" id="current-password"
                            placeholder="Masukkan kata sandi saat ini">
                    </div>
                    <div class="form-group-nama">
                        <label for="kota">Kata Sandi Baru</label>
                        <input type="password" name="new-password" id="new-password"
                            placeholder="Masukkan kata sandi baru">
                    </div>
                    <div class="form-group-nama">
                        <label for="tanggal">Konfirmasi Sandi Baru</label>
                        <input type="password" name="password-confirmation" id="password-confirmation"
                            placeholder="Masukkan konfirmasi kata sandi baru">
                    </div>
                    <button type="submit" name="change-password" class="save-button">Simpan Perubahan</button>
                </form>
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
                    <a href="mailto:info@dingcourse.com">info@dingcourse.com</a>
                </p>
                <p>
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:+62123456789">+62 123 456 789</a>
                </p>
            </div>

        </div>
    </footer>
    <script src="../../navbar.js"></script>
    <script src="js/setting-password.js"></script>
</body>

</html>