<?php

require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// GET /api/wishlist (Retrieve wishlist contents)
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/wishlist') {
    
    $sql = "SELECT WishlistItemID, WishlistID, ProductID, Quantity, AddedDate FROM wishlist WHERE CustomerID = (SELECT CustomerID FROM wishlist WHERE WishlistID = (SELECT MAX(WishlistID) FROM wishlist))";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $wishlist = array();
        while($row = $result->fetch_assoc()) {
            $wishlist[] = $row;
        }
        echo json_encode($wishlist);
    } else {
        echo "No wishlist items found";
    }
    $conn->close();
}


// POST /api/wishlist (Add product to wishlist)
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/wishlist') {
   
    $productId = $_POST['ProductID'];
    $customerId = $_POST['CustomerID'];

    $sql = "INSERT INTO wishlist (ProductID, CustomerID) VALUES ('$productId', '$customerId')";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->query($sql) === TRUE) {
        echo "Product added to wishlist successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}


// DELETE /api/wishlist/:id (Remove wishlist item)
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/api\/wishlist\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $wishlistItemId = $matches[1];
    // Remove wishlist item with the given WishlistItemID from the database
    $sql = "DELETE FROM wishlist WHERE WishlistItemID = '$wishlistItemId'";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->query($sql) === TRUE) {
        echo "Wishlist item removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

