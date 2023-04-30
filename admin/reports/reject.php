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
    $query = "DELETE from report where fk_post_id = $post_id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo 0;
        exit();
    }
    echo 1;
}
?>