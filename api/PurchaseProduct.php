<?php
// Import necessary dependencies
require_once 'db.php';
require_once 'wallet.php';
require_once 'products.php';

// Define product id and user id
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

// Initialize database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get user's wallet balance
function getUserWalletBalance($userId, $conn) {
    $sql = "SELECT balance FROM Wallet WHERE user_id = '$userId'";
    $result = $conn->query($sql);
    if ($result === false) {
        die('query() failed: ' . htmlspecialchars($conn->error));
    }
    $row = $result->fetch_assoc();
    return $row['Balance'];
}

// Function to get the cost of the product
function getProductCost($productId, $conn) {
    $sql = "SELECT price FROM products WHERE product_id = '$productId'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['price'];
}
// Function to handle purchase transaction
function handlePurchaseTransaction($userId, $productId, $conn) {
    // Get user's wallet balance
    $userWalletBalance = getUserWalletBalance($userId, $conn);
    // Get the cost of the product
    $productCost = getProductCost($productId, $conn);
    // Check if the user's wallet balance is sufficient
    if ($userWalletBalance >= $productCost) {
        // Deduct the cost of the product from the user's wallet balance
        $newWalletBalance = $userWalletBalance - $productCost;
        // Update the user's wallet balance in the database
        updateWalletBalance($userId, $newWalletBalance,$conn);
        // Complete the purchase transaction
        return [
            'status' => 'success',
            'message' => 'Purchase completed successfully'
        ];
    } else {
        // Return an error insufficient funds
        return [
            'status' => 'error',
            'message' => 'Insufficient funds'
        ];
    }
}

// Handle the purchase transaction
$response = handlePurchaseTransaction($userId, $productId, $conn);

// Send the response back to the frontend
http_response_code($response['status'] === 'success' ? 200 : 400);
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
