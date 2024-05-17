<?php
include('db.php');
include('/xamppf/htdocs/admin/getOrders.php');
include('/xamppf/htdocs/api/createTable.php');
include('/xamppf/htdocs/admin/updateUsers.php')

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
   <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>

  <!--nav bar-->
  <nav class="navbar navbar-expand-lg bg-body-tertiary py2 fixed-top">
    <div class="container-fluid">
      <img src="/assets/images/Screenshot_8-5-2024_44043_www.bing.com.jpeg" alt="logo">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="nav-buttons" id="navbarNavDropdown">
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
              <i class="fas fa-shopping-cart"></i>
              <i class="fas fa-user"><</i>
          </li>
        </ul>
      </div>
    </div>
   

  </nav> 

<div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">Products</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Welcome, Admin!</h1>
        <div class="summary">
            <p>Total Users: <?php echo getTotalUsers($conn); ?></p>
            <p>Total Products: <?php echo getTotalProducts($conn); ?></p>
            <p>Total Orders: <?php echo getTotalOrders($conn); ?></p>
        </div>
    </div>