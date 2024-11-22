<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Sertifikat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Poppins, sans-serif;
}

body {
    background-color: #f5f5f5;
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
    gap: 10px;
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

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #2b4e4e;
    padding: 20px;
    color: #ffffff;
}

header .logo img {
    width: 100px;
}

header nav a {
    margin: 0 15px;
    color: #ffffff;
    text-decoration: none;
}

header .user-info {
    display: flex;
    align-items: center;
}

header .user-info img {
    margin-left: 10px;
    width: 20px;
}

/* Profile Section */
.profil {
    background-color: #f4f4f4;
    background-image: url('/pages/student/assets/bgsiswa.png');
    background-size: cover;
    background-position: center;
    padding: 100px 60px;
    text-align: center;
    color: white;
}

.profile-container {
    display: flex;
    align-items: center;
    padding: 20px;
}

.profile-picture {
    margin-right: 15px;
    width: 150px;
}

.profile-name {
    color: #FFFFFF;
    margin: 0;
    font-size: 37px;
    letter-spacing: 0.5px;
    font-weight: 500;
}

.tabs-section {
    display: flex;
    margin-top: 50px;
    gap: 20px;
    margin-left: 7.5rem;
}

.tab {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background-color: #e0e0e0;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.tab.active {
    background-color: #e0e0e0;
    color: rgb(0, 0, 0);
}

.tab:hover {
    color: white;
    background-color: #2b4e4e
}

.tab.active:hover {
    color: white;
    background-color: #2b4e4e
}

.certificates-section {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

.certificate-card {
    background-color: #d9e6e6;
    padding: 20px;
    width: 221px;
    height: 273px;
    text-align: center;
    border-radius: 0px;
}

.certificate-card h3 {
    margin-bottom: 10px;
}

.certificate-card p {
    font-size: 1rem;
    margin: 5px 0;
}

.certificate-card img {
    max-width: 100px;
    height: auto;
    margin-top: 10px;
    padding-bottom: 15px;
}
</style>

<body>
    <!-- Navbar Section -->
    <header class="navbar">
        <img src="/pages/student/assets/django-20.png" alt="Logo" class="logo" style="  width: 110px; ">
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

    <!-- Profile Section -->
    <div class="profil">
        <div class="profile-container">
            <img src="/pages/student/assets/pictprofil.png" alt="Profile Picture" class="profile-picture">
            <p class="profile-name">Christian Farrel Argya Putra</p>
        </div>
    </div>

    <!-- Tabs Section -->
    <section class="tabs-section">
        <button class="tab active">
            <i class="fa fa-bookmark"></i> Kursus Saya
        </button>
        <button class="tab">
            <i class="fa-solid fa-award"></i> Sertifikat
        </button>
    </section>

    <!-- sertifikat section  -->
    <section class="certificates-section">
        <div class="certificate-card">
            <h3>Sertifikat Penyelesaian</h3>
            <p>HTML</p>
            <img src="/pages/student/assets/sertif.png" alt="Certificate Icon">
            <p>27 Juni 2024</p>
        </div>
        <div class="certificate-card">
            <h3>Sertifikat Penyelesaian</h3>
            <p>HTML</p>
            <img src="/pages/student/assets/sertif.png" alt="Certificate Icon">
            <p>27 Juni 2024</p>
        </div>
        <div class="certificate-card">
            <h3>Sertifikat Penyelesaian</h3>
            <p>HTML</p>
            <img src="/pages/student/assets/sertif.png" alt="Certificate Icon">
            <p>27 Juni 2024</p>
        </div>
        <div class="certificate-card">
            <h3>Sertifikat Penyelesaian</h3>
            <p>HTML</p>
            <img src="/pages/student/assets/sertif.png" alt="Certificate Icon">
            <p>27 Juni 2024</p>
        </div>
        <div class="certificate-card">
            <h3>Sertifikat Penyelesaian</h3>
            <p>HTML</p>
            <img src="/pages/student/assets/sertif.png" alt="Certificate Icon">
            <p>27 Juni 2024</p>
        </div>
    </section>
    <script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown');
        const arrow = document.getElementById('arrow');

        // Toggle visibility of dropdown
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
    </script>
    <?php include '../../components/footer.php'; ?>
</body>

</html>