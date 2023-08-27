<?php
    $servername = "localhost";
    $username = "emo";
    $password = "123456EmoR2";
    $dbname = "emo";

 $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

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