<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Create a new shipping record
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = isset($_POST['OrderID']) ? $_POST['OrderID'] : '';
    $shippingOptionId = isset($_POST['ShippingOptionID']) ? $_POST['ShippingOptionID'] : '';

    if ($orderId && $shippingOptionId) {
        $stmt = $conn->prepare("INSERT INTO ordershipping (OrderID, ShippingOptionID) VALUES (?, ?)");
        $stmt->bind_param("ii", $orderId, $shippingOptionId);

        if ($stmt->execute()) {
            echo "New shipping record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Missing OrderID or ShippingOptionID in the request.";
    }
}

// Get shipping details for a specific order
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $orderId = isset($_GET['OrderID']) ? $_GET['OrderID'] : '';

    if ($orderId) {
        $stmt = $conn->prepare("SELECT * FROM ordershipping WHERE OrderID = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $shippingDetails = $result->fetch_assoc();
            echo json_encode($shippingDetails);
        } else {
            echo "No shipping details found for the order";
        }
        $stmt->close();
    } else {
        echo "Missing OrderID in the request.";
    }
}

$conn->close();