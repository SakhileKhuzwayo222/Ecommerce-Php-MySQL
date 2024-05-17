<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Create a new promotion record
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {   
    $name = $_POST['Name'];
    $description = $_POST['Description'];
    $discountType = $_POST['DiscountType'];
    $discountValue = $_POST['DiscountValue'];
    $startTime = $_POST['StartTime'];
    $endTime = $_POST['EndTime'];
    $products = $_POST['Products'];

    $sql = "INSERT INTO promotions (Name, Description, DiscountType, DiscountValue, StartTime, EndTime, Products) 
            VALUES ('$name', '$description', '$discountType', '$discountValue', '$startTime', '$endTime', '$products')";
    //echo $sql;
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Promotion created successfully']);
    } else {
        echo json_encode(['error' => 'Failed to create promotion']);
    }

} elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $promotionId = $_GET['id'];
    $sql = "DELETE FROM promotions WHERE id = '$promotionId'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Promotion deleted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to delete promotion']);
    }
} else {
    echo json_encode(['error' => 'Unsupported request method']);
}
 $conn->close();
