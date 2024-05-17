<?php

session_start();

if(!isset($_SESSION['Logged_in'])){
  header('location:login.php');
  exit;
}

if(isset($_GET['logout'])){
  unset($_SESSION['logged_in']);
  unset($_SESSION['email']);
  unset($_SESSION['name']);
  unset($_SESSION['user_id']);
  header('location:login.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
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
            <a class="nav-link" href="products.php">Shop</a>
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

          <!--Account-->
          <section class="my-5 py-5">
           <div class="row container mx-auto">
             <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                <h3 class="font-weight-bold">Account info</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p><span><?php if(isset($_SESSION['name'])){echo $_SESSION['name'];} ?></span></p>
                    <p><span><?php if(isset($_SESSION['address'])){echo $_SESSION['address'];} ?></span></p>
                    <p><span><?php if(isset($_SESSION['phone'])){echo $_SESSION['phone'];} ?></span></p>
                    <p><span><?php if(isset($_SESSION['email'])){echo $_SESSION['email'];} ?></span></p>
                    <p><span><?php if(isset($_SESSION['phone'])){echo $_SESSION['phone'];} ?></span></p>
                    <p><span><?php if(isset($_SESSION['country'])){echo $_SESSION['country'];} ?></span></p>
                    <p><span><?php if(isset($_SESSION['province_state'])){echo $_SESSION['province_state'];} ?></span></p>
                    <p><span><?php if(isset($_SESSION['postal_code'])){echo $_SESSION['postal_code'];} ?></span></p>

                    <p> <a href="" id="orders-btn" >Your orders</a></p>
                    <p> <a href="account.php?logout=1" id="logout-btn" >Logout</a></p>
                </div>
             </div>
             <div class="col-lg-6 col-md-12 col-sm-12">
                <form id="account-form" method="post" action="account.php">
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="account-password" placeholder="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" class="form-control" id="account-password-confirm" placeholder="confirm password" name="confirm-password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn" id="change-pass-btn" value="Change Password">
                    </div>
                </form>
             </div>
           </div>
          </section>

          <section class="orders container my-5 py-3">
            <div class="container mt-2">
              <h2 class="font-weight-bold text-center"> Your Orders</h2>
              <hr class="mx-auto">
            </div>
          
            <table class="mt05 pt-5">
              <tr>
                <th>Product</th>
                <th>Date</th>
              </tr>
              
              <tr>
                <td>
                  <div class="product-info">
                    <img src="" alt="product image">
                    <div>
                     <p class="mt-3">White Shoes</p>
                    </div>
                  </div>
                </td>

                <td>
                  <p class="mt-3">10/10/2022</p>
                </td>

              </tr>
             
              
               
            </table>
            
          </section>
<!--Footer-->
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