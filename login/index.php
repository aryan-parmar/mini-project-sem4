<?php include("./login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hive - login</title>
  <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>
  <div class="wrapper">
    <div class="illustration">
      <img src="../assets/image/bg.png" alt="login" />
    </div>
    <div id="login" class="login">
      <div class="login_wrapper">
        <h2>LOG INTO <span class="logo">Hive</span></h2>
        <form class="form" method="post" onsubmit="return validate()">
          <?php include('../errors.php'); ?>
          <div class="input_container">
            <input type="email" name="email" placeholder="Email" required id="email" pattern="[\w.%+-]+@somaiya\.edu" />
            <label for="email">Email</label>
          </div>
          <div class="input_container">
            <input type="password" name="password" placeholder="Password" required id="password" />
            <label for="password">Password</label>
          </div>
          <input type="submit" value="Login" />
        </form>
        <h4>new to hive ? <a href="/signup">register</a></h4>
      </div>
    </div>
  </div>
</body>
<script src="./assets/js/validator.js"></script>
</html>