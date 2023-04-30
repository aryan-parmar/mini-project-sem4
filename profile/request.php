<?php
session_start();
include('../config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['request'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM verification_request WHERE fk_user_id = $user_id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            echo "0";
            exit();
        }else{

            
            $sql = "INSERT INTO verification_request (fk_user_id) values (" . $user_id . ")";
            if ($db->query($sql) === TRUE) {
                echo "1";
            } else {
                echo "Error";
            }
        }
    }
}
?>