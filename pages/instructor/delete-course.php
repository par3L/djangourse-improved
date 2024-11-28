<?php
session_start();
include '../../utils/database/helper.php';
include '../../utils/middleware.php';

// Pastikan pengguna autentik dan memiliki peran instruktur
ensureAuthenticated();
ensureRole(2);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $instructor_id = $_SESSION['user']['id']; // Pastikan hanya kursus milik instruktur yang bisa dihapus

    // Validasi apakah kursus benar-benar milik instruktur
    $checkQuery = "SELECT thumbnail FROM courses WHERE id = ? AND instructor_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $id, $instructor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();

        // Hapus thumbnail jika ada
        if (!empty($course['thumbnail']) && file_exists(__DIR__ . '/' . $course['thumbnail'])) {
            unlink(__DIR__ . '/' . $course['thumbnail']);
        }

        // Hapus kursus dari database
        $deleteQuery = "DELETE FROM courses WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            header("Location: my-courses.php?message=deleted");
            exit();
        } else {
            echo "Gagal menghapus kursus.";
        }
    } else {
        echo "Kursus tidak ditemukan atau Anda tidak memiliki akses.";
    }
} else {
    header("Location: my-courses.php");
    exit();
}
?>