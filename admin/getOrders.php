<?php
require_once 'db.php';

function getTotalOrders() {
  // Use the existing $conn object from db.php instead of creating a new one
  global $conn;

  // Prepare the statement with a parameterized query
  $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM orders");
  $stmt->execute();

  // Fetch the result as an associative array
  $result = $stmt->get_result()->fetch_assoc();

  // Return the total orders
  return $result['total'];
}

function getOrderbyId(){

    global $conn;
    $stmt = $conn->prepare('SELECT * FROM orders WHERE order_id = ?');
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result;
    if($result){
        return $result;
    }else{
        return false;
    }
}