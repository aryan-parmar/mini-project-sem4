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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hive</title>
    <link rel="stylesheet" href="../assets/css/add.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section class="home">
        <section class="sidenav">
            <div class="logo">Hive</div>
            <div class="link_container">
                <ul>
                    <li class="link_list">
                        <a href="/" class="navlink"><i class="fa-solid fa-house"></i><span
                                class="navlink_text">home</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/add" class="navlink"><i class="fa-solid fa-circle-plus" style=""></i><span
                                class="navlink_text">add</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/add-users" class="navlink"><i class="fa-solid fa-user-plus"></i></i><span
                                class="navlink_text">add users</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/profile" class="navlink"><i class="fa-solid fa-circle-user"></i><span
                                class="navlink_text">profile</span></a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="add_post_area">
            <h1>Follow requests</h1>
            <?php
            $query = "SELECT * FROM follow WHERE fk_other_user_id = " . $_SESSION['user_id'] . " AND pending = 1";
            $result = mysqli_query($db, $query);
            
            while($row = mysqli_fetch_assoc($result)){
                $query = "SELECT * FROM user_data WHERE user_id = " . $row['fk_user_id'];
                $result2 = mysqli_query($db, $query);
                $user = mysqli_fetch_assoc($result2);

                // $query = "SELECT * FROM follow WHERE fk_user_id = " . $_SESSION['user_id'] . " AND pending = 1 and fk_other_user_id = " . $row['fk_user_id'];
                // $r = mysqli_query($db, $query);
                // if(mysqli_num_rows($r) == 0){

                // }

                echo '<div class="suggestion">
                <img src=' . $user['profile_link'] . ' alt="profile" />
                <div class="data">
                    <h3 class="fullname"><a href="/profile/index.php?username=' . $user['username'] . '">' . $user['fullname'] . '</a></h3>
                    <h3 class="username"><span>@</span>' . $user['username'] . '</h3>
                </div>
                <button class="accept" data-id="' . $user["user_id"] . '" >Accept</button>
                </div>';
                // <button class="follow" data-id="' . $user["user_id"] . '" >Follow</button>'
            }
            ?>
            
        </section>
        <!-- <section class="suggestion_area">
            <div class="suggestion_container">
                <div class="title">Suggestions</div>
                <div class="suggestion_list">
                    <!-- <?php
                    foreach ($users as $user) {
                        echo '<div class="suggestion">
                            <img src=' . $user['profile_link'] . ' alt="profile" />
                            <div class="data">
                                <h3 class="fullname"><a href="/profile/index.php?username=' . $user['username'] . '">' . $user['fullname'] . '</a></h3>
                                <h3 class="username"><span>@</span>' . $user['username'] . '</h3>
                            </div>
                            <button class="follow" data-id="' . $user["user_id"] . '" >Follow</button>'
                            . '</div>';
                    }
                    ?> -->
                </div>
            </div>
        </section> -->
    </section>
</body>
<script src="../assets/js/add-request.js"></script>

</html>