<?php
include("../config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM likes WHERE fk_post_id = $post_id AND fk_user_id = $user_id";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $query = "DELETE FROM likes WHERE fk_post_id = $post_id AND fk_user_id = $user_id";
        $result = mysqli_query($db, $query);
        if ($result) {
            echo "1";
        } else {
            echo "error";
        }
    } else {
        $query = "INSERT INTO likes (fk_post_id, fk_user_id) VALUES ($post_id, $user_id)";
        $result = mysqli_query($db, $query);
        if ($result) {
            echo "2";
        } else {
            echo "error";
        }
    }
}

?>