<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fo.css" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "poppins", sans-serif;
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
        font-family: 'Poppins', sans-serif;
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
        font-family: 'Poppins', sans-serif;

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
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
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
        height: calc(100vh - 50px);
        flex-direction: column;
        font-family: 'Poppins', sans-serif;
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
        font-family: 'Poppins', sans-serif;
    }

    .save-button {
        color: #fff;
        border-radius: 8px;
        margin-top: 20px;
        margin-left: 710px;
        background: #245044;
        padding: 12px 20px;
        gap: 10px;
        font-family: 'Poppins', sans-serif;
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
    <header class="header">
        <img class="logo" src="asset/django-20.png" alt="Logo Django">
        <div class="hamburger" id="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <nav class="menu">
            <a href="#" class="menu-item">Beranda</a>
            <a href="#" class="menu-item">Kursus</a>
            <a href="#" class="menu-item">Cara Penggunaan</a>
        </nav>
        <div class="user-info" onclick="toggleDropdown()">
            <span>Hai, Christian Farrel</span>
            <span class="arrow" id="arrow">▼</span>
            <div class="dropdown" id="dropdown">
                <a href="#profile"><i class="fas fa-user"></i> Profil</a>
                <a href="#wishlist"><i class="fas fa-heart"></i> Wishlist</a>
                <a href="#settings"><i class="fas fa-cog"></i> Pengaturan</a>
                <a href="#logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </div>
            <span>0 Koin</span>
        </div>
        <nav class="menu-collapsed" id="menu-collapsed">
            <a href="#" class="menu-item">Beranda</a>
            <a href="#" class="menu-item">Kursus</a>
            <a href="#" class="menu-item">Cara Penggunaan</a>
        </nav>
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
                <li class="active"><img src="asset/akun.png">Profil</li>
                <li><img src="asset/keyhole.png"><a href="pengaturan_sandi.php">Kata Sandi</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="box_setting">
                <h2>Pengaturan Profil</h2>
                <form>
                    <div class="form-group-nama">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="kota">Kota Domisili</label>
                            <input type="text" id="kota" placeholder="Masukkan kota domisili">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Lahir</label>
                            <input type="date" id="tanggal">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Alamat Surel</label>
                            <input type="email" id="email" placeholder="Masukkan alamat surel">
                        </div>
                        <div class="form-group">
                            <label for="nohp">No. HP</label>
                            <input type="tel" id="nohp" placeholder="Masukkan nomor HP">
                        </div>
                    </div>
                    <button type="button" class="delete-button">Hapus Akun</button>
                    <p class="note">
                        *Semua informasi akun dan kelas yang telah dibeli akan dihapus dari database kami.
                    </p>
                    <button type="submit" class="save-button">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
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
<?php include 'footer.php'; ?>

</html>
