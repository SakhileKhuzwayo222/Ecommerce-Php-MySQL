<?php
include_once('api/db.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clothingstore";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$conn = new mysqli($servername, $username, $password, $dbname);

function getTotalUsers() {
    global $conn;

    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM users");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return $result['total']?? 0;
}

function deleteUsers(){
    global $conn;
    $stmt = $conn->prepare('DELETE FROM users WHERE condition');
  $stmt->execute();
   $result = $stmt->get_result()->fetch_assoc();
    return $result['total']?? 0;
    
}