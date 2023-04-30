<?php 
session_start();
include('../config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['comment'])){
        $post_id = $_POST['id'];
        $comment = $_POST['comment'];
        $user_id = $_SESSION['user_id'];
        
        if($comment == ''){
            echo '-1';
        }else{
            $sql = "INSERT INTO comments (fk_user_id, fk_post_id, comment) values (".$user_id.",".$post_id.",'".$comment."')";

            if ($db->query($sql) === TRUE) {
                echo "1";
            } else {
                echo "Error";
            }
        }
    }
}
?>