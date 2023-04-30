<?php
include('../config.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: /login');
}

if (!isset($_GET['id'])) {
    header('location: /');
}

$post_id = $_GET['id'];
$sql = "SELECT p.*, u.* FROM post p inner join user_data u on u.user_id = p.fk_user_id WHERE p.post_id = '$post_id'";
$result = mysqli_query($db, $sql);
$post = mysqli_fetch_assoc($result);
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
            <h1>Post</h1>
            <?php
            $query = "select * from likes where fk_post_id = " . $post['post_id'] . " AND fk_user_id = " . $_SESSION['user_id'];
            $result2 = mysqli_query($db, $query);
            if (mysqli_num_rows($result2) == 0) {
                $like = "";
            } else {
                $like = "liked";
            }
            $query = "select COUNT(*) from likes where fk_post_id = " . $post['post_id'];
            $result2 = mysqli_query($db, $query);
            $likes = mysqli_fetch_assoc($result2);

            $query = "select c.*, u.* from comments c inner join user_data u on u.user_id = c.fk_user_id where fk_post_id = " . $post['post_id'];
            $result2 = mysqli_query($db, $query);
            if ($post['post_img'] == NULL) {
                echo '<div class="post_container">
                    <div class="post_title">
                <img src="' . $post['profile_link'] . '" alt="profile" draggable="false"/>
                <h6><a href="/profile/index.php?username=' . $post['username'] . '">' . $post['username'] . '</a></h6>
                <button><i class="fa-solid fa-bars"></i></button>
            </div>
            <div class="post_footer">
                <div class="post_caption">
                    <p>
                        ' . $post['post_data'] . '
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
                <i class="fa-regular fa-heart like ' . $like . '" data-id="' . $post['post_id'] . '"></i>
                    <h3 class="like-count">' . $likes['COUNT(*)'] . '</h3>
                    <div class="input_container">
                        <input type="text" placeholder="Comment..." />
                        <button data-id="' . $post['post_id'] . '" class="comment-btn"><i data-id="' . $post['post_id'] . '" class="fa-solid fa-paper-plane" style="transform: rotate(45deg);"></i></button>
                    </div>
                </div>
            </div>
            </div>';
            } else {

                echo '<div class="post_container">
                    <div class="post_title">
                    <img src="' . $post['profile_link'] . '" alt="profile" draggable="false" />
                    <h6><a href="/profile/index.php?username=' . $post['username'] . '">' . $post['username'] . '</a></h6>
                    <button><i class="fa-solid fa-bars"></i></button>
                    </div>
                    <div class="post_img">
                    <img src="' . $post['post_img'] . '" alt="post" draggable="false" />
                    </div>
                    <div class="post_footer">
                    <div class="post_caption">
                    <p>
                    ' . $post['post_data'] . '
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
                    <i class="fa-regular fa-heart like ' . $like . '" data-id="' . $post['post_id'] . '"></i>
                    <h3 class="like-count">' . $likes['COUNT(*)'] . '</h3>
                    <div class="input_container">
                    <input type="text" placeholder="Comment..." />
                    <button data-id="' . $post['post_id'] . '" class="comment-btn"><i data-id="' . $post['post_id'] . '" class="fa-solid fa-paper-plane" style="transform: rotate(45deg);"></i></button>
                    </div>
                    </div>
                    </div>
                    </div>';
            }
            ?>
        </section>
</body>
<script src="../assets/js/home.js"></script>

</html>