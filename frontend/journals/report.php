<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: ../accounts/login.php");
    exit();
}
//Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id='$id';";
$result = $conn->query($sql);
if($result->num_rows>0)
{
    while($row=$result->fetch_assoc())
    {
        $report = $row['report'];
        $report++;
    }
    $sql = "UPDATE users SET report='$report' WHERE id='$id'";
    mysqli_query($conn,$sql);
    header("Location: emo_forest.php");
    exit();
}



$conn->close();
?>