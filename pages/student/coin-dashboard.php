<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Saldo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #F4F4F9;
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

        /* CONTAINER RIWAYAT */
        .saldo-wrapper {
            display: block;
            padding: 3rem 4rem;
            font-family: 'DM Sans', sans-serif;
            background-image: url('img/bg.png');
            background-size: cover;
            background-position: center;
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
            color: #f0b429; /* Warna emas untuk ikon koin */
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
            align-items: center;
            gap: 8px;
        }

        .reload-button:hover {
            background-color: #24594d;
        }

        .saldo-card, .riwayat-card {
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
            color: #ff5e5e; /* Warna merah untuk koin yang dikurangi */
        }

        /* FOOTER */
        footer {
            background-image: url('assets/img/footer.png');
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
                    <span class="arrow" id="arrow">▼</span> <!-- Ikon "V" -->
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

    <!-- Detail Saldo dan Riwayat Saldo dalam satu Wrapper -->
    <section class="saldo-wrapper">
        <!-- Detail Saldo -->
        <h7>Detail Saldo</h7>
        <div class="coin-container">
            <div class="coin-info">
                <i class="fas fa-coins icon"></i>
                <div>
                    <span class="title">Total Koin Dimiliki</span>
                    <span class="amount">5 Koin</span>
                </div>
            </div>
            
            <button class="reload-button">
                <i class="fas fa-sync-alt"></i>
                Isi Ulang
            </button>
        </div>

        <!-- Riwayat Saldo -->
        <div class="history-container">
            <!-- Judul -->
            <div class="history-title">Riwayat Saldo</div>
    
            <!-- Dropdown filter -->
            <div class="filter-dropdown">
                <span>Semua Tanggal</span>
                <i class="fas fa-chevron-down"></i>
            </div>
    
            <!-- Daftar riwayat transaksi -->
            <div class="transaction-list">
                <!-- Item transaksi 1 -->
                <div class="transaction-item">
                    <div class="transaction-info">
                        <i class="fas fa-shopping-cart"></i> <!-- Ikon keranjang -->
                        <div class="details">
                            <span class="title">Beli Kursus: HTML</span>
                            <span class="date">1 Oktober 2024 11:23 WITA</span>
                        </div>
                    </div>
                    <div class="amount">-5 Koin</div>
                </div>
    
                <!-- Item transaksi 2 -->
                <div class="transaction-item">
                    <div class="transaction-info">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="details">
                            <span class="title">Beli Kursus: HTML</span>
                            <span class="date">1 Oktober 2024 11:23 WITA</span>
                        </div>
                    </div>
                    <div class="amount">-5 Koin</div>
                </div>
    
                <!-- Item transaksi 3 -->
                <div class="transaction-item">
                    <div class="transaction-info">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="details">
                            <span class="title">Beli Kursus: HTML</span>
                            <span class="date">1 Oktober 2024 11:23 WITA</span>
                        </div>
                    </div>
                    <div class="amount">-5 Koin</div>
                </div>
    
                <!-- Item transaksi 4 -->
                <div class="transaction-item">
                    <div class="transaction-info">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="details">
                            <span class="title">Beli Kursus: HTML</span>
                            <span class="date">22 Oktober 2024 11:23 WITA</span>
                        </div>
                    </div>
                    <div class="amount">-5 Koin</div>
                </div>
            </div>
        </div>
    </section>

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
<script>
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
