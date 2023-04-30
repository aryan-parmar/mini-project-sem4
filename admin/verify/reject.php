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
    $user_id = $_POST['id'];
    $query = "UPDATE user_data SET verified = 0 WHERE user_id = " . $user_id;
    mysqli_query($db, $query);
    $query = "Delete from verification_request WHERE fk_user_id = " . $user_id;
    mysqli_query($db, $query);
    echo 1;
}
?>