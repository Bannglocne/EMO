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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name_ch'];
    $chedo = $_POST['chedo'];
    $id = $_SESSION['user_id'];
    $sql_check_username = "SELECT * FROM users WHERE id='$id'";
    $result_check_username = mysqli_query($conn, $sql_check_username);

    if ($result_check_username->num_rows > 0) {
        while($row=$result_check_username->fetch_assoc()){
            $username = $row['username'];
        }
        if($name==$username){
            $sql = "UPDATE users SET username='$name', public='$chedo' WHERE id='$id'";
            $_SESSION['user_id']=$id;
            header("Location: profile.php");
            mysqli_query($conn,$sql);
            exit();
        } else{
            $sql_check_newName = "SELECT id FROM users WHERE username=?";
            $stmt_check_newName = $conn->prepare($sql_check_newName);
            $stmt_check_newName->bind_param("s", $name);
            $stmt_check_newName->execute();
            $result_check_newName = $stmt_check_newName->get_result();
            if ($result_check_newName->num_rows != 0) {
                $error = "Tên đăng nhập đã tồn tại. Vui lòng thử lại!\n";
                $_SESSION["error_chInfo"] = $error;
                header("Location: change_info.php");
            }else{
                $sql = "UPDATE users SET username='$name', public='$chedo' WHERE id='$id'";
                mysqli_query($conn,$sql);
                $_SESSION['user_id']=$id;
                header("Location: profile.php");
                exit();
            }
        }
    }

    
}
$conn->close();
?>