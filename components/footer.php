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
    <!-- <link rel="stylesheet" href="css/footer.css" /> -->
</head>
<style>
.footer {
    padding: 40px 50px;
    background-image: url('assets/footer.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    font-family: "Inter-Regular", sans-serif;
    min-height: 200px;
}

/* FOOTER */
.logo {
    width: 150px;
    position: relative;
    object-fit: cover;
}

.isi {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 40px;
}

.penjelasan {
    flex: 1 1 30%;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.penjelasan1,
.penjelasan2 {
    font-size: 14px;
    line-height: 1.6;
    color: white;
}

.django-3 {
    width: 120px;
    height: auto;
    object-fit: contain;
    margin-bottom: 10px;
}

.instruktur,
.siswa,
.alamat {
    flex: 1 1 20%;
    display: flex;
    flex-direction: column;
    gap: 10px;
    gap: 26px;
}

.instruktur a,
.siswa a,
.alamat a {
    color: white;
    text-decoration: none;
    font-size: 14px;
}

.instruktur a:hover,
.siswa a:hover,
.alamat a:hover {
    color: #00bcd4;
}

.alamat a:hover {
    color: #00bcd4;
}

.heading-2 {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
    color: white;
}

.alamat {
    flex: 1 1 30%;
}

.alamat div {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.alamat a {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.alamat a:hover i {
    color: #51aea8;
}

.alamat a:hover span {
    color: #00bcd4;
}

.alamat i {
    font-size: 20px;
    color: white;
    line-height: 1;
    margin-right: 20px;
    transition: color 0.3s;
}

.alamat span {
    font-size: 14px;
    color: white;
    line-height: 1.2;
    transition: color 0.3s;
}

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
</style>

<body>
    <!-- FOOTER -->
    <div class="footer">
        <div class="isi">
            <!-- Bagian Penjelasan -->
            <div class="penjelasan">
                <img src="assets/django-20.png" alt="logo" class="logo" />
                <div class="penjelasan1">
                    Lorem ipsum dolor sit amet, consectetur<br />
                    adipiscing elit. Ut consequat mauris Lorem<br />
                    ipsum dolor sit amet, consectetur adipiscing<br />
                    elit. Ut consequat mauris
                </div>
                <div class="penjelasan2">
                    Lorem ipsum dolor sit amet, consectetur<br />
                    adipiscing elit. Ut consequat mauris Lorem<br />
                    ipsum dolor sit amet, consectetur adipiscing<br />
                    elit. Ut consequat mauris
                </div>
            </div>

            <div class="instruktur">
                <div class="heading-2">Instruktur</div>
                <a href="#">Profil</a>
                <a href="#"> Login</a>
                <a href="#">Register</a>
                <a href="#">Instructor</a>
                <a href="#">Dashboard</a>
            </div>

            <div class="siswa">
                <div class="heading-2">Siswa</div>
                <a href="#">Profil</a>
                <a href="#">Jelajahi Kursus</a>
                <a href="#"> Wishlist Kursus</a>
                <a href="#">Student</a>
                <a href="#">Dashboard</a>
            </div>

            <div class="alamat">
                <div class="heading-2">Alamat</div>

                <div class="alamat2">
                    <a href="https://www.google.com/maps?q=Jalan+Gelatik,+Samarinda" target="_blank">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jalan Gelatik, Samarinda</span>
                    </a>
                </div>

                <div class="email">
                    <a href="mailto:admin@django.com">
                        <i class="fas fa-envelope"></i>
                        <span>admin@django.com</span>
                    </a>
                </div>

                <div class="no-tlp">
                    <a href="tel:+48731819948">
                        <i class="fas fa-phone"></i>
                        <span>+48 731 819 948</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
