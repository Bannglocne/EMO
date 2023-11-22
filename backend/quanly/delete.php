<?php
session_start();
include("../../frontend/base/connect_data.php")

$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id='$id';";
mysqli_query($conn,$sql);
header("Location: quanly_users.php");

$conn->close();
?>