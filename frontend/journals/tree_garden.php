<?php
session_start();
$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$userID = $_SESSION['user_id'];
$sql="SELECT * FROM journals WHERE created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() AND user_id=$userID;";
$result = $conn->query($sql);
if($result->num_rows>0){
    $count_buon=0;
    while($row=$result->fetch_assoc()){
        $id=$row['id'];
        $emotion=$row['emotion'];
        if($emotion=='2'){
            $count_buon++;
        }
    }
    if($count_buon>3){
        $_SESSION['msg_buon']="Tâm trạng gần đây của bạn có vẻ không tốt, bạn nên tâm sự với chuyên gia để có thể giải quyết vấn đề trước khi mọi chuyện xấu đi!";
    }
}
$conn->close();
header("Location: view_journal.php");
?>