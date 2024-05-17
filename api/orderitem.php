<? 
//write api endpoint for the following column names 	OrderItemID	OrderID	ProductID	Quantity	Price
require_once 'db.php';  
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// GET /api/orderitem (Retrieve order items)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/orderitem') {
    $sql = "SELECT OrderItemID, OrderID, ProductID, Quantity, Price FROM orderitem";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $orderitems = array();
        while($row = $result->fetch_assoc()) {
            $orderitems[] = $row;
        }
        echo json_encode($orderitems);
    } else {
        echo json_encode(array());
    }
}   

// POST /api/orderitem (Create new order item)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/orderitem') {
    $OrderID = $_POST['OrderID'];
    $ProductID = $_POST['ProductID'];
    $Quantity = $_POST['Quantity'];
    $Price = $_POST['Price'];
    $sql = "INSERT INTO orderitem (OrderID, ProductID, Quantity, Price) VALUES ('$OrderID', '$ProductID', '$Quantity', '$Price')";
    if ($conn->query($sql) === TRUE) {
        echo "New order item created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}       

// PUT /api/orderitem/{id} (Update order item)
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && $_SERVER['REQUEST_URI'] === '/api/orderitem/{id}') {
    $id = $_GET['id'];
    $OrderID = $_POST['OrderID'];
    $ProductID = $_POST['ProductID'];
    $Quantity = $_POST['Quantity'];
    $Price = $_POST['Price'];
    $sql = "UPDATE orderitem SET OrderID = '$OrderID', ProductID = '$ProductID', Quantity = '$Quantity', Price = '$Price' WHERE OrderItemID = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Order item updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}