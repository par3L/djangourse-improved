<?php
session_start();
require_once '../../utils/database/helper.php';

if (!isset($_SESSION['user']['id'])) {
    header("Location: ../../auth.php");
    exit;
}

$student_id = $_SESSION['user']['id'];

$coin_balance = fetch("SELECT coin_balance FROM students WHERE id = '$student_id'");
$balance = $coin_balance ? $coin_balance[0]['coin_balance'] : 0;

$success_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coins = (int) $_POST['coins'];
    $price = $coins * 1000; 
    
    $updateQuery = "
        UPDATE students
        SET coin_balance = coin_balance + $coins
        WHERE id = '$student_id'";
    execDML($updateQuery);

    $historyQuery = "
        INSERT INTO coin_topup_history (student_id, coins_added, price)
        VALUES ('$student_id', '$coins', '$price')";
    execDML($historyQuery);

    $success_message = "Anda berhasil membeli $coins koin!";
  
    $coin_balance = fetch("SELECT coin_balance FROM students WHERE id = '$student_id'");
    $balance = $coin_balance ? $coin_balance[0]['coin_balance'] : 0;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Ulang Koin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <style>
    /* Gaya umum dan font */
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

    /* Bagian isi utama */
    .main-content {
        text-align: center;
        padding: 70px;
        margin-top: 90px;
    }

    .main-content h1 {
        font-size: 32px;
        font-weight: 500;
        margin-bottom: 10px;
        color: #245044;
    }

    .main-content p {
        font-size: 16px;
        color: #1A202C;
        margin-bottom: 40px;
    }

    /* Kotak paket koin */
    .coin-packages {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 50px;
    }

    .coin-package {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 190px;
        text-align: center;
    }

    .coin-package img {
        width: 50px;
        margin-bottom: 15px;
    }

    .coin-package h2 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .coin-package p {
        font-size: 16px;
        font-weight: 500;
        color: #666;
        margin-bottom: 15px;
    }

    .coin-package button {
        background-color: #FFA500;
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
    }

    .coin-package button:hover {
        background-color: #e09500;
    }

    /* Footer */
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

    /* Styling untuk modal */
    #confirmationModal {
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
    </style>
</head>

<body>
    <!-- Header -->
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
                <?php
                $coin_balance = fetch("SELECT coin_balance FROM students WHERE id = '$student_id'");
                $balance = $coin_balance ? $coin_balance[0]['coin_balance'] : 0;
                ?>
                <p><?php echo $balance; ?> Koin</p>

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
            </div>

            <?php else: ?>
            <div class="auth-buttons">
                <button class="style-daftar" onclick="location.href='../auth.php'">Daftar</button>
                <button class="style-masuk" onclick="location.href='../auth.php'">Masuk</button>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <!-- Konten utama -->
    <main class="main-content">
        <h1>Isi Ulang Koin</h1>
        <p>Koin dapat digunakan untuk membeli kelas berbayar</p>

        <!-- Paket koin -->
        <div class="coin-packages">
            <div class="coin-package">
                <h2>5 Koin</h2>
                <i class="fas fa-coins" style="font-size: 50px; color: #f0b429; margin: 15px;"></i>
                <p>Rp5.000</p>
                <button onclick="showConfirmation(5)">Beli</button>
            </div>
            <div class="coin-package">
                <h2>10 Koin</h2>
                <i class="fas fa-coins" style="font-size: 50px; color: #f0b429; margin: 15px;"></i>
                <p>Rp10.000</p>
                <button onclick="showConfirmation(10)">Beli</button>
            </div>
            <div class="coin-package">
                <h2>15 Koin</h2>
                <i class="fas fa-coins" style="font-size: 50px; color: #f0b429; margin: 15px;"></i>
                <p>Rp15.000</p>
                <button onclick="showConfirmation(15)">Beli</button>
            </div>
            <div class="coin-package">
                <h2>20 Koin</h2>
                <i class="fas fa-coins" style="font-size: 50px; color: #f0b429; margin: 15px;"></i>
                <p>Rp20.000</p>
                <button onclick="showConfirmation(20)">Beli</button>
            </div>
        </div>
    </main>

    <div id="confirmationModal" style="display:none;">
        <div class="modal-content">
            <p id="confirmationMessage"></p>
            <form method="POST" id="confirmationForm">
                <input type="hidden" name="coins" id="coinsInput">
                <button type="submit" id="yesButton">Ya</button>
                <button type="button" id="noButton" onclick="closeModal()">Tidak</button>
            </form>
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
</body>
<script src="../../navbar.js"></script>
<script>
function showConfirmation(koinAmount) {
    const confirmationMessage = `Apakah Anda yakin ingin mengisi ${koinAmount} Koin?`;
    document.getElementById("confirmationMessage").textContent = confirmationMessage;

    document.getElementById("coinsInput").value = koinAmount;

    // Tampilkan modal
    document.getElementById("confirmationModal").style.display = "flex";
}


function closeModal() {
    document.getElementById("confirmationModal").style.display = "none";
}

function closeSuccessMessage() {
    const message = document.getElementById("successMessage");
    if (message) {
        message.style.display = "none";
    }
}
</script>

</html>