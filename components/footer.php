<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Just+Another+Hand&display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<style>
footer {
    background-image: url('asset/footer.png');
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

<body>
    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <div class="logo-section">
                <img src="asset/django-20.png" alt="Logo" class="footer-logo">
                <p>Bergabunglah bersama kami untuk menguasai<br> berbagai keahlian
                    dibidang teknologi dan membuka<br>peluang karier di dunia teknologi
                    yang terus berkembang.<br><br> Kami menyediakan kursus
                    berkualitas yang membantu <br> kamu berkembang dari pemula
                    hingga ahli.</p>
                <p>Hak cipta dilindungi 2024</p>
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
                    <a href="mailto:info@dingcourse.com">info@djangourse.com</a>
                </p>
                <p>
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:+62123456789">+62 123 456 789</a>
                </p>
            </div>
        </div>
    </footer>
</body>

</html>