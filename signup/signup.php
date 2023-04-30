<?php
include("../config.php");
session_start();
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($fullname)) {
    array_push($errors, "Fullname is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }
  $user_check_query = "SELECT * FROM user_data WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  if (count($errors) == 0) {
    $hashpassword = md5($password);
    $query = "INSERT INTO user_data (username, email, password, fullname) 
  			  VALUES('$username', '$email', '$hashpassword', '$fullname')";
    mysqli_query($db, $query);
    $user_check_query = "SELECT * FROM user_data WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['success'] = "You are now logged in";
    header('location: /interest/?redirect=true');
  }
}
?>