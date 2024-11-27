<?php
session_start();
include '../../utils/database/helper.php';
include '../../utils/middleware.php';

ensureAuthenticated();
ensureRole(2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input wajib
    if (empty($_POST['id']) || empty($_POST['judul_kursus']) || empty($_POST['kategori_kelas']) || 
        empty($_POST['tingkat_kursus']) || empty($_POST['deskripsi_kursus']) || empty($_POST['harga'])) {
        die("Semua field harus diisi.");
    }

    $course_id = intval($_POST['id']);
    $judul_kursus = $conn->real_escape_string(ucwords($_POST['judul_kursus']));
    $kategori_kelas = intval($_POST['kategori_kelas']);
    $tingkat_kursus = $conn->real_escape_string($_POST['tingkat_kursus']);
    $deskripsi_kursus = $conn->real_escape_string($_POST['deskripsi_kursus']);
    $harga = intval($_POST['harga']);
    $instructor_id = $_SESSION['user']['id'];

    // Validasi kursus milik instruktur
    $checkQuery = "SELECT thumbnail FROM courses WHERE id = ? AND instructor_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $course_id, $instructor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Kursus tidak ditemukan atau Anda tidak memiliki akses.");
    }

    $course = $result->fetch_assoc();

    // Penanganan upload file
    $file_path = $course['thumbnail']; // Gunakan thumbnail lama jika tidak ada unggahan baru
    if (!empty($_FILES['thumbnail']['name'])) {
        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_name = uniqid() . '_' . basename($_FILES['thumbnail']['name']);
        $file_tmp = $_FILES['thumbnail']['tmp_name'];
        $new_file_path = 'uploads/' . $file_name;

        // Validasi ekstensi file
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            die("Ekstensi file tidak diizinkan.");
        }

        // Simpan file baru
        if (!move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            die("Gagal mengunggah file.");
        }

        // Hapus file lama jika ada
        if (!empty($course['thumbnail']) && file_exists(__DIR__ . '/' . $course['thumbnail'])) {
            unlink(__DIR__ . '/' . $course['thumbnail']);
        }

        $file_path = $new_file_path;
    }

    // Update database
    $query = "UPDATE courses SET name = ?, category_id = ?, level = ?, description = ?, price = ?, thumbnail = ? 
              WHERE id = ? AND instructor_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $judul_kursus, $kategori_kelas, $tingkat_kursus, $deskripsi_kursus, $harga,
        $file_path, $course_id, $instructor_id);

    if ($stmt->execute()) {
        header("Location: my-courses.php?message=updated");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    die("Metode request tidak valid.");
}
?>