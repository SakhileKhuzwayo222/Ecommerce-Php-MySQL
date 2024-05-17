<?php
require_once 'db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Retrieve orders
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["user_id"])) {
        // Get all orders for a specific user
        $user_id = $_GET["user_id"];
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($orders);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No orders found for the user"]);
        }
    } else {
        // Get all orders
        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($orders);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No orders found"]);
        }
    }
} 
// Create a new order
else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST["user_id"];
    $sql = "INSERT INTO orders (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo "New order created successfully";
    } else {
        http_response_code(500);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} 
// Update an existing order
else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "PUT") {
    $order_id = $_GET["order_id"];
    $status = $_GET["status"];
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);
    
    if ($stmt->execute()) {
        echo "Order updated successfully";
    } else {
        http_response_code(500);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} 
// Delete an existing order
else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "DELETE") {
    $order_id = $_GET["order_id"];
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        echo "Order deleted successfully";
    } else {
        http_response_code(500);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} 
// Invalid request
else {
    http_response_code(400);
    echo "Invalid request";
}






