<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    
</head>
<body>
    <header>
        <ul id="menu-ul">
            <li><a class="menu-content" id="home" href="home.php">Trang chủ</a></li>
            <li><a class="menu-content" id="write" href="viet.php">Viết</a></li>
            <li><a class="menu-content" id="forest" href="../journals/emo_forest.php">Rừng</a></li>
            <li><img id="logo" src="../img/logo.png" height= "60px"></li>
            <li><a class="menu-content" id="garden" href="../journals/view_journal.php">Vườn</a></li>
            <li><a class="menu-content" id="prf" href="view_reply.php"><img id="img-user" src="../img/letter.png"></a></li>
            <li><a class="menu-content" id="prf" href="../accounts/profile.php"><img id="img-user" src="../img/user.png"></a></li>
        </ul>
    </header>
    <main id="home-container">
        <div id="qs-home">
            <h3 class="h3-viet" id="ask-home">Một chút năng lượng tích cực</h3>
        </div>
        <div id='lib-container'>
            <h3 class='text-lib'>Bài viết hay</h3>
            <div id='lib-conent'>
                <?php
                    $servername = "localhost";
                    $username = "emo";
                    $password = "123456EmoR2";
                    $dbname = "emo";
                    
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $query = "SELECT * FROM news WHERE status='1'";
                    $result = mysqli_query($conn, $query);
                    if ($result->num_rows>0){
                        while ($row=$result->fetch_assoc()){
                            $id = $row['id'];
                            $avatar = $row['avatars'];
                            $title = $row['title'];
                            $description = $row['description'];
                            echo "<div class='lib-news-content'><a style='text-decoration:none;color:black;' href='detail.php?id=$id'><img src='../../uploads/",$avatar,"' style='max-width:460px; max-height: 260px'>";
                            echo "<h3>",$title,"</h3>";
                            echo "<p>",$description,"</p></a></div>";
                        }
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
