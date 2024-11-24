<?php
require "../../utils/database/helper.php";

$sql = fetch("SELECT * FROM students JOIN credentials ON (students.credential_id = credentials.id)");

$django = [];
foreach ($sql as $row) {
    $django[] = [
        'id' => $row['id'], 
        'credential_id' => $row['credential_id'], 
        'name' => $row['name'],  
        'email' => $row['email'], 
        'date_of_birth' => $row['date_of_birth'],
        'city' => $row['city'],
        'phone_number' => $row['phone_number']
    ];
}
if (isset($_POST["submit"])) {
    $city = $_POST['city'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $name = $_POST['name'] ?? '';
    if ($city && $phone_number && $date_of_birth && $name) {
        $sql2 = execDML(
            "UPDATE students
            SET name = '$name', 
                date_of_birth = '$date_of_birth',
                city = '$city', 
                phone_number = '$phone_number'
            WHERE id = 1"
        );

        if ($sql2 > 0) {
            echo "Update berhasil!";
        } else {
            echo "Gagal mengupdate data.";
        }
    } else {
        echo "Error: Semua field harus diisi.";
    }
}

if(isset($_POST["submit2"])){

}

session_start();
var_dump($_SESSION);

// temporary code
if (isset($_SESSION['login'])) {
    if ($_SESSION['user']['role_id'] == 3) {
        header('Location: pages/admin/views/dashboard.php');
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
        margin: 0;
        height: 100%;
        padding: 0;
        overflow-x: hidden;
        padding-top: 100px;

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
        width: 902px;
        height: 500px;
        left: 292px;
        top: 150px;
        flex: none;
        order: 3;
        flex-grow: 0;
        z-index: 3;
        border-radius: 4px;
        border: 1px solid black;

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

    body {
        background: linear-gradient(to right, #e0f3f5, #c1dcd6);
        color: #333;
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

    .pengaturan_setting ul li.active {
        background-color: #333;
        color: #fff;

    }

    a {
        text-decoration: none;
        color: inherit;
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
        list-style: none;
        flex-direction: column;
        align-items: center;
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
        height: calc(115vh - 50px);
        flex-direction: column;
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
        margin-left: 696px;
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
  background-image: url("../../assets/img/bg-footer.png");
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
  color: #a1d1b6;
  border-bottom: 2px solid #a1d1b6;
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
  color: #a1d1b6;
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
                    <li><a href="../student/course-list.php">Kursus</a></li>
                    <li><a href="#">Cara Penggunaan</a></li>
                </ul>
            </nav>
            <?php if (isset($_SESSION['login'])): ?>
            <div class="navbar-info">
                <p>Hai, <?= $_SESSION['user']['name'] ?></p>
                <iconify-icon icon="iconamoon:arrow-down-2-bold" id="btn-dropdown"></iconify-icon>
                <p>0 Koin</p>
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
                <li class="active"><img src="./asset/akun.png">Profil</li>
                <li><img src="asset/keyhole.png"><a href="pengaturan_sandi.php">Kata Sandi</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="box_setting">
                <h2>Pengaturan Profil</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group-nama">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" placeholder="Masukkan nama lengkap"
                            value="<?= htmlspecialchars($row['name']) ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">Kota Domisili</label>
                            <input type="text" name="city" id="city" placeholder="Masukkan kota domisili"
                                value="<?= htmlspecialchars($row['city']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                value="<?= $row['date_of_birth'] ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Alamat Surel</label>
                            <input type="email" name="email" id="email" placeholder="Masukkan alamat surel"
                                value="<?= htmlspecialchars($row['email']) ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">No. HP</label>
                            <input type="number" name="phone_number" id="phone_number" placeholder="Masukkan nomor HP"
                                value="<?= htmlspecialchars($row['phone_number']) ?>">
                        </div>
                    </div>
                    <button type="submit" name="submit2" class="delete-button" onclick="deleteAccount()">Hapus
                        Akun</button>
                    <p class="note">
                        *Semua informasi akun dan kelas yang telah dibeli akan dihapus dari database kami.
                    </p>
                    <button type="submit" name="submit" class="save-button">Simpan Perubahan</button>
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
                    <a href="https://www.google.com/maps?q=Jalan+Gubeng+Surabaya" target="_blank">Jalan Gubeng, Surabaya</a>
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
</body>
<!-- <script>
function deleteAccount() {
    if (confirm("Apakah Anda yakin ingin menghapus akun? Semua data akan hilang.")) {
        fetch('delete_account.php', { method: 'POST' })
            .then(response => response.text())
            .then(data => alert(data))
            .catch(error => console.error('Error:', error));
    }
}

function toggleDropdown() {
    const dropdown = document.getElementById('dropdown');
    const arrow = document.getElementById('arrow');
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'flex';
        arrow.textContent = '▲'; 
    } else {
        dropdown.style.display = 'none';
        arrow.textContent = '▼'; 
    }
}

document.addEventListener('click', function(event) {
    const userInfo = document.querySelector('.user-info');
    const dropdown = document.getElementById('dropdown');
    const arrow = document.getElementById('arrow');
    if (!userInfo.contains(event.target)) {
        dropdown.style.display = 'none';
        arrow.textContent = '▼'; 
    }
});
</script> -->

<script>
document.getElementById('btn-dropdown').addEventListener('click', () => {
    console.log('click')
    document.getElementById('navbar-info-dropdown').classList.toggle('hide')
})
</script>

</html>