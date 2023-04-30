<?php
include("../config.php");
session_start();

if (isset($_SESSION['user_id'])) {
    if (isset($_POST['unfollow'])) {
        $query = "SELECT private FROM user_data WHERE user_id = " . $_POST['id'] . " LIMIT 1";
        $result = mysqli_query($db, $query);
        $result = mysqli_fetch_assoc($result);
        if ($result) {
            $query = "DELETE FROM follow WHERE fk_user_id = " . $_SESSION['user_id'] . " AND fk_other_user_id = " . $_POST['id'];
            mysqli_query($db, $query);
            echo 1;
        }
    }
}
?>