<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Ensure request method is set
if (isset($_SERVER["REQUEST_METHOD"])) {
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            // Retrieve products
            if (isset($_GET['category'])) {
                // Retrieve products by category
                $category = $_GET['category'];
                $sql = "SELECT * FROM products WHERE category = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $category);
                $stmt->execute();
                $result = $stmt->get_result();
            } elseif (isset($_GET['product_id'])) {
                // Retrieve a specific product
                $productId = $_GET['product_id'];
                $sql = "SELECT * FROM products WHERE product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $productId);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                // Retrieve all products
                $result = $conn->query("SELECT * FROM products");
            }
            
            if ($result && $result->num_rows > 0) {
                $products = $result->fetch_all(MYSQLI_ASSOC);
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($products);
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'No products found'));
            }
            break;
            
        case "POST":
            // Create a new product
            // Add appropriate validation for input data
            $data = json_decode(file_get_contents("php://input"), true);
            $productName = $data['product_name'];
            $price = $data['price'];
            $imageUrl = $data['image_url'];
            $createdDate = $data['created_date'];
            $updatedDate = $data['updated_date'];
            
            $sql = "INSERT INTO products (product_name, price, image_url, created_date, updated_date) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $productName, $price, $imageUrl, $createdDate, $updatedDate);
            if ($stmt->execute()) {
                http_response_code(201);
                echo "New product created successfully";
            } else {
                http_response_code(500);
                echo "Error: Product creation failed";
            }
            break;
            
        case "PUT":
            // Update a specific product
            $data = json_decode(file_get_contents("php://input"), true);
            $productId = $data['product_id'];
            $productName = $data['product_name'];
            $price = $data['price'];
            $imageUrl = $data['image_url'];
            $updatedDate = $data['updated_date'];
            
            $sql = "UPDATE products SET product_name = ?, price = ?, image_url = ?, updated_date = ? WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdsii", $productName, $price, $imageUrl, $updatedDate, $productId);
            if ($stmt->execute()) {
                http_response_code(200);
                echo "Product updated successfully";
            } else {
                http_response_code(500);
                echo "Error: Product update failed";
            }
            break;
            
        case "DELETE":
            // Delete a specific product
            $productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;
            $sql = "DELETE FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            if ($stmt->execute()) {
                http_response_code(200);
                echo "Product deleted successfully";
            } else {
                http_response_code(500);
                echo "Error: Product deletion failed";
            }
            break;
            
        default:
            http_response_code(405);
            echo "Method Not Allowed";
            break;
    }
} else {
    http_response_code(400);
    echo "Bad Request";
}

$conn->close();

