<?php
include("../config.php");
session_start();

if (isset($_SESSION['user_id'])) {
    if (isset($_POST['accept'])) {
        $query = "Select * FROM follow WHERE fk_user_id = " . $_POST['id'] . " AND fk_other_user_id = " . $_SESSION['user_id'] . " LIMIT 1";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) == 1){
            if(mysqli_fetch_assoc($result)['pending'] == 1){
                $query = "UPDATE follow SET pending = 0 WHERE fk_user_id = " . $_POST['id'] . " AND fk_other_user_id = " . $_SESSION['user_id'];
                mysqli_query($db, $query);
                echo 1;
            }
            else {
                echo "error";
            }
            $query = "UPDATE follow SET pending = 0 WHERE fk_user_id = " . $_POST['id'] . " AND fk_other_user_id = " . $_SESSION['user_id'];
            mysqli_query($db, $query);
        }
        else {
            echo "error";
        }
    }
}
?>