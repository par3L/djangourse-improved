<?php
session_start();
require '../../utils/database/helper.php';

// Pastikan pengguna login sebagai siswa
if (!isset($_SESSION['user']['id'])) {
    header("Location: ../../auth.php");
    exit;
}

// Ambil student_id dari session
$student_id = $_SESSION['user']['id'];

// Ambil saldo koin siswa
$coin_balance = fetch("SELECT coin_balance FROM students WHERE id = '$student_id'");
$balance = $coin_balance ? $coin_balance[0]['coin_balance'] : 0;

// Ambil riwayat pembelian kursus
$transactions = fetch("
    SELECT c.name AS course_name, t.price AS coins_spent, t.purchase_date, t.transaction_type as type
    FROM transactions t
    LEFT JOIN courses c ON t.course_id = c.id
    WHERE t.student_id = '$student_id'
    ORDER BY t.purchase_date DESC
");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Saldo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <style>
    @import '../style.css';

    body {
        color: #333;
        background-color: #F4F4F9;
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

    /* CONTAINER RIWAYAT */
    .saldo-wrapper {
        display: block;
        padding: 3.5rem 4rem;
        font-family: 'DM Sans', sans-serif;
        background-image: url('../../assets/img/bg.png');
        background-size: cover;
        background-position: center;
        margin-top: 55px;
    }

    .saldo-wrapper h7 {
        font-size: 28px;
        font-weight: bold;
    }

    .coin-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #e0e8f1;
        padding: 20px 35px;
        margin: 20px 0 20px 0;
        border-radius: 12px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Bagian koin dan teks */
    .coin-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .coin-info .icon {
        font-size: 30px;
        color: #f0b429;
        /* Warna emas untuk ikon koin */
    }

    .coin-info div {
        display: flex;
        flex-direction: column;
    }

    .coin-info div .title {
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }

    .coin-info div .amount {
        font-size: 14px;
        color: #666;
    }

    /* Tombol isi ulang */
    .reload-button {
        background-color: #2C6A5E;
        color: white;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        transition: background-color 0.3s;
        display: flex;
        text-decoration: none;
        align-items: center;
        gap: 8px;
    }

    .reload-button:hover {
        background-color: #24594d;
    }

    .saldo-card,
    .riwayat-card {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    /* Container utama */
    .history-container {
        background-color: #e0e8f1;
        padding: 35px 35px 50px 35px;
        border-radius: 12px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 10px;
    }

    /* Judul */
    .history-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }

    /* Tanggal */
    .filter-dropdown {
        background-color: #f0f2f5;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 16px;
        color: #333;
        cursor: pointer;
        width: 500px;
        margin-bottom: 20px;
    }

    .filter-dropdown i {
        color: #333;
    }

    /* Container riwayat transaksi */
    .transaction-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Item riwayat transaksi */
    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .transaction-item .transaction-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .transaction-item .transaction-info i {
        margin-left: 20px;
        font-size: 20px;
        color: #333;
        opacity: 0.5;
    }

    .transaction-item .transaction-info .details {
        display: flex;
        flex-direction: column;
    }

    .transaction-item .transaction-info .details .title {
        margin-left: 70px;
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }

    .transaction-item .transaction-info .details .date {
        margin-left: 70px;
        font-size: 12px;
        color: #666;
    }

    .transaction-item .amount {
        margin-right: 50px;
        font-size: 16px;
        font-weight: 500;
        color: #ff5e5e;
        /* Warna merah untuk koin yang dikurangi */
    }

    .amount.purchase {
        color: #ff5e5e;
    }

    .amount.topup {
        color: #2C6A5E;
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

    <!-- Navbar -->
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
                <?
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
                        <a href="../logout.php">
                            <div class="navbar-info-dropdown-content">
                                <iconify-icon icon="material-symbols:logout" class="sidebar-icon"></iconify-icon>
                                <span>Keluar</span>
                            </div>
                        </a>
                </div>
                </a>
            </div>

            <?php else: ?>
            <div class="auth-buttons">
                <button class="style-daftar" onclick="location.href='../auth.php'">Daftar</button>
                <button class="style-masuk" onclick="location.href='../auth.php'">Masuk</button>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Detail Saldo dan Riwayat Saldo dalam satu Wrapper -->
    <section class="saldo-wrapper">
        <!-- Detail Saldo -->
        <h7>Detail Saldo</h7>
        <div class="coin-container">
            <div class="coin-info">
                <i class="fas fa-coins icon"></i>
                <div>
                    <span class="title">Total Koin Dimiliki</span>
                    <span class="amount"><?= $balance ?> Koin</span>
                </div>
            </div>

            <a href="../student/coin-topup.php" class="reload-button">
                <i class="fas fa-sync-alt"></i>
                Isi Ulang
            </a>
        </div>

        <!-- Riwayat Saldo -->
        <div class="history-container">
            <!-- Judul -->
            <div class="history-title">Riwayat Saldo</div>

            <!-- Dropdown filter -->
            <!-- <div class="filter-dropdown">
                <span>Semua Tanggal</span>
                <i class="fas fa-chevron-down"></i>
            </div> -->

            <!-- Daftar riwayat transaksi -->
            <div class="transaction-list">
                <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $transaction): ?>
                <div class="transaction-item">
                    <div class="transaction-info">
                        <i class="fas fa-shopping-cart"></i> <!-- Ikon keranjang -->
                        <div class="details">
                            <span class="title"><?= ($transaction['type'] == 'topup')? 'Pembelian Koin': 'Pembelian Kursus' ?><?= $transaction['course_name'] ?></span>
                            <span class="date"><?= date("d M Y H:i", strtotime($transaction['purchase_date'])) ?></span>
                        </div>
                    </div>
                    <div class="amount <?= $transaction['type'] == 'topup'? 'topup' : 'amount' ?>"><?= $transaction['type'] == 'topup'? '+' : '-' ?><?= $transaction['coins_spent'] /1000 ?> Koin</div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Tidak ada riwayat transaksi.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
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
<script>
document.getElementById('btn-dropdown').addEventListener('click', () => {
    console.log('click')
    document.getElementById('navbar-info-dropdown').classList.toggle('hide')
})
</script>

</html>