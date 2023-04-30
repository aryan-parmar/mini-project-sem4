<?php 
session_start();
include('../config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['delete'])){
        $post_id = $_POST['id'];
        $user_id = $_SESSION['user_id'];
        $sql = "DELETE FROM post WHERE post_id = $post_id AND fk_user_id = $user_id";
        if ($db->query($sql) === TRUE) {
            echo "1";
        } else {
            echo "Error";
        }
    }
}

?>