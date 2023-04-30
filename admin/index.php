<?php
include('../config.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: /login');
}


$query = "SELECT * FROM user_data WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);
if ($user['admin'] == 0) {
    header('location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hive-Admin</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        height: 100vh;
        background-color: #171717;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .center {
        margin: auto;
        width: auto;
        border: 2px solid white;
        padding: 10px;
        height: auto;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 20px;
        padding: 40px 35px;
    }

    h1 {
        color: white;
        text-align: center;
        margin: 0;
        padding: 0;
    }

    .btn {
        background-color: #0055a5;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 10px;
        width: 80%;
    }
</style>

<body>
    <div class="center">
        <h1>Admin Dashboard</h1>
        <a href="/admin/verify" class="btn">
            Verify Accounts
        </a>
        <a href="/admin/reports" class="btn" style=" margin-top:10px">
            Check Reports
        </a>
    </div>
</body>

</html>