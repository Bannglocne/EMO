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
        function write_journal(){
            window.location.href = "write_journal.php";
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
                <li><a class="menu-content" id="home" href="../users/">Trang chủ</a></li>
                <li><a class="menu-content" id="write" href="../users/viet.php">Viết</a></li>
                <li><a class="menu-content" id="forest" href="emo_forest.php">Rừng</a></li>
                <li><img id="logo" src="../img/logo.png"></li>
                <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
                <li><a class="menu-content" id="prf" href="../users/view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
                <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img//user.png"></a></li>
            </ul>
        </div>
    </header>
    <main id="choice-emo">
        <div id="choice-emo-content">
            <div id="qs-choice">
                <h3 class="h3-choice" id="question-choice">Hôm nay bạn bạn cảm thấy thế nào?</h3>
            </div>
            <div>
                <form method="post" action="write_journal.php">
                    <div id="content-choice-emo">
                        <button id="vui" class="item_emo" name="item_emo" onclick="write_journal()" value="1">Vui</button>
                        <button id="buon" class="item_emo" name="item_emo" onclick="write_journal()" value="2">Buồn</button>
                        <button id="other" class="item_emo" name="item_emo" onclick="write_journal()" value="3">Khác</button>
                    </div>
                </form>
            </div>
            
        </div>
    </main>
</body>
</html>
