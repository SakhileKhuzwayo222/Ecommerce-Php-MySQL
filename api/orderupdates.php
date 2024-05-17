<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Create a new order update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['order_id'], $data['status'], $data['update_type'], $data['update_date'], $data['update_message'])) {
        $orderId = $data['order_id'];
        $status = $data['status'];
        $updateType = $data['update_type'];
        $updateDate = $data['update_date'];
        $updateMessage = $data['update_message'];

        $stmt = $conn->prepare("INSERT INTO orderupdates (order_id, status, update_type, update_date, update_message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $orderId, $status, $updateType, $updateDate, $updateMessage);

        if ($stmt->execute()) {
            echo "New order update created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Missing data from input";
    }
}

// Get all order updates
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM orderupdates";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $orderUpdates = array();
        
        while ($row = $result->fetch_assoc()) {
            $orderUpdates[] = $row;
        }
        
        header('Content-Type: application/json');
        echo json_encode($orderUpdates);
    } else {
        echo "No order updates found";
    }
}

$conn->close();