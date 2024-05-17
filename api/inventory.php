<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Create a new inventory record
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $warehouseLocation = $_POST['warehouse_location'];
  
    $sql = "INSERT INTO inventory (product_id, quantity, warehouse_location) VALUES ('$productId', '$quantity', '$warehouseLocation')";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO inventory (product_id, quantity) VALUES ('$productId', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        echo "New inventory record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Get all inventory records
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM inventory";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $inventory = array();
        while($row = $result->fetch_assoc()) {
            $inventory[] = $row;
        }
        echo json_encode($inventory);
    } else {
        echo "No inventory records found";
    }

    $conn->close();
}

