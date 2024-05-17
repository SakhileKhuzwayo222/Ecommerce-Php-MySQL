<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clothingstore";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn -> connect_error){
	
	die("Connection failed: " . $conn -> connect_error);
	
}

echo "Connected successfully.";

