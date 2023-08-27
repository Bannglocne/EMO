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
        
        <script>
            function question(){
                if(confirm('Bạn có chắc muốn đăng xuất?'))
                {
                    window.location.href = "logout.php";
                }
            }
            function change_info(){
                window.location.href = "change_info.php";
            }
        </script>
    </head>

    <body>

        <header>
            <div id="menu">
                <ul id="menu-ul">
                    <li><a class="menu-content" id="home" href="../users/home.php">Trang chủ</a></li>
                    <li><a class="menu-content" id="write" href="../users/viet.php">Viết</a></li>
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
                $count = 0;
                $count_vui=0;
                $count_buon=0;
                $pre_vui = 0;
                $pre_buon = 0;
                $pre_khac = 0;
                $userID = $_SESSION['user_id'];
                $servername = "localhost";
                $username = "emo";
                $password = "123456EmoR2";
                $dbname = "emo";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }
                $sql_emo = "SELECT * FROM journals WHERE user_id='$userID';";
                $result_emo = $conn->query($sql_emo);
                if($result_emo->num_rows>0)
                {
                    while($row=$result_emo->fetch_assoc())
                    {
                        $count++;
                        //Lấy dữ liệu từ cột trong dòng hiện tại
                        $id = $row['id'];
                        $camxuc = $row['emotion'];
                        $date = $row['date'];
                        $month = $row['month'];
                        $year = $row['year'];
                        
                        if($camxuc=='1')
                        {
                            $count_vui++;
                        }
                        elseif ($camxuc=='2'){
                            $count_buon++;
                        }
                    }
                    $count = (int)$count;
                    $count_vui = (int)$count_vui;
                    $count_buon = (int)$count_buon;
                    $pre_vui = ($count_vui/$count)*100;
                    $pre_buon = ($count_buon/$count)*100;
                    $pre_khac = 100-$pre_vui-$pre_buon;
                    $pre_vui = round($pre_vui, 1);
                    $pre_buon = round($pre_buon, 1);
                    $pre_khac = round($pre_khac,1);
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
                        $email = $row['email'];
                        $public = $row['public'];
                    }
                    if($public=='public'){
                        $chedo="Công khai";
                    }else{
                        $chedo="Riêng tư";
                    }
                    echo "<div id='ten-prf'><h3 id='div-content-prf'>Tên người dùng: </h3><p id='ten-txt'>", $username, "</p></div>";
                    echo "<br><hr>";
                    echo "<br>";
                    echo "<p class='info-prf'>Số cây trong vườn:",$count, " </p><br>";
                    echo "<div id='camxuc-prf'><p class='info-prf'>Cảm Xúc gần đây: <ul id='ul-prf'><li id='vui-prf'>", $pre_vui, "%</li><li id='buon-prf'>", $pre_buon, "%</li><li id= 'khac-prf'>", $pre_khac, "%</li></ul></p></div><br>";
                    echo "<p class='info-prf'>Email: ", $email, "</p><br>";
                    echo "<p class='info-prf'>Chế độ rừng: ", $chedo, "</p><br>";
                    echo "<br>";
                }else{
                    echo "Không có dữ liệu";
                }  

                $conn->close();
            ?>
            <button class="info-prf" id="logout" onclick="question()">Đăng Xuất</button>
            <button class="info-prf" id='change_info' onclick="change_info()">Sửa</button>
        </main>
    </body>
</html>