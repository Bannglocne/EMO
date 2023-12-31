<?php
include("../base/check_session.php");
include("../base/connect_data.php")
?>

<!DOCTYPE html>
<html>
<head>
    <title>Viết</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css" />
    <script>
        function goChange(){
            window.location.href = "change_journal.php?id=<?php echo $_GET['id'] ?>";
        }
    </script>
    <style>
        #write{
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
                <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                <li><a class="menu-content" id="prf" href="../users/view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
            </ul>
        </div>
    </header>
    <main id="main-read">
        <div><h3 id='div-content-read'>Đọc nhật kí</h3></div>
        <div id="read-container">
            <?php
                $id=$_GET['id'];
                $servername = "localhost";
                $username = "emo";
                $password = "123456EmoR2";
                $dbname = "emo";
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                //$camxuc = $_SESSION['camxuc'];
                $sql = "SELECT * FROM journals WHERE id='$id';";
                $result = $conn->query($sql);
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                        {
                            //Lấy dữ liệu từ cột trong dòng hiện tại
                            $id = $row['id'];
                            $camxuc = $row['emotion'];
                            $content = $row['content'];
                            $chedo = $row['public'];
                            $date = $row['date'];
                            $month = $row['month'];
                            $year = $row['year'];
                        }
                    echo "<div><p class='info-read-p'>Ngày viết: ",$date,"/",$month,"/",$year,"</p></div>";
                    if($camxuc=='1'){
                        echo "<div id='camxuc-read'><p class='info-read-p'>Cảm xúc: </p><p class='info-read-p' id='vui-prf'>Vui</p></div>";
                    }
                    elseif($camxuc=='2'){
                        echo "<div id='camxuc-read'><p class='info-read-p'>Cảm xúc: </p><p class='info-read-p' id='buon-prf''>Buồn</p></div>";
                    }
                    else{
                        echo "<div id='camxuc-read'><p class='info-read-p'>Cảm xúc: </p><p class='info-read-p' id='khac-prf'>Khác</p></div>";
                    }
                    if ($chedo=='private'){
                        echo "<div><p class='info-read-p'>Chế độ: Riêng tư</p></div>";
                    }else{
                        echo "<div><p class='info-read-p'>Chế độ: Công khai</p></div>";
                    }
                    
                    echo "<div><p class='info-read-p'>Nội dung: ",$content, "</p></div>";
                }else{
                    echo "Không có dữ liệu";
                }

                $conn->close();
            ?>
            <div class="info-read"><button class="btn_ch" onclick="goChange()">Sửa</button></div>
        </div>
    </main>
</body>
</html>