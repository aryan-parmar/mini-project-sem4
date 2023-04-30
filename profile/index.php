<?php
include('../config.php');
session_start();
$other = 0;
if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: /login');
}
$follow = 2;
if (isset($_GET['username'])) {


    $query = "SELECT * FROM user_data WHERE username='" . $_GET['username'] . "'";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user['user_id'] == $_SESSION['user_id']) {
        header('location: /profile');
    } else {
        $other = 1;
    }
    $query = "SELECT * FROM follow WHERE fk_user_id='" . $_SESSION['user_id'] . "' AND fk_other_user_id='" . $user['user_id'] . "'";
    $result = mysqli_query($db, $query);
    $follows = mysqli_fetch_assoc($result);
    if ($follows) {
        $follow = 1;
    } else {
        $follow = 0;
    }
} else {
    $query = "SELECT * FROM user_data WHERE user_id='" . $_SESSION['user_id'] . "'";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hive</title>
    <link rel="stylesheet" href="../assets/css/profile.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
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
        <section class="profile_area">
            <div class="profile">
                <div class="profile_img">
                    <img src='<?php echo $user['profile_link'] ?>' alt="profile" />
                    <div class="profile_name">
                        <h1>
                            <?php echo $user['fullname'] ?>
                        </h1>
                        <p>
                            <?php
                            $badge = '';
                            if ($user['verified'] == 1) {
                                $badge = '<span class="material-symbols-outlined small">new_releases</span>';
                            }
                            echo $user['username'] . $badge ?>
                        </p>
                        <div class="follow-container">
                            <?php
                            if (isset($_GET['username'])) {
                                echo "<a href='/follower?username=" . $_GET['username'] . "'>";
                            } else {
                                echo "<a href='/follower'>";
                            }
                            ?>
                            <h4>followers <span>
                                    <?php
                                    if (isset($_GET['username'])) {
                                        $query = "SELECT * FROM user_data WHERE username = '" . $_GET['username'] . "'";
                                        $result = mysqli_query($db, $query);
                                        $res = mysqli_fetch_assoc($result);
                                        $query = "SELECT COUNT(*) FROM follow where pending=0 AND fk_other_user_id=" . $res['user_id'];
                                    } else {
                                        $query = "SELECT COUNT(*) FROM follow where pending=0 AND fk_other_user_id=" . $_SESSION['user_id'];
                                    }
                                    $result = mysqli_query($db, $query);
                                    $res = mysqli_fetch_assoc($result);
                                    echo $res['COUNT(*)']; ?>
                                </span></h4></a>

                            <?php
                            if (isset($_GET['username'])) {
                                echo "<a href='/following?username=" . $_GET['username'] . "'>";
                            } else {
                                echo "<a href='/following'>";
                            }
                            ?>
                            <h4>following <span>
                                    <?php
                                    if (isset($_GET['username'])) {
                                        $query = "SELECT * FROM user_data WHERE username = '" . $_GET['username'] . "'";
                                        $result = mysqli_query($db, $query);
                                        $res = mysqli_fetch_assoc($result);
                                        $query = "SELECT COUNT(*) FROM follow where pending=0 AND fk_user_id=" . $res['user_id'];
                                    } else {
                                        $query = "SELECT COUNT(*) FROM follow where pending=0 AND fk_user_id=" . $_SESSION['user_id'];
                                    }
                                    $result = mysqli_query($db, $query);
                                    $res = mysqli_fetch_assoc($result);
                                    echo $res['COUNT(*)']; ?>
                                </span></h4>
                            </a>
                        </div>
                    </div>
                    <?php if ($other == 0) {
                        echo '<button class="profile_edit">
                        <a href="/profile/edit.php" class="">Edit Profile</a>
                    </button>';
                    } else {
                        if ($follow == 0) {
                            echo '<button class="profile_edit" data-id="' . $user["user_id"] . '" data-follow="' . $follow . '">
                            Follow
                        </button>';
                        } else if ($follows['pending'] == 1) {
                            echo '<button class="profile_edit" data-id="' . $user["user_id"] . '" data-follow="' . $follow . '">
                            Pending
                        </button>';
                        } else {
                            echo '<button class="profile_edit" data-id="' . $user["user_id"] . '" data-follow="' . $follow . '">
                            Unfollow
                        </button>';
                        }
                    }
                    if($user['verified']==1){
                        echo '<button class="profile_edit"><a href="mailto:'.$user['email'].'" class="">
                            Contact
                        </a></button>';
                    }
                    ?>
                </div>
                <div class="profile_bio">
                    <!-- <p> -->
                    <pre><?php echo $user['bio'] ?></pre>
                    <!-- </p> -->
                </div>
            </div>
            <div class="post_area">

                <?php
                if ($follow != 2 && ($user['private'] == 1 && ($follow == 0 || $follows['pending'] == 1))) {
                    echo '<div class="post_container">
                    <div class="post_profile">
                        <img src="' . $user["profile_link"] . '" alt="profile" />
                    </div>
                    <div class="post_footer" style="border-top-right-radius: 10px">
                        <div class="post_caption">
                            <p>
                                This account is private
                            </p>
                        </div>
                    </div>
                </div>';
                } else {
                    $query = "SELECT * FROM post WHERE fk_user_id='" . $user['user_id'] . "' ORDER BY post_id DESC";
                    $result = mysqli_query($db, $query);
                    if (mysqli_num_rows($result) == 0) {
                        echo '<div class="post_container">
                    <div class="post_profile">
                        <img src="' . $user["profile_link"] . '" alt="profile" />
                    </div>
                    <div class="post_footer" style="border-top-right-radius: 10px">
                        <div class="post_caption">
                            <p>
                                No posts yet
                            </p>
                        </div>
                    </div>
                </div>';
                    }
                    while ($post = mysqli_fetch_assoc($result)) {
                        $o = '<div class="post_delete" data-id=' . $post["post_id"] . '>
                        <i class="fa-regular fa-trash-can"></i>
                        </div>';
                        if (isset($_GET['username'])) {
                            $o = '<div class="post_report" data-id=' . $post["post_id"] . '>
                            <i class="fa-regular fa-flag"></i>
                            </div>';
                        }
                        if ($post['post_img'] == NULL) {
                            echo '<div class="post_container">
                        <div class="post_profile">
                            <img src="' . $user["profile_link"] . '" alt="profile" />
                        </div>
                        ' . $o . '
                        <div class="post_footer" style="border-top-right-radius: 10px">
                            <div class="post_caption">
                                <p>
                                    ' . $post['post_data'] . '
                                </p>
                            </div>
                        </div>
                    </div>';

                        } else {

                            echo '<div class="post_container">
                            <div class="post_profile">
                            <img src="' . $user["profile_link"] . '" alt="profile" />
                            </div>
                            ' . $o . '
                            <div class="post_img">
                            <img src="' . $post["post_img"] . '" alt="post" />
                            </div>
                            <div class="post_footer">
                            <div class="post_caption">
                            <p>
                            ' . $post['post_data'] . '
                            </p>
                            </div>
                            </div>
                            </div>';
                        }
                    }
                }
                ?>
            </div>
        </section>
    </section>
</body>
<script src="../assets/js/profile.js"></script>

</html>