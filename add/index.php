<?php
include("../config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: /login');
}


$query = "SELECT * FROM user_data WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);
if ($user['admin'] == 1) {
    header('location: /admin');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = mysqli_real_escape_string($db, $_POST['content']);
    $image = $_FILES['image']['name'];
    $image_name = uniqid() . basename($image);
    if ($content) {
        if ($image) {
            $query = "INSERT INTO post (fk_user_id, post_data, post_img) VALUES (" . $_SESSION['user_id'] . ", '" . $content . "', '/assets/image/post/" . $image_name . "')";
            mysqli_query($db, $query);
            $target = "../assets/image/post/" . basename($image_name);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Failed to upload image";
            }
        } else {
            $query = "INSERT INTO post (fk_user_id, post_data) VALUES (" . $_SESSION['user_id'] . ", '" . $content . "')";
            mysqli_query($db, $query);
        }
        header('location: /profile');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hive</title>
    <link rel="stylesheet" href="../assets/css/add.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section class="home">
        <section class="sidenav">
            <div class="logo">Hive</div>
            <div class="link_container">
                <ul>
                    <li class="link_list">
                        <a href="/" class="navlink"><i class="fa-solid fa-house"></i><span
                                class="navlink_text">home</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/add" class="navlink"><i class="fa-solid fa-circle-plus" style=""></i><span
                                class="navlink_text">add</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/add-users" class="navlink"><i class="fa-solid fa-user-plus"></i></i><span
                                class="navlink_text">add users</span></a>
                    </li>
                    <li class="link_list">
                        <a href="/profile" class="navlink"><i class="fa-solid fa-circle-user"></i><span
                                class="navlink_text">profile</span></a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="add_post_area">
            <h1>Add new post</h1>
            <form method="post" enctype="multipart/form-data">
                <div class="image-container">
                    <img src="../assets/image/add-image.png" alt="post-preview" class="image-pre">
                    <input type="file" id="image" name="image" accept="image/*" class="image-inp">
                </div>
                <textarea id="content" name="content" rows="3" cols="45" required placeholder="Caption..."></textarea>
                <div class="btn-grp">
                    <a class="btn" href="/">Cancel</a>
                    <input type="submit" value="Add">
                </div>
            </form>
        </section>
    </section>
</body>
<script>
    const imageInp = document.querySelector('.image-inp');
    const imagePre = document.querySelector('.image-pre');
    imageInp.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function () {
                imagePre.setAttribute('src', this.result);
            });
            reader.readAsDataURL(file);
        }
    });
</script>

</html>