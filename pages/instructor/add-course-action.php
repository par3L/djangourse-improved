<?php
session_start();
include '../../utils/database/helper.php';
include '../../utils/middleware.php';

ensureAuthenticated();
ensureRole(2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input wajib
    if (empty($_POST['judul_kursus']) || empty($_POST['kategori_kelas']) || 
        empty($_POST['tingkat_kursus']) || empty($_POST['deskripsi_kursus']) || 
        empty($_POST['harga'])) {
        die("Semua field harus diisi.");
    }

    $judul_kursus = ucwords($_POST['judul_kursus']);
    $subtitle = $_POST['subtitle_kursus'];
    $courseMaterials = $_POST['materi'];
    $courseTools = $_POST['alat_kursus'];
    $kategori_kelas = intval($_POST['kategori_kelas']); // Validasi kategori sebagai integer
    $tingkat_kursus = $_POST['tingkat_kursus'];
    $deskripsi_kursus = $_POST['deskripsi_kursus'];
    $harga = intval(str_replace(["IDR", ".", ","], "", $_POST['harga']));
    $instructor_id = $_SESSION['user']['id'];

    // Validasi tingkat kursus
    $valid_tingkat = ['beginner', 'intermediate', 'advanced'];
    if (!in_array($tingkat_kursus, $valid_tingkat)) {
        die("Tingkat kursus tidak valid.");
    }

    // Validasi kategori ada di tabel course_categories
    $category_check = $conn->query("SELECT id FROM course_categories WHERE id = $kategori_kelas");
    if ($category_check->num_rows === 0) {
        die("Kategori yang dipilih tidak valid.");
    }

    // Penanganan upload file
    $file_path = null;
    if (!empty($_FILES['thumbnail']['name'])) {
        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_name = uniqid();
        $file_tmp = $_FILES['thumbnail']['tmp_name'];

        // Validasi ekstensi file
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            die("Ekstensi file tidak diizinkan.");
        }

        $file_path = 'uploads/' . $file_name . '.' . $file_extension;

        // Simpan file
        $upload_target = $upload_dir . $file_name . '.' . $file_extension;
        if (!move_uploaded_file($file_tmp, $upload_target)) {
            die("Gagal mengunggah file.");
        }

        $now = time();
        $query = "INSERT INTO courses (name, subtitle, category_id, level, description, price, instructor_id, thumbnail, created_at, status)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu')";
        $queryMaterials = "INSERT INTO course_materials (course_id, ordinal, title, video_link) VALUES (?, ?, ?, ?)";
        $queryTools = "INSERT INTO course_tool_galleries (course_id, tool_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmtMaterials = $conn->prepare($queryMaterials);
        $stmtTools = $conn->prepare($queryTools);

        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }

        $stmt->bind_param("sssssssss", $judul_kursus, $subtitle, $kategori_kelas, $tingkat_kursus, 
            $deskripsi_kursus, $harga, $instructor_id, $file_path, $now);

        if ($stmt->execute()) {
            $course_id = $conn->insert_id;
            foreach ($courseMaterials as $material) {
                $ordinal = (int) $material['ordinal'];
                $title = $material['title'];
                $video_link = $material['video-link'];
                $video_link = str_replace("https://www.youtube.com/watch?v=", "", $video_link);
                $stmtMaterials->bind_param("ssss", $course_id, $ordinal, $title, $video_link);
                $stmtMaterials->execute();
            }
            foreach ($courseTools as $tool) {
                $stmtTools->bind_param("ss", $course_id, $tool);
                $stmtTools->execute();
            }
            // Redirect ke halaman setelah sukses
            header("Location: my-courses.php?message=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    
}