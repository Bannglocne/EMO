<!DOCTYPE html>
<html>
<head>
    <title>Quản Lý</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script>
        function change(id){
            window.location.href = "change_news.php?id="+id;
        }
        function deleteIF(id){
            if(confirm("Bạn có chắc muốn xóa bài viết?")){
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
                <li><a class="menu-content" id="home" href="home.php">Trang chủ</a></li>
                <li><a href="../quanly/quanly_users.php">Người dùng</a></li>
                <li><a class="menu-content" id="pro" href="../accounts/profile.php">Pro5</a></li>
            </ul>
        </header>
        <main id="home-container">
            <h3 class="h3-content">Xem bài viết</h3>
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
                $query = "SELECT * FROM news WHERE id='$userID'";
                $del = "";
                $result = $conn->query($query);
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        //Lấy dữ liệu từ cột trong dòng hiện tại
                        $id=$row['id'];
                            $avatar = $row['avatars'];
                            $title = $row['title'];
                            $description = $row['description'];
                            $content = $row['content'];
                            $created_at=$row['created_at'];
                            $status = $row['status'];
                            if ($status=='0'){
                                $status='Disable';
                            }elseif($status=='1'){
                                $status='Action';
                            }
                    }
                    echo "Ảnh: <img src='../../uploads/",$avatar,"' width='200px'></br>";
                    echo "Tiêu đề: ",$title,"<br>";
                    echo "Mô tả: ",$description,"<br>";
                    echo "Nội dung: ",$content,"<br>";
                    echo "Trạng thái: ",$status,"<br>";
                    echo "<button class='btn-clk' onclick='change($id)'>Sửa</button>";
                    echo "<button class='btn-clk' onclick='deleteIF($id)'>Xóa</button>";
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>