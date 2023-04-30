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
if ($user['admin'] == 1) {
    header('location: /admin');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Interests</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/profile.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            gap: 10px;
        }

        a {
            flex: 1;
            text-decoration: none;
            color: white;
        }

        p {
            display: flex;
            align-items: center;
            font-size: 1rem;
            gap: 5px;
        }

        img {
            border-radius: 50%;
            object-fit: cover;
        }

        button {
            background-color: rgb(0, 85, 165);
            border: none;
            outline: none;
            height: 32px;
            cursor: pointer;
            margin-right: 20px;
            font-size: 0.9rem;
            color: #ffffff;
            border-radius: 10px;
            position: relative;
            font-size: 0.8rem;
            padding: 0 12px;
            font-weight: bold;
        }

        .container {
            max-height: 50vh;
            width: 50vw;
            overflow-y: scroll;
            margin: 10px 0;
        }

        i {
            color: rgb(0, 85, 165);
            font-size: medium;
            width: 10px;
            height: 10px;
            display: block;
        }
    </style>
</head>

<body>
    <div>
        <h1>Clubs</h1>
        <p>Get started by following some clubs</p>
        <div class="container">
            <?php
            $query = "SELECT * FROM user_data WHERE verified = 1";
            $result = mysqli_query($db, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $badge = ' <i class="fa-solid fa-certificate" style=""></i>';
                echo "<div class='card'>";
                echo "<img src='" . $row['profile_link'] . "' width='50px' height='50px'>";
                echo "<a href='/profile/?username=" . $row['username'] . "'><p>" . $row['username'] . $badge . "</p></a>";
                echo "<button data-id='" . $row['user_id'] . "'>Follow</button>";
                echo "</div>";
            }
            ?>
        </div>
        <button onclick="window.location.href='/profile'">Next</button>
    </div>
</body>
<script>
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.target.disabled = true;
            let url = "/follow/follow.php";
            let xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText == 1) {
                        e.target.innerHTML = "Requested";
                    }
                    else {
                        e.target.innerHTML = "Followed";
                    }
                }
            };
            xhr.send("id=" + e.target.dataset.id + "&follow=follow");
        })
    })
</script>

</html>