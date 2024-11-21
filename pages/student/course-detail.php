<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Tentang Kelas dan Tools Kelas</title>
    <style>
    /* Global Styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "Poppins", sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header Styling */
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
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .logo {
        max-width: 120px;
        height: auto;
    }

    /* Hamburger Menu Icon */
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

    /* Content Section */
    .isi-content {
        background-image: url("asset/bg.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
    }


    .description {
        margin-top: 100px;
        text-align: center;
        padding: 20px;
        border-radius: 10px;
    }

    .description h1 {
        font-size: 48px;
        color: #245044;
        line-height: 150%;
        letter-spacing: -0.02em;
        font-weight: 600;
        margin-top: 20px;
    }

    .description p {
        font-size: 18px;
        line-height: 29px;
        letter-spacing: 0.15px;
        font-weight: 500;
        font-family: "Poppins", sans-serif;
        color: rgba(0, 0, 0, 0.95);
    }

    .description .info {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }

    .description .info div {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #000000;
    }

    .description .info i {
        font-size: 18px;
    }

    .content {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .content .left {
        flex: 1;
        background: #245044;
        padding: 20px;
        border-radius: 10px;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }

    .content .left img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .content .left p {
        margin-top: 20px;
        font-size: 16px;
        line-height: 29px;
        text-align: left;
    }

    .content .right {
        flex: 1;
        background-color: transparent;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 2px solid #d9d9d9;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .content .right ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .content .right ul li {
        display: flex;
        flex-direction: column;
        padding: 4px 5px;
        margin-bottom: 10px;
        border-radius: 8px;
        background: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-size: 14px;
    }

    .content .right ul li i {
        margin-right: 10px;
        color: #4a7c59;
        flex-shrink: 0;
    }

    .content .right ul li span {
        font-weight: 500;
        font-size: 14px;
        color: #79747e;
    }

    .content .right ul li .title-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        padding: 5px;
    }

    .content .right ul li .title-wrapper:hover {
        background: #e8f6ef;
        border-radius: 5px;
    }

    .content .right ul li .content {
        display: none;
        margin-top: 10px;
        font-size: 14px;
        color: #4a7c59;
    }

    .content .right .button {
        text-align: center;
    }

    .content .right ul li.active .content {
        display: block;
    }


    .content .right .button button {
        width: 100%;
        color: #fffcfc;
        background-color: #245044;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .content .right .button button:hover {
        background-color: #4a7c59;
    }

    .button-lanjut button {
        background-color: #2c8577;
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 30px;
        margin-top: 20px;
        border: none;
        cursor: pointer;
    }

    .button-lanjut button:hover {
        background-color: #ef991f;
        color: #ffffff;
    }

    .penggunaan p {
        font-size: 20px;
        letter-spacing: 0.15px;
        font-weight: 500;
        margin-top: 20px;
        text-align: left;
    }

    .penggunaan,
    .alat {
        margin-top: 20px;
        display: none;
        text-align: center;
        margin-bottom: 20px;
    }

    .alat .item {
        display: grid;
        gap: 20px;
        grid-template-columns: repeat(2, 300px);
        justify-content: left;
        margin-top: 20px;
    }

    .card {
        width: 300px;
        height: 100px;
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card img {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .card-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .card-content span:first-child {
        font-size: 16px;
        font-weight: 600;
        color: #245044;
    }

    .card-content span:last-child {
        font-size: 14px;
        font-weight: 400;
        color: #79747e;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
        .isi-content {
            background-size: contain;
        }

        .content {
            flex-direction: column;
        }

        .content .left,
        .content .right {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="header">
        <img class="logo" src="assets/django-20.png" alt="Logo Django">
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
        <div class="auth-buttons">
            <button class="style-daftar">Daftar</button>
            <button class="style-masuk">Masuk</button>
        </div>
        <nav class="menu-collapsed" id="menu-collapsed">
            <a href="#" class="menu-item">Beranda</a>
            <a href="#" class="menu-item">Kursus</a>
            <a href="#" class="menu-item">Cara Penggunaan</a>
            <div class="auth-buttons">
                <button class="style-daftar">Daftar</button>
                <button class="style-masuk">Masuk</button>
            </div>
        </nav>
    </header>

    <!-- DESCRIPTION SECTION -->
    <div class="isi-content">
        <div class="description">
            <h1>HTML</h1>
            <p>Belajar Struktur Dasar dari Sebuah Website</p>
            <div class="info">
                <div><i class="fas fa-signal"></i> Tingkat Kesulitan: Mudah</div>
                <div><i class="fas fa-calendar-alt"></i> Diperbarui: September 2022</div>
            </div>
        </div>

        <!-- CONTENT SECTION -->
        <div class="container">
            <div class="content">
                <div class="left">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/NBZ9Ro6UKV8?si=Qjuuv5c-2EtEcQxs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sem magna, gravida eu eros in,
                        fermentum vulputate sem. Quisque at ipsum pretium, ullamcorper tellus non, feugiat eros. Nunc
                        euismod
                        mauris ipsum.
                    </p>
                </div>

                <!-- Right Section -->
                <div class="right">
                    <ul>
                        <li>
                            <div class="title-wrapper" onclick="toggleContent(this)">
                                <div>
                                    <i class="fas fa-play-circle"></i>
                                    <span>Sejarah HTML</span>
                                </div>
                                <span>5 Menit</span>
                            </div>
                            <div class="content">Penjelasan detail tentang Sejarah HTML.</div>
                        </li>
                        <li>
                            <div class="title-wrapper" onclick="toggleContent(this)">
                                <div>
                                    <i class="fas fa-lock"></i>
                                    <span>Anatomi Elemen HTML</span>
                                </div>
                                <span>3 Menit</span>
                            </div>
                            <div class="content">Penjelasan detail tentang Anatomi Elemen HTML.</div>
                        </li>
                        <li>
                            <div class="title-wrapper" onclick="toggleContent(this)">
                                <div>
                                    <i class="fas fa-lock"></i>
                                    <span>Struktur Dokumen HTML</span>
                                </div>
                                <span>7 Menit</span>
                            </div>
                            <div class="content">Penjelasan detail tentang Struktur Dokumen HTML.</div>
                        </li>
                        <li>
                            <div class="title-wrapper" onclick="toggleContent(this)">
                                <div>
                                    <i class="fas fa-lock"></i>
                                    <span>Struktur Dokumen HTML</span>
                                </div>
                                <span>7 Menit</span>
                            </div>
                            <div class="content">Penjelasan detail tentang Struktur Dokumen HTML.</div>
                        </li>
                        <li>
                            <div class="title-wrapper" onclick="toggleContent(this)">
                                <div>
                                    <i class="fas fa-lock"></i>
                                    <span>Struktur Dokumen HTML</span>
                                </div>
                                <span>7 Menit</span>
                            </div>
                            <div class="content">Penjelasan detail tentang Struktur Dokumen HTML.</div>
                        </li>
                    </ul>
                    <div class="button">
                        <button>Gabung Kelas</button>
                    </div>
                </div>
            </div>

            <div class="button-lanjut">
                <button onclick="showContent('penggunaan')">Tentang Kelas</button>
                <button onclick="showContent('alat')">Alat</button>
            </div>
            <div class="penggunaan" id="penggunaan">
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam perferendis harum amet minima
                    recusandae excepturi saepe ipsa voluptate quae iste, delectus sapiente, dolore explicabo qui
                    commodi
                    a, necessitatibus animi hic.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam
                    perferendis harum amet minima
                    recusandae excepturi saepe ipsa voluptate quae iste, delectus sapiente, dolore explicabo qui
                    commodi
                    a, necessitatibus animi hic.
                </p>
            </div>
            <div class="alat" id="alat">
                <div class="item">
                    <div class="card">
                        <img src="assets/vscode.png" alt="Visual Studio Code">
                        <div class="card-content">
                            <span>Visual Studio Code</span>
                            <span>Code Editor</span>
                        </div>
                    </div>
                    <div class="card">
                        <img src="assets/apache.png" alt="Apache">
                        <div class="card-content">
                            <span>Apache</span>
                            <span>Web Server</span>
                        </div>
                    </div>
                    <div class="card">
                        <img src="assets/chrome.png" alt="Google Chrome">
                        <div class="card-content">
                            <span>Google Chrome</span>
                            <span>Web Browser</span>
                        </div>
                    </div>
                    <div class="card">
                        <img src="assets/sql.png" alt="MySQL">
                        <div class="card-content">
                            <span>MySQL</span>
                            <span>Database</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../components/footer.php'; ?>

    <script>
    function toggleContent(element) {
        const parent = element.parentElement;
        parent.classList.toggle('active');
    }

    function toggleMenu() {
        const hamburger = document.getElementById('hamburger');
        const menu = document.getElementById('menu-collapsed');
        hamburger.classList.toggle('active');
        menu.classList.toggle('active');
    }

    function showContent(section) {

        document.getElementById('penggunaan').style.display = 'none';
        document.getElementById('alat').style.display = 'none';

        document.getElementById(section).style.display = 'block';
    }
    </script>
    
</body>

</html>
