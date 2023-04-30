<?php
include('../../config.php');
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
        width: 50vw;
        border: 2px solid white;
        padding: 10px;
        height: 60vh;
        border-radius: 10px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-direction: column;
        gap: 20px;
        padding: 40px 35px;
        overflow-y: scroll;
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
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 10px;
        width: 80%;
        padding: 0 10px;
        height: 40px;
        flex: 0.2;
    }

    .container {
        display: flex;
        justify-content: space-between;
        width: 90%;
        height: 60px;
        align-items: center;
        background: #2d2d2d;
        border-radius: 10px;
        padding: 0 10px;
        gap: 10px;
    }
    .container a{
        color: white;
        text-decoration: none;
        flex: 1;
        margin-left: 20px;
    }
</style>

<body>
    <div class="center">
        <h1>Verify accounts</h1>
        <?php
        $query = "SELECT u.* FROM verification_request v inner join user_data u on u.user_id = v.fk_user_id";
        $result = mysqli_query($db, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='container'>";
            echo "<a href='/profile/?username=" . $row['username'] . "'>" . $row['username'] . "</a>";
            echo "<button class='btn accept' data-id='".$row['user_id']."'>Accept</button>";
            echo "<button class='btn reject' data-id='".$row['user_id']."'>Reject</button>";
            echo "</div>";
        }
        ?>
    </div>
</body>
<script>
    const accept = document.querySelectorAll('.accept');
    const reject = document.querySelectorAll('.reject');
    accept.forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            var xml = new XMLHttpRequest();
            xml.open('POST', '/admin/verify/accept.php', true);
            xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xml.onreadystatechange = function () {
                if (xml.readyState == 4 && xml.status == 200) {
                    if (xml.responseText == 1) {
                        btn.parentElement.remove();
                    }
                    console.log(xml.responseText);
                }
            }
            xml.send('id=' + id);
        })
    })
    reject.forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            var xml = new XMLHttpRequest();
            xml.open('POST', '/admin/verify/reject.php', true);
            xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xml.onreadystatechange = function () {
                if (xml.readyState == 4 && xml.status == 200) {
                    if (xml.responseText == 1) {
                        btn.parentElement.remove();
                    }
                    console.log(xml.responseText);
                }
            }
            xml.send('id=' + id);
        })
    })
    </script>
</html>