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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=, initial-scale=1.0"/>
    <title>Instructor View - Dashboard</title>
      <link rel="shortcut icon" href="../../assets/img/django-3.png" type="image/x-icon">
      <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="./css/favourite-course.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  </head>
  <body>
    <div id="main-structure">
        <header>
            <div class="navbar">
                <img src="../../assets/img/logo-django.png" alt="Logo" class="logo" style="  width: 110px; ">
                <nav>
                    <ul>
                        <li><a href="../../index.php">Beranda</a></li>
                        <li><a href="./course-list.php">Kursus</a></li>
                        <li><a href="#">Cara Penggunaan</a></li>
                    </ul>
                </nav>
                <?php if (isset($_SESSION['login'])): ?>
                    <div class="navbar-info">
                        <p>Hai, <?= $_SESSION['user']['name'] ?></p>
                        <iconify-icon icon="iconamoon:arrow-down-2-bold" id="btn-dropdown"></iconify-icon>
                        <p>0 Koin</p>
                        <div class="navbar-info-dropdown hide" id="navbar-info-dropdown">
                            <a href="pages/student/pro.php">
                                <div class="navbar-info-dropdown-content">
                                    <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                                    <span>Profil</span>
                                </div>
                            </a>
                            <a href="./favourite-course.php">
                                <div class="navbar-info-dropdown-content">
                                    <iconify-icon icon="weui:like-filled"></iconify-icon>
                                    <span>Wishlist</span>
                                </div>
                                
                            </a>
                            <a href="./pages/siswa/pengaturan_profil.php">
                                <div class="navbar-info-dropdown-content">
                                    <iconify-icon icon="uil:setting"></iconify-icon>
                                    <span>Pengaturan</span>
                                </div>
                            </a>
                            <a href="pages/logout.php">
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
      <div class="content">
            <div class="card-wrapper">
                <div class="wrap-head">
                <h2>Kelas Difavoritkan</h2>
                <div class="card-container">
                  <div class="card">
                    <div class="card-header">
                      <h3>HTML</h3>
                      <i class="fas fa-heart"></i>
                    </div>
                    <img src="./assets/layarhitam-jpg0.png" alt="Class Image" />
                    <div class="card-footer">
                      <span>5 Koin</span>
                      <button class="buy-btn">Beli</button>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h3>HTML</h3>
                      <i class="fas fa-heart"></i>
                    </div>
                    <img src="./assets/layarhitam-jpg0.png" alt="Class Image" />
                    <div class="card-footer">
                      <span>5 Koin</span>
                      <button class="buy-btn">Beli</button>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h3>HTML</h3>
                      <i class="fas fa-heart"></i>
                    </div>
                    <img src="./assets/layarhitam-jpg0.png" alt="Class Image" />
                    <div class="card-footer">
                      <span>5 Koin</span>
                      <button class="buy-btn">Beli</button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>         
        </div>
    </div>
    <!-- Footer --><footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="../../assets/img/logo-django.png" alt="Logo" class="footer-logo">
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
    <script src="./js/favourite-course.js"></script>
  </body>
</html>