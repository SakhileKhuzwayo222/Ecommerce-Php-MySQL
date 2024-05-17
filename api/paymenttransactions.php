<?php
require_once 'db.php';
require_once 'register.php'; // Assuming this is necessary
require_once 'orders.php'; // Assuming this is necessary

//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Headers: *");

// Retrieve a specific payment transaction by transaction_id
if (isset($_SERVER["REQUEST_METHOD"]) === "GET" && isset($_GET["transaction_id"])) {
    $transaction_id = $_GET["transaction_id"];
    $sql = "SELECT * FROM paymenttransactions WHERE transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $paymentTransaction = $result->fetch_assoc();
        echo json_encode($paymentTransaction);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Payment transaction not found"]);
    }
} 
// Retrieve payment transactions by order_id
else if (isset($_SERVER["REQUEST_METHOD"]) === "GET" && isset($_GET["order_id"])) {
    $order_id = $_GET["order_id"];
    $sql = "SELECT * FROM paymenttransactions WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $paymentTransactions = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($paymentTransactions);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "No payment transactions found for the order"]);
    }
}
// Retrieve all payment transactions
else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM paymenttransactions";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $paymentTransactions = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($paymentTransactions);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "No payment transactions found"]);
    }
} 
// Create a new payment transaction
else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate input data before processing
    $data = json_decode(file_get_contents("php://input"), true);
    // Add validation for required fields and data types
    
    $orderId = $data['order_id'];
    $paymentMethod = $data['payment_method'];
    $amount = $data['amount'];
    $paymentDate = $data['payment_date'];
    $transactionStatus = $data['transaction_status'] ?? null; // Assuming this field is optional
    
    $sql = "INSERT INTO paymenttransactions (order_id, payment_method, amount, payment_date, transaction_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $orderId, $paymentMethod, $amount, $paymentDate, $transactionStatus);
    
    if ($stmt->execute()) {
        http_response_code(201);
        echo "New payment transaction created successfully";
    } else {
        http_response_code(500);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Update an existing payment transaction status by payment_transaction_id
else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "PUT" && isset($_GET["payment_transaction_id"])) {
    $paymentTransactionId = $_GET["payment_transaction_id"];
    $data = json_decode(file_get_contents("php://input"), true);
    $transactionStatus = $data["transaction_status"];
    
    $sql = "UPDATE paymenttransactions SET transaction_status = ? WHERE payment_transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $transactionStatus, $paymentTransactionId);
    
    if ($stmt->execute()) {
        http_response_code(200);
        echo "Payment transaction updated successfully";
    } else {
        http_response_code(500);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Delete a payment transaction by payment_transaction_id
else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "DELETE" && isset($_GET["payment_transaction_id"])) {
    $paymentTransactionId = $_GET["payment_transaction_id"];
    
    $sql = "DELETE FROM paymenttransactions WHERE payment_transaction_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paymentTransactionId);
    
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["message" => "Payment transaction deleted successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Error deleting payment transaction: " . $conn->error]);
    }
}
// Invalid request
else {
    http_response_code(400);
    echo "Invalid request";
}

//$conn->close();



