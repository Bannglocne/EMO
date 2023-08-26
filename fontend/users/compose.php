<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/guithu.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <title>Viết thư</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Quicksand:wght@400;700&family=Raleway:wght@300;900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div id="menu">
            <ul id="menu-ul">
                <li><a class="menu-content" id="home" href="home.php">Trang chủ</a></li>
                <li><a class="menu-content" id="write" href="viet.php">Viết</a></li>
                <li><a class="menu-content" id="forest" href="../journals/emo_forest.php">Rừng</a></li>
                <li><img id="logo" src="../img/logo.png" height= "60px"></li>
                <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                <li><a class="menu-content" id="prf" href="view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
            </ul>
        </div>
    </header>

    <div class="thongbao">
        <h3>Bạn đang gặp phải vấn đề gì?</h3>
    </div>

    <form action="send_email.php" method="post">
        <div class="recipient-wrapper">
            <label for="recipient">Người nhận:</label>
            <select id="recipient" name="recipient" required>
                <option value="" selected disabled>Chọn chuyên gia</option>
                    <?php
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

                    // Truy vấn để lấy danh sách các chuyên gia
                    $sql_get_experts = "SELECT id, username FROM users WHERE role = 'expert'";
                    $result_get_experts = $conn->query($sql_get_experts);

                    // Hiển thị danh sách các chuyên gia làm tùy chọn trong dropdown
                    if ($result_get_experts->num_rows > 0) {
                        while ($row = $result_get_experts->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["username"] . '</option>';
                        }
                    }
        
                    // Đóng kết nối
                    $conn->close();
                    ?>
            </select>
        </div>
        <br>

        <div class="tieude">
            <?php
                session_start();
                if(isset($_SESSION['title_send_mail'])){
                    $title = $_SESSION['title_send_mail'];
                    echo "<input class='input-in' type='text' value='$title' name='title' id='title' placeholder='Tiêu đề: '>";
                    unset($_SESSION['title_send_mail']);
                }
                else{
                    echo "<input class='input-in' type='text' name='title' id='title' placeholder='Tiêu đề: '>";
                }
            ?>
        </div>

        <div class="tieude">
            <?php 
                if(isset($_SESSION[''])){
                    $content = $_SESSION['content_scontent_send_mailend_mail'];
                    echo "<textarea class='input-in' name='content' id='content' placeholder='Nội dung lá thư...' value='$content'></textarea>";
                    unset($_SESSION['content_send_mail']);
                }
                else{
                    echo "<textarea class='input-in' name='content' id='content' placeholder='Nội dung lá thư...'></textarea>";
                }
            ?>
        </div>
        <?php
        if(isset($_SESSION['msg_mail_tu'])){
            $msg = $_SESSION['msg_mail_tu'];
            echo $msg;
            unset($_SESSION['msg_mail_tu']);
        }
        ?>
        <div class="cainut">
            <input type="submit" value="Gửi" class='btn_sub'>
        </div>
    </form>
</body>
</html>