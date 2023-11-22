<?php
session_start();
include("../../frontend/base/connect_data.php")

if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $avatars = $_FILES['avatar'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $status = $_POST['status'];

    if ($avatars['error'] == 0) {
        $extension = pathinfo($avatars['name'],PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $allows = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allows)) {
            $error = 'File upload phải là ảnh';
            $_SESSION['error_change_news'] = $error;
            header('Location: change_news.php?id='.$id);
        }
        $size_b = $avatars['size'];
        $size_mb = $size_b / 1024 / 1024;
        if ($size_mb > 2) {
            $error = 'File upload ko đc vượt quá 2 Mb';
            $_SESSION['error_change_news'] = $error;
            header('Location: change_news.php?id='.$id);
        }
    }
    if (empty($error)) {
        $filename = '';
        if ($avatars['error'] == 0) {
            $dir_upload = 'uploads';
            if (!file_exists($dir_upload)) {
                mkdir('../../'.$dir_upload);
            }
            $filename = time() . '-' . $avatars['name'];
            $is_upload = move_uploaded_file($avatars['tmp_name'],"../../$dir_upload/$filename");
            if ($is_upload) {
                // $result .= "<img src='$dir_upload/$filename' width='100px'>";
                $sql = "UPDATE news SET avatars='$filename', title='$title',description='$description', content='$content', status='$status' WHERE id='$id'";
                mysqli_query($conn,$sql);
                header("Location: home.php");
                exit();
            }
        }
        
    }
    
}
$conn->close();
?>