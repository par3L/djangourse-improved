<?php
session_start();

// Include helper dan middleware
include '../../utils/database/helper.php';
include '../../utils/middleware.php';

ensureAuthenticated();
ensureRole(2);


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID kursus tidak valid.");
}

$course_id = intval($_GET['id']);
$instructor_id = $_SESSION['user']['id'];


$query = "SELECT * FROM courses WHERE id = ? AND instructor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $course_id, $instructor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Kursus tidak ditemukan atau Anda tidak memiliki akses.");
}

$course = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kursus</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
    /* Container utama */
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    /* Judul halaman */
    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    /* Form */
    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    form label {
        font-size: 16px;
        color: #555;
    }

    form input[type="text"],
    form input[type="number"],
    form select,
    form textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.3s;
    }

    form input[type="text"]:focus,
    form input[type="number"]:focus,
    form select:focus,
    form textarea:focus {
        border-color: #6c63ff;
    }

    form button[type="submit"] {
        padding: 10px 20px;
        background-color: #6c63ff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    form button[type="submit"]:hover {
        background-color: #5548c8;
    }

    form img {
        max-width: 150px;
        margin-top: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Kursus</h1>
        <form action="edit-course-action.php" method="POST" enctype="multipart/form-data">
            <!-- ID Kursus -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($course['id']) ?>">

            <!-- Judul Kursus -->
            <label for="judul_kursus">Judul Kursus</label>
            <input type="text" name="judul_kursus" id="judul_kursus" value="<?= htmlspecialchars($course['name']) ?>"
                required>

            <!-- Kategori Kelas -->
            <label for="kategori_kelas">Kategori Kelas</label>
            <select name="kategori_kelas" id="kategori_kelas" required>
                <?php
                $categories = $conn->query("SELECT * FROM course_categories");
                while ($category = $categories->fetch_assoc()): ?>
                <option value="<?= $category['id'] ?>"
                    <?= $category['id'] == $course['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
                <?php endwhile; ?>
            </select>

            <!-- Tingkat Kursus -->
            <label for="tingkat_kursus">Tingkat Kursus</label>
            <select name="tingkat_kursus" id="tingkat_kursus" required>
                <option value="beginner" <?= $course['level'] === 'beginner' ? 'selected' : '' ?>>Mudah</option>
                <option value="intermediate" <?= $course['level'] === 'intermediate' ? 'selected' : '' ?>>Menengah</option>
                <option value="advanced" <?= $course['level'] === 'advanced' ? 'selected' : '' ?>>Sulit</option>
            </select>

            <!-- Deskripsi Kursus -->
            <label for="deskripsi_kursus">Deskripsi Kursus</label>
            <textarea name="deskripsi_kursus" id="deskripsi_kursus"
                required><?= htmlspecialchars($course['description']) ?></textarea>

            <!-- Harga -->
            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" value="<?= htmlspecialchars($course['price']) ?>" required>

            <!-- Thumbnail -->
            <label for="file-upload">Thumbnail</label>
            <input type="file" name="thumbnail" id="file-upload" accept="image/*">
            <?php if (!empty($course['thumbnail']) && file_exists(__DIR__ . '/' . $course['thumbnail'])): ?>
            <p>Thumbnail saat ini:</p>
            <img src="<?= htmlspecialchars($course['thumbnail']) ?>" alt="Thumbnail">
            <?php endif; ?>

            <!-- Tombol Submit -->
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>