<?php
include '../../../utils/database/helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $withdrawalRequestId = $input['id'];
    $status = $input['status'];

    $query = "UPDATE withdrawal_requests SET status = '$status' WHERE id = $withdrawalRequestId";
    $result = execDML($query);

    if ($result > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>