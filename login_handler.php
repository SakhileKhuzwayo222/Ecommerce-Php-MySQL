<?php
session_start();

include('api/db.php');

if(isset($_POST['login-btn'])){
    
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT user_id, name, password, email FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);

  if ($stmt->execute()) {
    $stmt->bind_result($user_id, $name, $hashed_password, $email);
    $stmt->store_result();

    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      if(password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['Logged_in'] = true;
        header('location: account.php');
     } else {
        header('location: Login.php?error=Invalid Password');
    }
    } else {
      header('location: Login.php?error=could not verify your account');
    }
  } else {
    header('location: Login.php?error=something went wrong');
  }
}
