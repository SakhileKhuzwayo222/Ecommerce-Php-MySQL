<?php

// Create a new mysqli object with your database connection details
$conn = new mysqli("localhost", "username", "password", "ClothingStore");

// Check for errors
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Create the categories table
$sql = "CREATE TABLE categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);";
if (!$conn->query($sql)) {
    echo "Error creating categories table: ". $conn->error;
}

// Create the products table
$sql = "CREATE TABLE products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);";
if (!$conn->query($sql)) {
    echo "Error creating products table: ". $conn->error;
}

// Insert some categories
$sql = "INSERT INTO categories (name) VALUES ('Men'), ('Women'), ('Kids');";
if (!$conn->query($sql)) {
    echo "Error inserting categories: ". $conn->error;
}

// Insert some products
$sql = "INSERT INTO products (name, description, price, category_id) VALUES
    ('T-Shirt', 'A basic t-shirt', 19.99, 1),
    ('Jeans', 'A pair of jeans', 49.99, 1),
    ('Dress', 'A fancy dress', 99.99, 2),
    ('Skirt', 'A skirt', 39.99, 2),
    ('Socks', 'A pair of socks', 9.99, 3);";
if (!$conn->query($sql)) {
    echo "Error inserting products: ". $conn->error;
}

// Close the connection
$conn->close();

echo "Database created and populated successfully.";

