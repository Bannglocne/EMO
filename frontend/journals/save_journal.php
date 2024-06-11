<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $camxuc = $_SESSION['camxuc'];
    $date = getdate();
    $day = $date['mday'];
    $month = $date['mon'];
    $year = $date['year'];
    $_SESSION['camxuc'] = $camxuc;
    $user_id = $_SESSION['user_id'];
    $chedo = $_POST['chedo'];
    $content = $_POST['content_tamsu'];
    
    $sql_check_time = "SELECT date FROM journals WHERE date='$day' AND month='$month' AND year='$year' AND user_id='$user_id'";
    $result_check_time = mysqli_query($conn, $sql_check_time);
    $error_jour="";
    // Lưu thư vào cơ sở dữ liệu
    if(($result_check_time->num_rows != 0))
    {
        $error_jour="Một ngày chỉ viết 1 nhật kí!";
        $_SESSION['error_jour']=$error_jour;
        header("Location: view_journal.php");
        exit();
    }
    else{
        $sql_insert_journal = "INSERT INTO journals (user_id, emotion, content, date, month, year, public) VALUES ('$user_id', '$camxuc', '$content', '$day', '$month', '$year', '$chedo')";
        mysqli_query($conn,$sql_insert_journal);
        header("Location: view_journal.php");
        exit();
    }
    
}
$conn->close();
?>
