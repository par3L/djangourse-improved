<?php

session_start();

include '../utils/database/helper.php';

$showModal = false;
$resetMessage = null;

if (isset($_POST['send_reset_link'])) {
    $email = $_POST['email'];

    $checkEmail = fetch("SELECT email FROM credentials WHERE email='$email'");
    if (count($checkEmail) === 1) {
        $resetMessage = "Kami telah mengirimkan email ke sini $email";
        $showModal = true;
    } else {
        $resetMessage = "Surel tidak ditemukan di database kami";
        $showModal = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi</title>
    <style>
    @keyframes gradientAnimation {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #8AC7A4, #D4E8DB, #68B19F);
        background-size: 200% 200%;
        animation: gradientAnimation 3s ease infinite;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container-forgot {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 30px;
        width: 350px;
        text-align: center;
    }

    .container-forgot .logo {
        margin-bottom: 25px;
    }

    .container-forgot .logo img {
        width: 100px;
    }

    .container-forgot h2 {
        text-align: center;
        font-family: 'DM Sans', sans-serif;
        font-size: 20px;
        font-weight: 400;
        margin-bottom: 20px;
    }

    .container-forgot label {
        display: block;
        margin-bottom: 20px;
        font-weight: normal;
        text-align: left;
        color: #333;
    }

    .container-forgot input[type="email"] {
        width: 325px;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
        font-size: 14px;
    }

    .container-forgot button {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        background-color: #245044;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        margin-top: 10px;
    }

    .container-forgot button:hover {
        background-color: #2C8577;
    }

    /* Style untuk modal */
    .modal {
        display: <?php echo $showModal ? 'flex': 'none';
        ?>;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s;
    }

    .modal-content {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.4s;
    }

    .modal-content a {
        color: #245142;
        text-decoration: none;
        font-weight: bold;
        word-wrap: break-word;
        display: block;
        margin: 10px 0;
    }

    .close-btn {
        margin-top: 20px;
        color: #fff;
        background-color: #2c5c4c;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .close-btn:hover {
        background-color: #2C8577;
    }

    /* Animasi untuk modal */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .container-forgot .back-to-login {
        display: inline-block;
        margin-top: 20px;
        font-size: 14px;
        color: #245044;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .container-forgot .back-to-login:hover {
        color: #2c5c4c;
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="container-forgot">
        <div class="logo">
            <img src="../assets/img/logo.png" alt="Logo">
        </div>
        <h2>Lupa Kata Sandi</h2>
        <form action="" method="POST">
            <label for="email">Surel</label>
            <input type="email" name="email" placeholder="email@domain.com" required>
            <button type="submit" name="send_reset_link">Kirim Link Reset</button>
        </form>
        <a href="auth.php" class="back-to-login">Kembali ke Login</a>
    </div>
    <div class="modal" id="resetModal">
        <div class="modal-content">
            <p><?php echo $resetMessage; ?></p>
            <button class="close-btn" onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <script>
    function closeModal() {
        document.getElementById('resetModal').style.display = 'none';
    }

    <?php if ($showModal): ?>
    document.getElementById('resetModal').style.display = 'flex';
    <?php endif; ?>
    </script>
</body>

</html>