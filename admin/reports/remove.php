<?php 
include('../../config.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: /login');
}
if (!isset($_SESSION['admin'])) {
    header('location: /');
}
if ($_SESSION['admin'] == 0) {
    header('location: /');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['id'];
    $query = "delete from post where post_id = $post_id";
    $result = mysqli_query($db, $query);
    if ($result) {
        $query = "delete from likes where fk_post_id = $post_id";
        mysqli_query($db, $query);
        $query = "delete from comments where fk_post_id = $post_id";
        mysqli_query($db, $query);
        $query = "delete from report where fk_post_id = $post_id";
        mysqli_query($db, $query);
        echo 1;
    } else {
        echo 0;
    }
}
?>