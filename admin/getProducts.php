<?php
include_once('api/db.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clothingstore";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$conn = new mysqli($servername, $username, $password, $dbname);
//get products from table products and a get product by rpoduct id
if ($conn->connect_error) {
 die("". $conn->connect_error);
}