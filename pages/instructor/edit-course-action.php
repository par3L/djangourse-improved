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
    $judul_kursus = ucwords($_POST['judul_kursus']);
    $subtitle = $_POST['subtitle_kursus'];
    $courseMaterials = $_POST['materi'];
    $existingMaterials = fetch("SELECT * FROM course_materials WHERE course_id = $course_id");
    $existingMaterialOrdinals = array_map(function($material) {
        return $material['ordinal'];
    }, $existingMaterials);
    $courseTools = $_POST['alat_kursus'];
    $kategori_kelas = intval($_POST['kategori_kelas']);
    $tingkat_kursus = $_POST['tingkat_kursus'];
    $deskripsi_kursus = $_POST['deskripsi_kursus'];
    $harga = intval($_POST['harga']);
    $instructor_id = intval($_SESSION['user']['id']);

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

        $file_name = uniqid() . '_' . $instructor_id;
        $file_tmp = $_FILES['thumbnail']['tmp_name'];

        // Validasi ekstensi file
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            die("Ekstensi file tidak diizinkan.");
        }

        $new_file_path = 'uploads/' . $file_name . '.' . $file_extension;

        $upload_target = $upload_dir . $file_name . '.' . $file_extension;
        if (!move_uploaded_file($file_tmp, $upload_target)) {
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
    $queryMaterial = "UPDATE course_materials SET title = ?, video_link = ? WHERE course_id = ?";
    $stmt = $conn->prepare($query);
    $stmtMaterial = $conn->prepare($queryMaterial);
    $stmt->bind_param("ssssssss", $judul_kursus, $kategori_kelas, $tingkat_kursus, $deskripsi_kursus, $harga,
        $file_path, $course_id, $instructor_id);
    foreach ($courseMaterials as $material) {
        $ordinal = intval($material['ordinal']);
        $title = $conn->real_escape_string($material['title']);
        $video_link = str_replace("https://www.youtube.com/watch?v=", "", $conn->real_escape_string($material['video-link']));

        if (in_array($ordinal, $existingMaterialOrdinals)) {
            // Update materi yang sudah ada
            $queryMaterialUpdate = "UPDATE course_materials SET title = ?, video_link = ? WHERE course_id = ? AND ordinal = ?";
            $stmtMaterialUpdate = $conn->prepare($queryMaterialUpdate);
            $stmtMaterialUpdate->bind_param("ssii", $title, $video_link, $course_id, $ordinal);
            $stmtMaterialUpdate->execute();
        } else {
            // Tambahkan materi baru
            $queryMaterialInsert = "INSERT INTO course_materials (course_id, title, video_link, ordinal) VALUES (?, ?, ?, ?)";
            $stmtMaterialInsert = $conn->prepare($queryMaterialInsert);
            $stmtMaterialInsert->bind_param("issi", $course_id, $title, $video_link, $ordinal);
            $stmtMaterialInsert->execute();
        }
    }

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