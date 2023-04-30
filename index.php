<?php
include("config.php");
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

$query = "SELECT * FROM user_interest WHERE fk_user_id = " . $_SESSION['user_id'];
$user_interest = [];
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_assoc($result)) {
    array_push($user_interest, $row['fk_interest_id']);
}
$user_array = [];
foreach ($user_interest as $interest) {
    $query = "SELECT ui.fk_user_id
    FROM user_interest ui
    WHERE 
    ui.fk_interest_id =" . $interest
        . " AND ui.fk_user_id <> " . $_SESSION['user_id']
        . " AND ui.fk_user_id NOT IN (
      SELECT f.fk_other_user_id
      FROM follow f
      WHERE f.fk_user_id = " . $_SESSION['user_id']
        . ") LIMIT 10";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        // printf($row);
        array_push($user_array, $row['fk_user_id']);
    }
}
$user_array = array_unique($user_array);
$user_array = array_values($user_array);
$users = [];
foreach ($user_array as $user_id) {
    $query = "SELECT * FROM user_data WHERE user_id = " . $user_id;
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
    array_push($users, $user);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hive</title>
    <link rel="stylesheet" href="./assets/css/home.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
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
                        <a href="#" class="navlink"><i class="fa-solid fa-house"></i><span
                                class="navlink_text">Home</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/add" class="navlink"><i class="fa-solid fa-circle-plus" style=""></i><span
                                class="navlink_text">Add</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/add-users" class="navlink"><i class="fa-solid fa-user-plus"></i></i><span
                                class="navlink_text">Add users</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/profile" class="navlink"><i class="fa-solid fa-circle-user"></i><span
                                class="navlink_text">Profile</span></a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="post_area">

            <?php
            $query = "SELECT ud.profile_link, ud.username, ud.fullname, p.* FROM post as p, user_data as ud WHERE p.fk_user_id = " . $_SESSION['user_id'] . "AND ud.user_id = p.fk_user_id ORDER BY post_id DESC LIMIT 20";
            $query = "SELECT p.*, u.* 
            FROM post p 
            INNER JOIN follow f ON p.fk_user_id = f.fk_other_user_id AND f.pending = 0
            INNER JOIN user_data u ON p.fk_user_id = u.user_id 
            WHERE f.fk_user_id = " . $_SESSION['user_id'] . " AND u.user_id = p.fk_user_id
            ORDER BY post_id DESC LIMIT 10
            ";

            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 0) {
                echo '<div class="post_container" style="color: #dcdcdc">
                    NO POSTS FOR NOW FOLLOW SOMEONE TO VIEW THEIR POSTS </div>
                    ';
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $query = "select * from likes where fk_post_id = " . $row['post_id'] . " AND fk_user_id = " . $_SESSION['user_id'];
                    $result2 = mysqli_query($db, $query);
                    if (mysqli_num_rows($result2) == 0) {
                        $like = "";
                    } else {
                        $like = "liked";
                    }
                    $query = "select COUNT(*) from likes where fk_post_id = " . $row['post_id'];
                    $result2 = mysqli_query($db, $query);
                    $likes = mysqli_fetch_assoc($result2);

                    $query = "select c.*, u.* from comments c inner join user_data u on u.user_id = c.fk_user_id where fk_post_id = " . $row['post_id'];
                    $result2 = mysqli_query($db, $query);

                    $badge = '';
                    if ($row['verified'] == 1) {
                        $badge = '<span class="material-symbols-outlined">new_releases</span>';
                    }
                    if ($row['post_img'] == NULL) {
                        echo '<div class="post_container">
                                <div class="post_title">
                            <img src="' . $row['profile_link'] . '" alt="profile" draggable="false"/>
                            <h6><a href="/profile/index.php?username=' . $row['username'] . '">' . $row['username'] . $badge . '</a></h6>
                            <button><i class="fa-solid fa-bars"></i></button>
                        </div>
                        <div class="post_footer">
                            <div class="post_caption">
                                <p>
                                    ' . $row['post_data'] . '
                                </p>';

                        while ($comment = mysqli_fetch_assoc($result2)) {
                            echo '<div class="comment_container">
                                <div class="comment_title">
                                    <img src="' . $comment['profile_link'] . '" alt="profile" draggable="false" />
                                    <h6><a href="/profile/index.php?username=' . $comment['username'] . '">' . $comment['username'] . '</a></h6>
                                        <p>
                                            ' . $comment['comment'] . '
                                        </p>
                                    </div>
                            </div>';
                        }

                        echo '
                            </div>
                            <div class="post_interections">
                            <i class="fa-regular fa-heart like ' . $like . '" data-id="' . $row['post_id'] . '"></i>
                                <h3 class="like-count">' . $likes['COUNT(*)'] . '</h3>
                                <a href="/post/?id=' . $row['post_id'] . '"><i class="fa-regular fa-comment comment"></i></a>
                                <div class="input_container">
                                    <input type="text" placeholder="Comment..." />
                                    <button data-id="' . $row['post_id'] . '" class="comment-btn"><i data-id="' . $row['post_id'] . '" class="fa-solid fa-paper-plane" style="transform: rotate(45deg);"></i></button>
                                </div>
                            </div>
                        </div>
                        </div>';
                    } else {
                        echo '<div class="post_container">
                        <div class="post_title">
                        <img src="' . $row['profile_link'] . '" alt="profile" draggable="false" />
                        <h6><a href="/profile/index.php?username=' . $row['username'] . '">' . $row['username'] . $badge . '</a></h6>
                        <button><i class="fa-solid fa-bars"></i></button>
                        </div>
                        <div class="post_img">
                        <img src="' . $row['post_img'] . '" alt="post" draggable="false" />
                        </div>
                        <div class="post_footer">
                        <div class="post_caption">
                        <p>
                        ' . $row['post_data'] . '
                        </p>';

                        while ($comment = mysqli_fetch_assoc($result2)) {
                            echo '<div class="comment_container">
                                <div class="comment_title">
                                    <img src="' . $comment['profile_link'] . '" alt="profile" draggable="false" />
                                    <h6><a href="/profile/index.php?username=' . $comment['username'] . '">' . $comment['username'] . '</a></h6>
                                        <p>
                                            ' . $comment['comment'] . '
                                        </p>
                                    </div>
                            </div>';
                        }

                        echo '
                        </div>
                        <div class="post_interections">
                        <i class="fa-regular fa-heart like ' . $like . '" data-id="' . $row['post_id'] . '"></i>
                        <h3 class="like-count">' . $likes['COUNT(*)'] . '</h3>
                        <a href="/post/?id=' . $row['post_id'] . '"><i class="fa-regular fa-comment comment"></i></a>
                        <div class="input_container">
                        <input type="text" placeholder="Comment..." />
                        <button data-id="' . $row['post_id'] . '" class="comment-btn"><i data-id="' . $row['post_id'] . '" class="fa-solid fa-paper-plane" style="transform: rotate(45deg);"></i></button>
                        </div>
                        </div>
                        </div>
                        </div>';
                    }
                }

            }
            ?>
        </section>
        <section class="suggestion_area">
            <div class="suggestion_container">
                <div class="title">Suggestions</div>
                <div class="suggestion_list">
                    <?php
                    foreach ($users as $user) {
                        $badge = '';
                        if ($user['verified'] == 1) {
                            $badge = '<span class="material-symbols-outlined small">new_releases</span>';
                        }

                        echo '<div class="suggestion">
                            <img src="' . $user['profile_link'] . '" alt="profile" />
                            <div class="data">
                                <h3 class="fullname"><a href="/profile/index.php?username=' . $user['username'] . '">' . $user['fullname'] . '</a></h3>
                                <h3 class="username"><span>@</span>' . $user['username'] . $badge . '</h3>
                            </div>
                            <button class="follow" data-id="' . $user["user_id"] . '" >Follow</button>'
                            . '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </section>
</body>
<script src="./assets/js/home.js"></script>

</html>