<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Trang cá nhân</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <style>
            .info-prf, #ten-txt{
            font-size: 20px;
            font-weight: bold;
            }
            .nut{
                padding: 5px;
                border: 2px solid black;
                border-radius: 5px;
                background-color: #fbb8d1;
            }
        </style>
        <script>
            function question(){
                if(confirm('Bạn có chắc muốn đăng xuất?'))
                {
                    window.location.href = "logout.php";
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
                    <li><a class="menu-content" id="home" href="../manager/home.php">Quản lý bài viết</a></li>
                    <li><a href="../quanly/quanly_users.php">Người dùng</a></li>
                    <li><a class="menu-content" id="pro" href="profile.php">Trang cá nhân</a></li>
                </ul>
            </header>
            <br><br>
            <main id="home-container">
                <h3 class="h3-content">Trang cá nhân</h3>
                <div class='content-table'> 
                    <?php
                        session_start();
                        $servername = "localhost";
                        $username = "emo";
                        $password = "123456EmoR2";
                        $dbname = "emo";
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Truy vấn thông tin gười dùng
                        $ma_id = $_SESSION["ma_id"];
                        $sql_user = "SELECT * FROM managers WHERE id='$ma_id';";
                        $result_user = $conn->query($sql_user);
                        if($result_user->num_rows>0)
                        {
                            // Lặp qua từng dòng dữ liệu
                            while($row=$result_user->fetch_assoc())
                            {
                                //Lấy dữ liệu từ cột trong dòng hiện tại
                                $ma_id = $row['id'];
                                $username=$row['username'];
                                $email = $row['email'];

                            }
                            echo "<div id='ten-prf'><h3 id='div-content-prf'>Tên người dùng: </h3>&nbsp;<p id='ten-txt'>", $username, "</p></div>";
                            echo "<br>";
                            echo "<p class='info-prf'>Email: ", $email, "</p>";
                        }else{
                            echo "Không có dữ liệu";
                        }  

                        $conn->close();
                    ?>
                    <br>
                    <button class="nut" id="logout" onclick="question()">Đăng Xuất</button>
                </div>
            </main>
        </div>

    </body>
</html>