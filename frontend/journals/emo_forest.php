<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
session_start();
if (!isset($_SESSION["user_id"])) {
    // Nếu không có phiên làm việc, chuyển hướng người dùng đến trang đăng nhập
    header("Location: ../accounts/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rừng</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/forest.css" />
    <?php
        if(isset($_SESSION['error_jour'])){
            $error = $_SESSION['error_jour'];
            echo "<script> alert('$error');</script>";
            unset($_SESSION['error_jour']);
        }
    ?>
    <style>
        #forest{
            border-bottom: 1px solid black;
        }
        
    </style>
</head>
<body>
    <header>
        <div id="menu">
            <ul id="menu-ul">
                <li><a class="menu-content" id="home" href="../users/home.php">Trang chủ</a></li>
                <li><a class="menu-content" id="write" href="../users/viet.php">Viết</a></li>
                <li><a class="menu-content" id="forest" href="emo_forest.php">Rừng</a></li>
                <li><img id="logo" src="../img/logo.png"></li>
                <li><a class="menu-content" id="garden" href="view_journal.php">Vườn</a></li>
                <li><a class="menu-content" id="prf" href="../users/view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
            </ul>
        </div>
    </header>
    <main id="main-vuon">
        <div id="view-container">
            <h3 id="wlc-vuon">Chào mừng bạn đến với</h3>
            <h3 class="h3-viet" id="vuon-cx">KHU RỪNG CẢM XÚC</h3>
        </div>
        <div id='tree-emo'>
            <?php
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
            $sql_user = "SELECT * FROM users WHERE public='public' AND role='user'";
            $result_user = $conn->query($sql_user);
            if($result_user->num_rows>0){
                while($row=$result_user->fetch_assoc()){
                    $id_user = $row['id'];
                    $name_user = $row['username'];
                    $sql_journal = "SELECT * FROM journals WHERE user_id='$id_user'";
                    $result_journal = $conn->query($sql_journal);
                    if($result_journal->num_rows>0){
                        $count_vui=0;
                        $count_buon=0;
                        $count_khac=0;
                        while($row_jour=$result_journal->fetch_assoc()){
                            $camxuc = $row_jour['emotion'];
                            if($camxuc=='1'){
                                $count_vui++;
                            }elseif($camxuc=='2'){
                                $count_buon++;
                            }else{
                                $count_khac++;
                            }
                        }
                        if ($count_vui>$count_buon)
                        {
                            echo "<a class='a-forest' href='info.php?id=",$id_user,"'><div class='container-view'><img class='img_emo' src='../img/vui.png'><div class='name-view'>",$name_user,"</div></div></a>";
                        }elseif($count_buon>$count_vui){
                            echo "<a class='a-forest' href='info.php?id=",$id_user,"'><div class='container-view'><img class='img_emo' src='../img/buon.png'><div class='name-view'>",$name_user,"</div></div></a>";
                        }
                    }
                }
            }
            $conn->close();

            ?>
        </div>
    </main>
</body>
</html>