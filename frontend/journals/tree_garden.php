<?php
include("../base/check_session.php");
include("../base/connect_data.php")

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