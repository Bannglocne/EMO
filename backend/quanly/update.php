<?php
session_start();
include("../../frontend/base/connect_data.php")

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $sql = "UPDATE users SET username='$username',email='$email', role='$role' WHERE id='$id'";
    mysqli_query($conn,$sql);
    header("Location: detail.php?id=$id");
    exit();
}
$conn->close();
?>