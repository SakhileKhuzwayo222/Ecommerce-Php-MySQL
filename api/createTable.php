<?
include('db.php');

# Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clothingstore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS users (
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    address VARCHAR(255),
    phone VARCHAR(255),
    country VARCHAR(255),
    state VARCHAR(255),
    postal_code VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Populate the table
$file = fopen("/c:/xampp/htdocs/api/userData.txt", "r") or die("Unable to open file!");

while(!feof($file)) {
    $line = fgets($file);
    $data = explode(",", $line);

    $name = $data[0];
    $email = $data[1];
    $password = $data[2];
    $address = $data[3];
    $phone = $data[4];
    $country = $data[5];
    $state = $data[6];
    $postal_code = $data[7];

    $sql = "INSERT INTO users (name, email, password, address, phone, country, state, postal_code)
    VALUES ('$name', '$email', '$password', '$address', '$phone', '$country', '$state', '$postal_code')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

fclose($file);



// Commit the changes
$conn->commit();

// Close the connection
$conn->close();
