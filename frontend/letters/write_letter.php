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
        <div id="head-content">
            <div id="menu">
                <ul id="menu-ul">
                    <li><a class="menu-content" id="home" href="../users/home.php">Trang chủ</a></li>
                    <li><a class="menu-content" id="write" href="../users/viet.php">Viết</a></li>
                    <li><a class="menu-content" id="forest" href="../journals/emo_forest.php">Rừng</a></li>
                    <li><img id="logo" src="../img/logo.png" height= "60px"></li>
                    <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                    <li><a class="menu-content" id="prf" href="../users/view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                    <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img/user.png"></a></li>
                </ul>
            </div>    
        </div>
    </header>

    <div class="thongbao">
        <h3>Hãy tâm sự cùng bạn bè nhé</h3>
    </div>

    <form action="send_letter.php" method="post">
        <div class="recipient-wrapper">
            <label for="recipient_name">Người nhận:</label>
            <input class='input-in' type="text" name="recipient_name" id="recipient_name" placeholder="Tên người nhận" required>
        </div>
        <br>

        <div class="tieude">
            <input class='input-in' type="text" name="title" id="title" placeholder="Tiêu đề: " value="<?php session_start(); if(isset($_SESSION['tt_letter'])){$title= $_SESSION['tt_letter'];echo $title;unset($_SESSION['tt_letter']);}?>" required>
        </div>
        <div class="tieude">
            <textarea class='input-in' name="content" id="content" placeholder="Nội dung lá thư..." required><?php if(isset($_SESSION['cnt_letter'])) {$content=$_SESSION['cnt_letter'];echo $content;unset($_SESSION['cnt_letter']);}?></textarea>
        </div>
        <?php
            if(isset($_SESSION['msg_send_letter']))
            {
                $msg= $_SESSION['msg_send_letter'];
                echo "<p style='text-align: center;' class='error'>$msg</p>";
                unset($_SESSION['msg_send_letter']);
            }
        ?>
        <div style="margin-inline:60px">
            <input type="submit" class="btn_sub" value='Gửi'>
        </div>
    </form>
</body>
</html>