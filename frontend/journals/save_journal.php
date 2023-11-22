<?php
include("../base/check_session.php");
include("../base/connect_data.php")

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
        header("Location: tree_garden.php");
        exit();
    }
    else{
        $sql_insert_journal = "INSERT INTO journals (user_id, emotion, content, date, month, year, public) VALUES ('$user_id', '$camxuc', '$content', '$day', '$month', '$year', '$chedo')";
        mysqli_query($conn,$sql_insert_journal);
        header("Location: tree_garden.php");
        exit();
    }
    
}
$conn->close();
?>
