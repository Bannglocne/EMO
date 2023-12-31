<!DOCTYPE html>
<html>
<head>
    <title>Quản Lý</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        .chu{
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        body{
            background-color:#FFF6F0;
        }
    </style>
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
    <div id="pattern">
        <div class="flex-left"><img id="logo" src="../img/logo.png" height= "60px"></div>
        <div class="flex-right"></div>
    </div>
    <br>

    <div id='body'>
        <header>
            <ul id="menu-ul">
                <li><a class="menu-content" id="home" href="home.php">Quản lý bài viết</li>
                <li><a href="../quanly/quanly_users.php">Người dùng</a></li>
                <li><a class="menu-content" id="pro" href="../accounts/profile.php">Trang cá nhân</a></li>
            </ul>
        </header>
        <main id="home-container">
            <h3 class="h3-content">Xem bài viết</h3>
            <div id='content-detail'>
                <?php
                $userID = $_GET['id'];
                session_start();
                include("../../frontend/base/connect_data.php")

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
                    echo "<div class='chu'>Ảnh: <img src='../../uploads/",$avatar,"' width='200px'></div></br>";
                    echo "<div class='chu'>Tiêu đề: ",$title,"</div><br>";
                    echo "<div class='chu'>Mô tả: ",$description,"</div><br>";
                    echo "<div class='chu'>Nội dung: ",$content,"</div><br>";
                    echo "<div class='chu'>Trạng thái: ",$status,"</div><br>";
                    echo "<button class='btn-clk' onclick='change($id)'>Sửa</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "<button class='btn-clk' onclick='deleteIF($id)'>Xóa</button>";
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>