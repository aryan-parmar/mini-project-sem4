<?php
include("../config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: /login');
}


$query = "SELECT * FROM user_data WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);
if($user['admin'] == 1){
  header('location: /admin');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $query = "DELETE FROM user_interest WHERE fk_user_id = " . $_SESSION['user_id'];
  $result = mysqli_query($db, $query);
  $interests = $_POST['interests'];
  foreach ($interests as $interest) {
    $query = "INSERT INTO user_interest (fk_user_id, fk_interest_id) VALUES ('" . $_SESSION['user_id'] . "', '" . $interest . "')";
    $result = mysqli_query($db, $query);
  }
  if(isset($_GET['redirect'])){
    header('location: /interest/club.php');
  }else{
    header('location: /');
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Interests</title>
  <style>
    ::-webkit-scrollbar {
      width: 2.5px;
    }

    ::-webkit-scrollbar-track {
      backdrop-filter: blur(15px) saturate(200%);
      -webkit-backdrop-filter: blur(15px) saturate(200%);
      background-color: rgba(var(--foreground-color-rgb), 0.75);
      border-bottom: 1px solid rgba(var(--border-color-rgb), 0.2);
    }

    ::-webkit-scrollbar-thumb {
      background: rgba(207, 207, 207, 0.1882352941);
    }

    body {
      background-color: #171717;
      color: white;
      font-family: Arial, sans-serif;
      font-size: 16px;
      line-height: 1.5;
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    form {
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="submit"] {
      border: 1.5px solid #313131;
      border-radius: 5px;
      padding: 0 10px;
      font-size: 1rem;
      background: #282828;
      color: #e7e7e7;
      height: 40px;
      outline: none;

    }

    input[type="checkbox"] {
      margin-right: 10px;
    }

    input[type="submit"] {
      background-color: #ff9655;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 16px;
      padding: 10px;
      transition: background-color 0.3s ease;
      border-radius: 10px;
      color: #171717;
      font-weight: 700;
    }

    input[type="submit"]:hover {
      background-color: #ffad83;
    }

    .card {
      background-color: #2c2c2c;
      border-radius: 10px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      padding: 10px;
    }

    .container {
      height: 60vh;
      width: 50vw;
      overflow-y: scroll;
    }
  </style>
</head>

<body>
  <div>
    <h1>Interests</h1>
    <p>What are your interests?</p>
    <?php
    $query = "SELECT * FROM interests";
    $result = mysqli_query($db, $query);
    if (isset($_GET['search'])) {
      $search = mysqli_real_escape_string($db, $_GET['search']);
      $query .= " where interest LIKE '%" . $search . "%'";
    }
    $result = mysqli_query($db, $query);

    $user_interests_query = "SELECT * FROM user_interest WHERE fk_user_id =" . $_SESSION['user_id'];

    $user_interests_result = mysqli_query($db, $user_interests_query);

    $user_interests = array();

    while ($row = mysqli_fetch_assoc($user_interests_result)) {
      $user_interests[] = $row['fk_interest_id'];
    }
    echo "<form method='GET'>";
    echo "<input type='text' name='search' placeholder='Search interests'>";
    echo "<input type='submit' value='Search'>";
    echo "</form>";
    echo "<div class='container'>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<form method='POST'>";
      if (in_array($row['interest_id'], $user_interests)) {
        echo "
      <div class='card'>
      <input type='checkbox' name='interests[]' value='" . $row['interest_id'] . "' id='" . $row['interest_id']
          . "'checked >"
          . "<label for='" . $row['interest_id'] . "'>" . $row['interest']
          . "</label>"
          . "</div>";
      } else {
        echo "
        <div class='card'>
        <input type='checkbox' name='interests[]' value='" . $row['interest_id'] . "' id='" . $row['interest_id']
          . "'>"
          . "<label for='" . $row['interest_id'] . "'>" . $row['interest']
          . "</label>"
          . "</div>";
      }
    }
    echo "</div>";
    echo "<input type='submit' value='Save' >";
    echo "</form>";
    ?>
  </div>
</body>

</html>