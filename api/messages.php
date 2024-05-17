<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Create a new message
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $senderId = $_POST['sender_id'];
    $receiverId = $_POST['receiver_id'];
    $messageContent = $_POST['message_content'];
    $messageDate = date('Y-m-d H:i:s'); // Get the current date and time

    $sql = "INSERT INTO messages (SenderID, ReceiverID, MessageContent, MessageDate) VALUES ('$senderId', '$receiverId', '$messageContent', '$messageDate')";
    if ($conn->query($sql) === TRUE) {
        echo "New message created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Get all messages
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM messages";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $messages = array();
        while($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        echo json_encode($messages);
    } else {
        echo "No messages found";
    }
}

$conn->close();
