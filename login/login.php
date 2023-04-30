<?php
include("../config.php");
session_start();
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $email = mysqli_real_escape_string($db, $_POST['email']);
   $password = mysqli_real_escape_string($db, $_POST['password']);

   if (empty($email)) {
      array_push($errors, "Email is required");
   }
   if (empty($password)) {
      array_push($errors, "Password is required");
   }

   if (count($errors) == 0) {
      $password = md5($password);
      $query = "SELECT * FROM user_data WHERE email='$email' AND password='$password'";
      $results = mysqli_query($db, $query);
      $user = mysqli_fetch_assoc($results);
      if (mysqli_num_rows($results) == 1) {
         $_SESSION['user_id'] = $user['user_id'];
         $_SESSION['admin'] = $user['admin'];
         if ($user['admin'] == 1) {
            header('location: /admin');
         } else {
            header('location: /index.php');
         }
      } else {
         array_push($errors, "Wrong username/password combination");
      }
   }
}
?>