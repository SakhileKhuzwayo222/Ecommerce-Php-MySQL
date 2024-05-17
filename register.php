<?php

/* Check if the session is active or not
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}*/

// Check if the user is already logged in
if (isset($_SESSION['Logged_in']) && $_SESSION['Logged_in']) {
  header('location: account.php');
  exit();
}

// Include the database connection script
include('api/db.php');

// Check if the register button is pressed
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $province_state = $_POST['province_state']; // change city to province_state
  $postal_code = $_POST['postal_code'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm-password'];

  // Check if the passwords match
  if ($confirm_password !== $password) {
    header('location: register.php?error=passwords dont match');
    exit();
  }

  // Check if the password is at least 6 characters long
  if (strlen($password) < 6) {
    header('location: register.php?error=password must be at least 6 characters');
    exit();
  }

  // Check if there is a user with this email
  $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE email = ?");
  if (!$stmt1) {
    echo "Prepare failed: (". $conn->errno. ") ". $conn->error;
    exit();
  }

  $stmt1->bind_param('s', $email);
  $stmt1->execute();
  $stmt1->bind_result($num_rows);
  $stmt1->fetch();
  $stmt1->close();

  // Check if there is a user registered with this email
  if ($num_rows !== 0) {
    header('location: register.php?error=user with this email already exists');
    exit();
  }

  // Create a new user
  $stmt = $conn->prepare("INSERT INTO users (name, email, password, address, phone, province_state, postal_code) VALUES (?,?,?,?,?,?,?)"); // change city to province_state
  if (!$stmt) {
    echo "Prepare failed: (". $conn->errno. ") ". $conn->error;
    exit();
  }

  $hashed_password = password_hash($password, PASSWORD_BCRYPT);
  $stmt->bind_param("sssssss", $name, $email, $hashed_password, $address, $phone, $province_state, $postal_code); // change city to province_state
  $stmt->execute();
  
  if ($stmt->errno) {
      echo "Execution failed.<br>";
      header('location: register.php?error=could not create an account at the moment');
      $stmt->close();
      exit; // stop executing the script
  }else {
    echo "Execution success.<br>";
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['province_state'] = $province_state; // change city to province_state
    $_SESSION['postal_code'] = $postal_code;
    $_SESSION['Logged_in'] = true;
    header('location: account.php?message=registered successfully');
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            <a class="nav-link" aria-current="page" href="index.html">Home</a>
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

          <!--Signup-->
          <section class="my-5 py-5">
                <div class="container text-center mt-3 pt-5">
                    <h2 class="font-weight-bold">Register</h2>
                    <hr class="mx-auto">
                </div>

                <div class="mx-auto container">
                    <form id="register-form" action="register.php" method="POST">
                      <p style="color: red;"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
                      <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="register-name" placeholder="Name" name="name" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="username">Email:</label>
                            <input type="email" class="form-control" id="register-email" placeholder="Email" name="email" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="phone">Phone number:</label>
                            <input type="tel" class="form-control" id="register-number" placeholder="Phone Number" name="phone" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" placeholder="Password" id="register-password" name="password" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="password">Password Confirmation:</label>
                            <input type="password" class="form-control" placeholder="Confirm Password" id="register-confirm-password" name="confirm-password" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea class="form-control" id="address" placeholder="Address" name="address" required></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="country">Country:</label>
                            <input type="text" class="form-control" id="country" placeholder="Country" name="country" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="state">Province/State:</label>
                            <input type="text" class="form-control" id="state" placeholder="Province/State" name="province_state" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="zip">Postal Code:</label>
                            <input type="text" class="form-control" id="zip" placeholder="Postal Code" name="postal_code" required>
                        </div>
                        <br>
                        <div class="form-group">
                        <input type="submit" name="register" class="btn" id="register-btn" value="Register">
                        </div>
                    <div class="form-group">
                    <a id="login-url" class="btn"  href="Login.php">Do you have an account? Login</a>
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