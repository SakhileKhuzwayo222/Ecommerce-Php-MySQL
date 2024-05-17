<?php
include('/xamppf/htdocs/api/db.php');
session_start();

if(isset($_SESSION['admin_logged_in'])){
    header('location: dashboard.php');
    exit;
}

if(isset($_POST['username'])){
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT AdminID, Username, Password, Email, FullName, Role, CreatedAt, LastLogin, Status, Permissions FROM admins WHERE Username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $stmt->bind_result($AdminID, $Username, $hashed_password, $Email, $FullName, $Role, $CreatedAt, $LastLogin, $Status, $Permissions);
        $stmt->store_result();

        if ($stmt->num_rows() == 1) {
            $stmt->fetch();

            if(password_verify($password, $hashed_password)) {
                $_SESSION['AdminID'] = $AdminID;
                $_SESSION['Username'] = $Username;
                $_SESSION['Email'] = $Email;
                $_SESSION['FullName'] = $FullName;
                $_SESSION['Role'] = $Role;
                $_SESSION['Status'] = $Status;
                $_SESSION['Permissions'] = $Permissions;
                $_SESSION['admin_logged_in'] = true;
                header('location: admin_dashboard.php');
            } else {
                header('location: admin_login.php?error=Invalid Password');
            }
        } else {
            header('location: admin_login.php?error=could not verify your account');
        }
    } else {
        header('location: admin_login.php?error=something went wrong');
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
   <link rel="stylesheet" href="/assets/css/styles.css">
</head>
    <body>
        <header>
    <!--nav bar-->
  <nav class="navbar navbar-expand-lg bg-body-tertiary py5 fixed-top">
    <div class="container-fluid">
      <img src="" alt="logo">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-buttons" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.html">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="faq.html">Contact Us</a>
          </li>
          <li class="nav-item">
            <i class="fa-thin fa-cart-shopping"></i>
            <i class="fa-thin fa-user"></i>
          </li>
        </ul>
      </div>
    </div>

  </nav> 
          </header>

          <!--login-->
          <section class="my-5 py-5">
            <div class="container text-center mt-3 pt-5">
              <h2 class="font-weight-bold">Welcome Admin</h2>
              <hr class="mx-auto">
            </div>
            <div class="mx-auto container">
              <form id="login-form" action="admin_login.php" method="POST">
                <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="text" class="form-control" id="login-email" placeholder="email" name="email" required>
                </div>
                  <br>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="password" class="form-control" placeholder="password" id="login-password" name="password" required>
                </div> 
                  <br>
                <div class="form-group">
                <input type="submit" class="btn" href="dashboard.php" name="login-btn" id="login-btn" value="Login">
                </div>
          
                <!-- add forgot password
                <a href="forgot_password.html">Forgot Password?</a>
                -->
            </form>
            </div>
          </section>


        <footer>
            <div class="footer-container">
              <div class="footer-section">
            
              <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: support@pasttimesecommerce.com</p>
                <p>Phone: +1 (800) 123-4567</p>
              </div>
          
              <div class="footer-section">
                <h3>Follow Us</h3>
                <ul class="social-links">
                  <li><a href="#">Facebook</a></li>
                  <li><a href="#">Twitter</a></li>
                  <li><a href="#">Instagram</a></li>
                  <li><a href="#">LinkedIn</a></li>
                </ul>
              </div>
          
            </div>
            
            <div class="copyright">
              <p>&copy; 2024 Past Times Ecommerce. All Rights Reserved.</p>
            </div>
          </footer>
    </body>
</html>

