<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Create a new gift card
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $value = $_POST['value'];
    $userId = $_POST['user_id'];
    $giftCardId = $_POST['gift_card_id'];
    $customerId = $_POST['customer_id'];
    $cardNumber = $_POST['card_number'];
    $expirationDate = $_POST['expiration_date'];
    $balance = $_POST['balance'];

    $sql = "INSERT INTO giftcards (code, value, user_id, balance, expirationDate, cardNumber, customerId) VALUES ('$giftCardId', '$value', '$userId', '$balance', '$expirationDate', '$cardNumber', '$customerId')";
    if ($conn->query($sql) === TRUE) {
        echo "New gift card created successfully";
    } else {
        echo "Error: ". $sql. "<br>". $conn->error;
    }
}

// Get all gift cards
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM giftcards";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $giftCards = array();
        while($row = $result->fetch_assoc()) {
            $giftCards[] = $row;
        }
        echo json_encode($giftCards);
    } else {
        echo "No gift cards found";
    }
}

$conn->close();