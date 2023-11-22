<?php
session_start();
include("../../frontend/base/connect_data.php")

$id = $_GET['id'];
$sql = "DELETE FROM news WHERE id='$id';";
mysqli_query($conn,$sql);
header("Location: home.php");

$conn->close();
?>