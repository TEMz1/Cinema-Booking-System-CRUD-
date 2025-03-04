<?php
include 'dbConnect.php';

header('Content-Type: application/json'); // Set response type ke JSON

$response = ["status" => "error", "message" => "Invalid request!"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Cek apakah transaction_id ada di database
    $stmt = $conn->prepare("SELECT * FROM invoice WHERE transaction_id = ?");
    $stmt->bind_param("s", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
        // Cek apakah isUse sudah 1
        if ($row['isUse'] == 1) {
            $response = ["status" => "error", "message" => "This ticket has already been used!"];
        } else {
            // Jika belum digunakan, update isUse menjadi 1
            $updateStmt = $conn->prepare("UPDATE invoice SET isUse = 1, useTime = NOW() WHERE transaction_id = ?");
            $updateStmt->bind_param("s", $transaction_id);
            if ($updateStmt->execute()) {
                $response = ["status" => "success", "message" => "Success, Enjoy The Movie!"];
            } else {
                $response = ["status" => "error", "message" => "Failed to update ticket status!"];
            }
            $updateStmt->close();
        }
    } else {
        $response = ["status" => "error", "message" => "The QR code is incorrect please use correct QR code!"];
    }

    $stmt->close();
    $conn->close();
}
error_log(json_encode($response));
echo json_encode($response);

