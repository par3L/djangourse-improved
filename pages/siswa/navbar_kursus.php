
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Navbar-kursus</title>
    <style>
    /* Global Box Sizing */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* Body Styling */
    body {
        font-family: "poppins", sans-serif;
        line-height: 1.6;
        background: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
            linear-gradient(180deg, rgba(217, 217, 217, 0.65) 0%, rgba(44, 133, 119, 0.65) 67.5%);
        color: #333;
        margin: 0;
        padding-top: 100px;
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
        width: 100%;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .logo {
        max-width: 120px;
        height: auto;
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

    .main-content {
        padding: 40px 20px;
        text-align: center;

        /* background: linear-gradient(to left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                  linear-gradient(180deg, rgba(217, 217, 217, 0.65) 0%, rgba(44, 133, 119, 0.65) 67.5%); */
    }

    .main-content h1 {
        color: #000000;
        font-size: 36px;
        margin-bottom: 10px;
    }

    .main-content p {
        font-size: 18px;
        color: rgba(0, 0, 0, 0.95);
        margin-bottom: 30px;
    }

    .search-bar {
        margin-bottom: 30px;
    }

    .search-bar input {
        width: 50%;
        padding: 10px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .tabs {
        display: flex;
        gap: 100px;
        margin-top: 20px;
        justify-content: center;
    }

    .tabs a {
        text-decoration: none;
        color: #245044;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        line-height: 150%;
        transition: all 0.3s ease;
        position: relative;
    }

    .tabs a::after {
        content: '';
        position: absolute;
        width: 0%;
        height: 2px;
        background-color: #245044;
        left: 0;
        bottom: -3px;
        transition: width 0.3s ease;
    }

    .tabs a:hover::after,
    .tabs a.active::after {
        width: 100%;
    }

    .tabs a:hover {
        color: #245044;
        font-weight: bold;
        font-size: 18px;
        transform: scale(1.05);
    }

    .pilihan {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
        margin: 50px;
    }

    .catalog {
        background: #ffffff;
        border-radius: 10px;
        width: 100%;
        display: flex;
        flex-direction: column;
        padding: 20px;
        position: relative;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .catalog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .catalog-title {
        color: #1a202c;
        font-family: "Poppins-Bold", sans-serif;
        font-size: 20px;
        font-weight: 700;
    }

    .heart {
        font-size: 24px;
        color: rgba(0, 0, 0, 0.3);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .heart.active {
        color: #ff4d6d;

    }

    .heart:hover {
        transform: scale(1.3);
    }

    .course-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 10px;
        margin: 20px 0;
    }

    .catalog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .koin {
        color: #1a202c;
        font-family: "Poppins-Bold", sans-serif;
        font-size: 20px;
        font-weight: 700;
    }

    .button-rental {
        background: var(--coloractive-button, #1e888c);
        border-radius: 4px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-rental:hover {
        background-color: #128e8c;
    }

    #loadMore {
        margin: 20px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px 12px 20px;
        font-size: 18px;
        font-weight: bold;
        background: #245044;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #loadMore:hover {
        background-color: #1e888c;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
            padding: 16px 32px;
        }

        .menu {
            flex-direction: column;
            gap: 16px;
            margin-top: 16px;
        }

        .auth-buttons {
            margin-top: 16px;
            width: 100%;
            justify-content: flex-start;
            gap: 12px;
        }

        .style-daftar,
        .style-masuk {
            width: 100%;
            text-align: center;
        }

        .main-content h1 {
            font-size: 28px;
        }

        .search-bar input {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="header">
        <img class="logo" src="asset/django-20.png" alt="Logo Django">
        <nav class="menu">
            <a href="#" class="menu-item">Beranda</a>
            <a href="#" class="menu-item">Kursus</a>
            <a href="#" class="menu-item">Cara Penggunaan</a>
        </nav>
        <div class="auth-buttons">
            <button class="style-daftar">Daftar</button>
            <button class="style-masuk">Masuk</button>
        </div>
    </header>

    <!-- pilihan -->
    <main class="main-content">
        <h1>Daftar Kursus</h1>
        <p>Pelajari semua kursus yang tersedia di Djangourse</p>
        <div class="search-bar">
            <input placeholder="Cari..." type="text" />
        </div>
        <div class="tabs">
            <a class="web-development" href="#">Web Development</a>
            <a class="mobile-development" href="#">Mobile Development</a>
            <a class="soft-skills" href="#">Soft Skills</a>
            <a class="i-os-development" href="#">iOS Development</a>
        </div>

        <div class="pilihan">
            <!-- Catalog 1 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">HTML</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/komputer.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 2 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">CSS</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/komputer.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 3 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">Javascript</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/layarhitam-jpg0.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 4 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">PHP</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/layarhitam-jpg0.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 5 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">PHP</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/layarhitam-jpg0.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 6 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">PHP</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/layarhitam-jpg0.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 7 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">PHP</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/layarhitam-jpg0.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 8 -->
            <div class="catalog">
                <div class="catalog-header">
                    <div class="catalog-title">PHP</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/layarhitam-jpg0.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>

            <!-- Catalog 4 (Tersembunyi Awalnya) -->
            <div class="catalog hidden">
                <div class="catalog-header">
                    <div class="catalog-title">PHP</div>
                    <button class="heart" onclick="toggleFavorite(this)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <img class="course-image" src="asset/layarhitam-jpg0.png" alt="Course Image">
                <div class="catalog-footer">
                    <div class="koin">5 Koin</div>
                    <button class="button-rental">Beli</button>
                </div>
            </div>
    </main>

    <!-- Tombol untuk Tampilkan Lebih Banyak -->
    <button id="loadMore">Tampilkan Lebih Banyak</button>

    <script>
    function toggleFavorite(button) {
        button.classList.toggle('active');
    }

    document.getElementById('loadMore').addEventListener('click', function() {
        const hiddenCatalogs = document.querySelectorAll('.catalog.hidden');
        hiddenCatalogs.forEach((catalog) => {
            catalog.classList.remove('hidden');
        });
        this.style.display = 'none';
    });
    </script>
    <style>
    .hidden {
        display: none;
    }
    </style>
    <?php include 'footer.php'; ?>
</body>

</html>
