<?php
include("../base/check_session.php");
include("../base/connect_data.php")

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