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

<!-- CODE HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Viết tâm sự</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/vietnhatki.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet">
    <style>
        #garden{
            border-bottom: 1px solid black;
        }
        
    </style>
    <script>
        function validate(){
            var camxuc = document.getElementsByClassName('item_emo').value;
            var content_tamsu = document.getElementById('content_tamsu').value;
            sessionStorage.camxuc=camxuc;
            sessionStorage.content_tamsu=content_tamsu;

        }
        function inti(){
            var regForm =document.getElementById('reform');
            regForm.onsubmit = validate();
        }
        window.onload = init;
    </script>
</head>

<body>
    <!-- Thanh menu -->
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
    
    <!-- Trang chính -->
    <!-- Form nhập liệu -->
    <form id="reform" method="post" action="save_journal.php">
        <div class = "tatca">

            <!-- Chỉnh tiêu đề -->
            <div class = "tieude">
                <h2>Tâm sự hôm nay của bạn là gì?</h2>
            </div>
            
            <div class = "dong2">
            <!-- Chỉnnh thời gian -->
                <div class = "ngaygio">
                <?php
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $date = date('l, m/d/Y', time());
                    $_SESSION['time_cr']=$date;
                    $camxuc = $_POST['item_emo'];
                    echo $date;
                ?>
                </div>

                <!-- Chỉnh cảm xúc -->
                <div id="camxuc">
                    <label>Cảm xúc: </label>
                    <?php 
                    if($camxuc=='1'){
                        echo "Vui";
                    } elseif ($camxuc=='2'){
                        echo "Buồn";
                    } else{
                        echo "Khác";
                    }
                    $_SESSION['camxuc']=$camxuc;
                    ?>
                </div>
                <div class='chedo-content'>
                    <label>Quyền xem nhật ký:</label>
                    <div style='display:flex; gap: 15px;'>
                        <p>Riêng tư <input type='radio' name='chedo' value='private' checked></p>
                        <p>Công khai <input type='radio' name='chedo' value='public'></p>
                    </div>
                </div>
            
            </div>
        </div>
        <!-- Chỉnh phần nhập liệu -->
        <div class = "noidung">
            <textarea id="content_tamsu" placeholder="Hãy viết nhật ký ngày hôm nay của bạn..." name="content_tamsu" required></textarea>
        </div>

        <!-- Chỉnh cái nút -->
        <div class="cainut">
            <button type="submit">Gửi</button>
        </div>
    </form>
    </div>
</body>
</html>
