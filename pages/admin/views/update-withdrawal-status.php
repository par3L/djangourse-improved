<?php
include '../../../utils/database/helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $withdrawalRequestId = $input['id'];
    $status = $input['status'];
    $amount = $input['amount'];
    $instructorId = $input['instructorId'];

    $query = "UPDATE withdrawal_requests SET status = '$status' WHERE id = $withdrawalRequestId";
    $result = execDML($query);

    if ($status === 'rejected') {
        echo json_encode(['success' => $result]);
        return;
    }

    $update = execDML("UPDATE instructors SET balance = balance - $amount WHERE id = $instructorId");

    if ($result && $update) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>