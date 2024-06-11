<!DOCTYPE html>
<html>
<head>
    <title>Quản Lý</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script>
        function change(id){
            window.location.href = "change_user.php?id="+id;
        }
        function deleteIF(id){
            if(confirm("Bạn có chắc muốn xóa tài khoản này?")){
                window.location.href = "delete.php?id="+id;
            }
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
            <h3 class="h3-content">Xem thông tin người dùng</h3>
            <div id='content-detail'>
                <?php
                $userID = $_GET['id'];
                session_start();
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
                $query = "SELECT * FROM users WHERE id='$userID'";
                $del = "";
                $result = $conn->query($query);
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
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
                        echo "ID: ",$id,"<br>";
                        echo "Tên đăng nhập: ",$username,"<br>";
                        echo "Email: ",$email,"<br>";
                        echo "Vai trò: ",$role,"<br>";
                        echo "Số người xem: ", $seen, "<br>";
                        echo "Báo cáo: ",$report,"<br>";
                        echo "<button class='btn-clk' onclick='change($id)'>Sửa</button>";
                        echo "<button class='btn-clk' onclick='deleteIF($id)'>Xóa</button>";
                    }
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>