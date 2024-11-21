<?php

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Djangourse - Kursus Programmer</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Just+Another+Hand&display=swap" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <img src="assets/img/logo-django.png" alt="Logo" class="logo" style="  width: 110px; ">
            <nav>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pages/student/course-list.php">Kursus</a></li>
                    <li><a href="#">Cara Penggunaan</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <button class="style-daftar" onclick="location.href='pages/auth.php'">Daftar</button>
                <button class="style-masuk" onclick="location.href='pages/auth.php'">Masuk</button>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Selangkah menjadi <span> <br> Programmer</span></h1>
            <p>Djangourse adalah salah satu penyedia layanan kursus bagi programmer pemula</p>
            <div class="buttons">
                <button class="filled">Cari Kursus</button>
                <button class="outlined">Jelajahi</button>
            </div>            
            <div class="trusted-by">
                <p>Telah dipercaya oleh:</p>
            </div>
            <div class="trusted-logos">
                <img src="assets/img/gl.png" alt="Google">
                <img src="assets/img/yt.png" alt="YouTube">
                <img src="assets/img/fb.png" alt="Facebook">
            </div>
        </div>
        <img src="assets/img/orang.png" alt="Programming Image" class="hero-image">
    </section>

    <section class="statistics">
        <div class="stat">
            <span class="number">2 ribu</span>
            <span class="label">Pengajar</span>
        </div>
        <div class="separator">|</div>
        <div class="stat">
            <span class="number">500+</span>
            <span class="label">Jam Belajar</span>
        </div>
        <div class="separator">|</div>
        <div class="stat">
            <span class="number">250+</span>
            <span class="label">Materi</span>
        </div>
        <div class="separator">|</div>
        <div class="stat">
            <span class="number">700 ribu</span>
            <span class="label">Siswa Aktif</span>
        </div>
    </section>
    
    <section class="popular-courses">
        <h2>Kursus Terpopuler</h2>
        <p>Pelajari kursus dengan tingkat peminat tinggi belakangan ini</p>
        <div class="courses">
            <div class="course-card">
                <div class="header">
                    <h3>HTML</h3>
                    <i class="far fa-heart" style="color: #245044; font-size: 1.5rem; margin-bottom: 15px;" onclick="toggleHeart(this)"></i>
                </div>                     
                <img src="assets/img/html.png" alt="HTML">
                <div class="buy">
                    <p class="coins">5 Koin</p>
                    <button>Beli</button>
                </div>
            </div>
            <div class="course-card">
                <div class="header">
                    <h3>CSS</h3>
                    <i class="far fa-heart" style="color: #245044; font-size: 1.5rem; margin-bottom: 15px;" onclick="toggleHeart(this)"></i>
                </div>
                <img src="assets/img/css.png" alt="CSS">
                <div class="buy">
                    <p class="coins">5 Koin</p>
                    <button>Beli</button>
                </div>
            </div>
            <div class="course-card">
                <div class="header">
                    <h3>Javascript</h3>
                    <i class="far fa-heart" style="color: #245044; font-size: 1.5rem; margin-bottom: 15px;" onclick="toggleHeart(this)"></i>
                </div>
                <img src="assets/img/js.png" alt="Javascript">
                <div class="buy">
                    <p class="coins">5 Koin</p>
                    <button>Beli</button>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="assets/img/logo.png" alt="Logo" class="footer-logo">
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
    function toggleHeart(element) {
      element.classList.toggle('text-red-500');
      element.classList.toggle('far');
      element.classList.toggle('fas');
    }
   </script>
</html>
