<?php
include("../base/check_session.php");
include("../base/connect_data.php")

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $camxuc = $_POST['camxuc'];
    $content = $_POST['content'];
    $chedo = $_POST['chedo'];
    $id = $_GET['id'];
    $sql = "UPDATE journals SET emotion='$camxuc', content='$content', public='$chedo' WHERE id='$id'";
    mysqli_query($conn,$sql);
    header("Location: read_journal.php?id=$id");
    exit();
}
$conn->close();
?>