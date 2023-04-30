<?php
include("../config.php");
session_start();

if (isset($_SESSION['user_id'])) {
    if (isset($_POST['follow'])) {
        $query = "SELECT private FROM user_data WHERE user_id = " . $_POST['id'] . " LIMIT 1";
        $result = mysqli_query($db, $query);
        $result = mysqli_fetch_assoc($result);
        echo $result['private'];
        if ($result['private'] == 0) {
            $query = "INSERT INTO follow (fk_user_id, fk_other_user_id, pending) VALUES (" . $_SESSION['user_id'] . ", " . $_POST['id'] . ", 0)";
            mysqli_query($db, $query);
        }
        else {
            $query = "INSERT INTO follow (fk_user_id, fk_other_user_id, pending) VALUES (" . $_SESSION['user_id'] . ", " . $_POST['id'] . ", 1)";
            mysqli_query($db, $query);
        }
    }
}
?>