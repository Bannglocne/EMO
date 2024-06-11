<?php
// Gọi session_start() để bắt đầu phiên làm việc
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION["ma_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: ../accounts/login.php");
    exit();
}

// Kết nối đến cơ sở dữ liệu (chú ý thay đổi thông tin kết nối phù hợp với máy bạn)
$servername = "localhost";
$username = "emo";
$password = "123456EmoR2";
$dbname = "emo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script>
        function comeback(id){
            window.location.href ='detail.php?id='+id;
        }
    </script>
</head>
<body>
    <div id="logo">
        <img>
    </div>
    <div id='body'>
        <header>
            <ul id="menu-ul">
                <li><a class="menu-content" id="home" href="../manager/home.php">Trang chủ</a></li>
                <li><a href="quanly_users.php">Người dùng</a></li>
                <li><a class="menu-content" id="pro" href="../accounts/profile.php">Pro5</a></li>
            </ul>
        </header>
        <main id="home-container">
            <h3 class="h3-content">Sửa thông tin người dùng</h3>
            <?php
            $id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn,$sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $id = $row['id'];
                    $username = $row['username'];
                    $email = $row['email'];
                    $role = $row['role'];
                    $seen = $row['seen'];
                    $report = $row['report'];
                   
                }
                echo "<form method='post' action='update.php?id=$id'>";
                echo "<label for='username'>Tên đăng nhập: </label>";
                echo "<input name='username' type='text' value='", $username,"' required><br>";
                echo "<label for='email'>Email: </label>";
                echo "<input name='email' type='text' value='", $email,"' required><br>";
                echo "<lable for='role'>Vai trò</lable>";
                echo "<select name='role'>";
                if($role=='user'){
                    echo "<option value='user'>Người dùng thường</option>
                    <option value='expert'>Chuyên gia</option>";
                }else{
                    echo "<option value='expert'>Chuyên gia</option><option value='user'>Người dùng thường</option>";
                }
                echo "</select>";
                echo "<br><button onclick='comeback($id)'>Hủy</button>";
                echo "<input name='submit' type='submit' value='Lưu'>";
                echo "</form>";
            }
            ?>
        </main>
    </div>
</body>
</html>
