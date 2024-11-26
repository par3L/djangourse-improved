<?php

include "../utils/database/helper.php";

session_start();

if (isset($_SESSION['login'])) {
    header('Location: ../index.php');
}

$name = null;
$email = null;
$buttonSignupPressed = false;

if (isset($_POST['signup'])) {
    $name = htmlspecialchars(ucwords($_POST['nama']));
    $email = $_POST['email'];
    $password = $_POST['password'];
    $roleId = $_POST['role'];

    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    $checkEmail = fetch("SELECT email FROM credentials WHERE email='$email'");
    if (count($checkEmail) === 0) {
        $created_at = time();
        $insertIntoCredentials = execDML("INSERT INTO credentials VALUES (null, $roleId, '$email', '$passwordHashed', $created_at)");
        if ($insertIntoCredentials > 0) {
            $credentialRecentlyCreated = fetch("SELECT * FROM credentials WHERE email='$email'")[0]['id'];

            if ($roleId == 1) {
                execDML("INSERT INTO students (credential_id, name) VALUES ($credentialRecentlyCreated, '$name')");
            } else if ($roleId == 2) {
                execDML("INSERT INTO instructors (credential_id, name) VALUES ($credentialRecentlyCreated, '$name')");
            }

            $errorState = [
                "status" => false,
                "message" => "Pendaftaran berhasil. Silakan masuk."
            ];
            $buttonSignupPressed = true;

            $name = null;
            $email = null;
        } else {
            $errorState = [
                "status" => true,
                "message" => "Ada kesalahan pada sistem kami. Silakan ulangi."
            ];
            $buttonSignupPressed = true;
        }
    } else {
        $errorState = [
            "status" => true,
            "message" => "Surel telah digunakan"
        ];
        $buttonSignupPressed = true;
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === 'admin@gmail.com' && $password === 'admin') {
        header('Location: admin/views/dashboard.php');
        $user = [
            'role_id' => 3
        ];
        $_SESSION = [
            "login" => true,
            "user" => $user
        ];
        exit;
    }

    $credentials = fetch("SELECT * FROM credentials WHERE email='$email'");
    if (count($credentials) === 1) {
        $credentials = $credentials[0];
        if (password_verify($password, $credentials['password'])) {
            $user = null;
            if ($credentials['role_id'] == 1) {
                $user = fetch("SELECT students.id, students.name, credentials.email, credentials.role_id
                                FROM students
                                JOIN credentials ON students.credential_id = credentials.id
                                WHERE credentials.email = '$email'")[0];
            } elseif ($credentials['role_id'] == 2) {
                $user = fetch("SELECT instructors.id, instructors.name, credentials.email, credentials.role_id
                                FROM instructors
                                JOIN credentials ON instructors.credential_id = credentials.id
                                WHERE credentials.email = '$email'")[0];
            } elseif ($credentials['role_id'] == 3) {
                $user = [
                    'role_id' => 3
                ];
            }
            $_SESSION = [
                "login" => true,
                "user" => $user
            ];
            header('Location: ../index.php');
        } else {
            $errorState = [
                "status" => true,
                "message" => "Surel atau kata sandi salah!"
            ];
        }
    } else {
        $errorState = [
            "status" => true,
            "message" => "Surel atau kata sandi salah!"
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentikasi - Djangourse</title>
    <link rel="stylesheet" href="auth.css">
</head>

<body>
    <div id="register" class="main-container" style="display: none;">
        <div class="image-section">
            <img src="../assets/img/regis.png" alt="Register">
        </div>
        <div class="form-section">
            <form method="POST" action="">
                <img src="../assets/img/logo.png" alt="Logo"
                    style="display: block; margin: 20px auto 20px; width: 110px; ">
                <h2>Daftar sebagai:</h2>
                <div class="tab-container">
                    <div name="role" class="tab active" id="siswaTab" onclick="selectTab(1)">Siswa</div>
                    <div name="role" class="tab" id="pengajarTab" onclick="selectTab(2)">Instruktur</div>
                </div>
                <input type="hidden" id="role" name="role" value="1">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Christian Farrel" value="<?= $name ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">Surel</label>
                    <input type="email" id="email" name="email" placeholder="farrel@djangourse.com"
                        value="<?= $email ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>
                <div class="form-group">
                    <label for="konfirmasi">Konfirmasi Kata Sandi</label>
                    <input type="password" id="konfirmasi" name="konfirmasi" placeholder="********" required>
                </div>
                <?php if (isset($_POST['signup']) && $errorState['status']): ?>
                <div class="error-message-box">
                    <p class="error-message-text"><?= $errorState['message'] ?></p>
                </div>
                <?php elseif (isset($_POST['signup']) && !$errorState['status']): ?>
                <div class="success-message-box">
                    <p class="success-message-text"><?= $errorState['message'] ?></p>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <button type="submit" name="signup" id="signup">Daftar</button>
                </div>
                <div class="switch-form">
                    Sudah punya akun? <a href="#" onclick="switchToLogin()">Masuk</a>
                </div>
            </form>
        </div>
    </div>

    <div id="login" class="main-container">
        <div class="image-section">
            <img src="../assets/img/login.png" alt="Login Illustration"
                style="display: block; margin: 0px auto 20px; width: 300px;">
        </div>
        <div class="form-section-1">
            <form method="POST" action="">
                <img src="../assets/img/logo.png" alt="Logo"
                    style="display: block; margin: 30px auto 20px; width: 110px;">
                <h2>Masuk</h2>
                <div class="form-group">
                    <label for="email">Surel</label>
                    <input type="email" id="email" name="email" placeholder="email@domain.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>
                <div class="text-forgot"><a href="forgot-password.php">Lupa Kata Sandi?</a></div>
                <?php if (isset($_POST['login']) && $errorState['status']): ?>
                <div class="error-message-box">
                    <p class="error-message-text"><?= $errorState['message'] ?></p>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <button type="submit" name="login">Masuk</button>
                </div>
                <div class="switch-form">
                    Belum punya akun? <a href="#" onclick="switchToRegister()">Daftar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function selectTab(role) {
        document.getElementById('role').value = role;
        const siswaTab = document.getElementById('siswaTab');
        const pengajarTab = document.getElementById('pengajarTab');

        if (role == 1) {
            siswaTab.classList.add('active');
            pengajarTab.classList.remove('active');
        } else if (role == 2) {
            pengajarTab.classList.add('active');
            siswaTab.classList.remove('active');
        }
    }

    function switchToLogin() {
        document.getElementById('register').style.display = 'none';
        document.getElementById('login').style.display = 'flex';
    }

    function switchToRegister() {
        document.getElementById('login').style.display = 'none';
        document.getElementById('register').style.display = 'flex';
    }
    </script>
    <?php if ($buttonSignupPressed) {
        echo "<script>switchToRegister()</script>";
        $buttonSignupPressed = false;
    } ?>;
</body>

</html>