<?php
session_start();
include('../config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['report'])) {
        $post_id = $_POST['id'];
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM report WHERE fk_reported_by = $user_id AND fk_post_id = $post_id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            echo "0";
            exit();
        } else {
            $sql = "INSERT INTO report (fk_reported_by, fk_post_id) values (" . $user_id . "," . $post_id . ")";
            if ($db->query($sql) === TRUE) {
                echo "1";
            } else {
                echo "Error";
            }
        }
    }
}
?>