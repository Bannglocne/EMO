<?php
include("../base/connect_data.php")

$recipient_name = $_GET['recipient_name'];

$sql_check_recipient = "SELECT * FROM users WHERE username = ?";
$stmt_check_recipient = $conn->prepare($sql_check_recipient);
$stmt_check_recipient->bind_param("s", $recipient_name);

$stmt_check_recipient->execute();

$result = $stmt_check_recipient->get_result();

if ($result->num_rows > 0){
    echo "true";
}else{
    echo "false";
}

$stmt_check_recipient->close();
$conn->close();
?>