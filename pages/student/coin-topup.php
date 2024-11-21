<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Ulang Koin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Gaya umum dan font */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-image: url('img/bg.png');
            background-size: cover;
            background-position: center;            
            color: #333;
        }

        .navbar {
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

        .header1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            color: #fff;
            font-family: Arial, sans-serif;
            background-color: #2C6A5E;
        }

        /* Gaya untuk nama dan menu drop-down */
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

        /* Bagian isi utama */
        .main-content {
            text-align: center;
            padding: 40px;
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
            width: 150px;
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
            background-color: #073e3a;
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

        .links-section h3 ,.contact-section h3 {
            margin-top: 0;
            margin-bottom: 0;
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
    <header class="navbar">
        <img src="img/logo.png" alt="Logo" class="logo" style="  width: 110px; ">
            <nav>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Kursus</a></li>
                    <li><a href="#">Cara Penggunaan</a></li>
                </ul>
            </nav>
        <div class="user-info">
            <div class="header">
                <div class="user-info" onclick="toggleDropdown()">
                    <span>Hai, Christian Farrel</span>
                    <span class="arrow" id="arrow">▼</span> 
                    <div class="dropdown" id="dropdown">
                        <a href="#profile"><i class="fas fa-user"></i> Profil</a>
                        <a href="#wishlist"><i class="fas fa-heart"></i> Wishlist</a>
                        <a href="#settings"><i class="fas fa-cog"></i> Pengaturan</a>
                        <a href="#logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                    </div>
                </div>
            </div>
            <span><a href="#">0 Koin</a></span>
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
            <button id="yesButton" onclick="confirmPurchase()">Ya</button>
            <button id="noButton" onclick="closeModal()">Tidak</button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="img/logo.png" alt="Logo" class="footer-logo">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
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
                <p><i class="fas fa-map-marker-alt"></i>  Jalan Gubeng, Surabaya</p>
                <p><i class="fas fa-envelope"></i>  info@dingcourse.com</p>
                <p><i class="fas fa-phone-alt"></i> +62 123 456 789</p>
            </div>
        </div>
    </footer>
</body>
<script>
    function showConfirmation(koinAmount) {
            const confirmationMessage = `Apakah Anda yakin ingin mengisi ${koinAmount} Koin?`;
            document.getElementById("confirmationMessage").textContent = confirmationMessage;
            document.getElementById("confirmationModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("confirmationModal").style.display = "none";
        }

        function confirmPurchase() {
            alert("Pembelian Koin berhasil!");
            closeModal();
        }

    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown');
        const arrow = document.getElementById('arrow');
        
        // Toggle visibility of dropdown
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'flex';
            arrow.textContent = '▲'; // Ubah ikon ke "^"
        } else {
            dropdown.style.display = 'none';
            arrow.textContent = '▼'; // Kembali ke ikon "V"
        }
    }

    // Klik di luar dropdown untuk menutupnya
    document.addEventListener('click', function(event) {
        const userInfo = document.querySelector('.user-info');
        const dropdown = document.getElementById('dropdown');
        const arrow = document.getElementById('arrow');

        // Tutup dropdown jika mengklik di luar area dropdown
        if (!userInfo.contains(event.target)) {
            dropdown.style.display = 'none';
            arrow.textContent = '▼'; // Pastikan ikon kembali ke "V"
        }
    });
</script>
</html>
