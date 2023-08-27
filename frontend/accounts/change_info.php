<?php
// Gọi session_start() để bắt đầu phiên làm việc
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION["user_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: accounts/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Trang cá nhân</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Poppins:wght@400;700&family=Quicksand:wght@400;700&family=Raleway:wght@300;900&display=swap" rel="stylesheet">
        
    </head>

    <body>

        <header>
            <div id="menu">
                <ul id="menu-ul">
                    <li><a class="menu-content" id="home" href="../users/">Trang chủ</a></li>
                    <li><a class="menu-content" id="write" href="../users/">Viết</a></li>
                    <li><a class="menu-content" id="forest" href="../journals/emo_forest.php">Rừng</a></li>
                    <li><img id="logo" src="../img/logo.png"></li>
                    <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                    <li><a class="menu-content" id="prf" href="../users/view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                    <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
                </ul>
            </div>
        </header>

        <br><br>
        <main id="main-prf">
            
            <?php
                $servername = "localhost";
                $username = "emo";
                $password = "123456EmoR2";
                $dbname = "emo";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }
                
                // Truy vấn thông tin gười dùng
                $user_id = $_SESSION["user_id"];
                $sql_user = "SELECT * FROM users WHERE id='$user_id';";
                $result_user = $conn->query($sql_user);
                if($result_user->num_rows>0)
                {
                    // Lặp qua từng dòng dữ liệu
                    while($row=$result_user->fetch_assoc())
                    {
                        //Lấy dữ liệu từ cột trong dòng hiện tại
                        $user_id = $row['id'];
                        $username=$row['username'];
                        $public = $row['public'];

                    }
                    echo "<form method='post' action='update_info.php'>";
                    echo "<div id='ten-prf'><h3 id='div-content-prf'>Tên người dùng: </h3><input id='content_ch_info' name='name_ch' value='", $username, "'></div>";
                    echo "<br>";
                    if(isset($_SESSION['error_chInfo'])){
                        $error_chInfo = $_SESSION['error_chInfo'];
                        echo "<p class='error'>$error_chInfo</p>";
                        echo "<br>";
                        unset($_SESSION['error_chInfo']);
                    }
                    echo "<hr>";
                    echo "<br>";
                    echo "<br>";
                    if($public=='public')
                    {
                        echo "<div class='info-read' id='chedo'><p class='info-read-p'>Chế độ rừng: </p><p class='info-read-p'><input type='radio' name='chedo' value='public' checked>Công khai</p>";
                        echo "<p class='info-read-p'><input type='radio' name='chedo' value='private' >Riêng tư</p></div>";
                    }else{
                        echo "<div class='info-read' id='chedo'><p class='info-read-p'>Chế độ rừng: </p><p class='info-read-p'><input type='radio' name='chedo' value='public'>Công khai</p>";
                        echo "<p class='info-read-p'><input type='radio' name='chedo' value='private' checked>Riêng tư</p></div>";
                    }
                    echo "<br>";
                    echo "<a href='profile.php' style='text-decoration: none; color: black;' class='info-prf' id='logout' onclick='cancel()'>Hủy</a>";
                    echo "<input class='info-prf' id='change_info' value='Lưu' type='submit'>";
                    echo "</form>";
                }else{
                    echo "Không có dữ liệu";
                }  

                $conn->close();
            ?>
        </main>
    </body>
</html>