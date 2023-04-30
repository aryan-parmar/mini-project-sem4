<?php include('./signup.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hive - signup</title>
  <link rel="stylesheet" href="../assets/css/signup.css" />
</head>

<body>
  <div class="wrapper">
    <div class="illustration">
      <img src="../assets/image/bg.png" alt="signup" />
    </div>
    <div id="signup" class="signup">
      <div class="signup_wrapper">
        <h2>SIGNUP WITH <span class="logo">Hive</span></h2>
        <form id="signup-form" method="POST" class="form" onsubmit="return validateEmail()">
          <?php include('../errors.php'); ?>
          <div class="input_container">
            <label for="username" class="ulabel">Username</label>
            <input type="text" name="username" placeholder="Username" required />
          </div>
          <div class="input_container">
            <label for="fullname" class="flabel">Fullname</label>
            <input type="text" name="fullname" placeholder="Fullname" required class="fni" />
          </div>
          <div class="input_container">
            <label for="email" class="elabel">Email</label>
            <input type="email" name="email" placeholder="Email" pattern="[\w.%+-]+@somaiya\.edu" required />
          </div>
          <div class="input_container">
            <label for="password" class="plabel">Password</label>
            <input type="password" name="password" placeholder="Password" required />
          </div>
          <input type="submit" value="signup" required />
        </form>
        <h4>already a user ? <a href="/login">login</a></h4>
      </div>
    </div>
  </div>
</body>
<script src="../assets/js/signup.js"></script>

</html>