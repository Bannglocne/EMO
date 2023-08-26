<?php
// Gọi session_start() để bắt đầu phiên làm việc
session_start();


// Kết nối đến cơ sở dữ liệu
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
    <title>Quản Lý</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        body{
            background-color: #FFF6F0;
        }
    </style>
</head>
<body>
    <div id="pattern">
        <div class="flex-left"><img id="logo" src="../img/logo.png" height= "60px"></div>
        <div class="flex-right"></div>
    </div>
    <div id='body'>
    <header>
            <ul id="menu-ul">
                <br>
                <li><a class="menu-content" id="home" href="../manager/home.php">Quản lý bài viết</a></li>
                <li><a href="quanly_users.php">Người dùng</a></li>
                <li><a class="menu-content" id="pro" href="../accounts/profile.php">Trang cá nhân</a></li>
            </ul>
        </header>
        <main id="home-container">
            <h3 class="h3-content">Người dùng</h3>
            <div class='content-table'>
                <table>
                    <tr>
                        <th class="title">ID</th>
                        <th class="title">Tên đăng nhập</th>
                        <th class="title">Email</th>
                        <th class="title">Vai trò</th>
                        <th class="title">Người xem</th>
                        <th class="title">Báo cáo</th>
                        <th></th>
                    </tr>
                    <?php
                        $sql = "SELECT * FROM users;";
                        $result = $conn->query($sql);
                        $count = 0;
                        if($result->num_rows>0)
                        {
                            while($row=$result->fetch_assoc()){
                                $count++;
                                //Lấy dữ liệu từ cột trong dòng hiện tại
                                $id = $row['id'];
                                $username = $row['username'];
                                $email = $row['email'];
                                $role = $row['role'];
                                $seen = $row['seen'];
                                $report = $row['report'];
                                if($role=='user'){
                                    $role="Người dùng thường";
                                }else{
                                    $role="Chuyên gia";
                                }
                                echo "<tr>";
                                echo "<td>",$id,"</td>";
                                echo "<td>",$username,"</td>";
                                echo "<td>",$email,"</td>";
                                echo "<td>",$role,"</td>";
                                echo "<td>",$seen,"</td>";
                                echo "<td>",$report,"</td>";
                                echo "<td><a class='a-detail' href='detail.php?id=",$id,"'>Xem</a></td>";
                                echo "</tr>";
                            }
                        }
                    
                    ?>
                </table>
                <?php
                echo "<h3 id='count-user'>Có tất cả: ", $count, " người dùng</h3>";
                ?>
            </div>
        </main>
    </div>
</body>
</html>