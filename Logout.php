<?php
session_start();

if(!isset($_SESSION['logged_in'])){
  header('location:login.php');
  exit;
}

if(isset($_GET['logout'])){

  if(isset($_SESSION['Logged_in'])){
    unset( $_SESSION['Logged_in']);
    unset($_SESSION['email']);
    unset($_SESSION['name']);
    unset($_SESSION['user_id']);

  }
 
  header('location:login.php');
  exit;

}
