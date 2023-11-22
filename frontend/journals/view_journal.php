<?php
include("../base/check_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vườn</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css" />
    <?php
        if(isset($_SESSION['error_jour'])){
            $error = $_SESSION['error_jour'];
            echo "<script> alert('$error');</script>";
            unset($_SESSION['error_jour']);
        }
        //include 'tree_garden.php';
        if(isset($_SESSION['msg_buon'])){
            $msg=$_SESSION['msg_buon'];
            echo "<script>if(confirm('$msg')){window.location.href='../users/compose.php'}</script>";
            unset($_SESSION['msg_buon']);
        }       
    ?>
    <style>
        #garden{
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
            <h3 class="h3-viet" id="vuon-cx">KHU VƯỜN CẢM XÚC</h3>
        </div>
        <div id="vuon-content">
            <div id="tree-emo">
                <?php
                include("../base/connect_data.php")

                //$camxuc = $_SESSION['camxuc'];
                $userID = $_SESSION['user_id'];
                $sql = "SELECT * FROM journals WHERE user_id='$userID';";
                $result = $conn->query($sql);
                $count = 0;
                $count_vui=0;
                $count_buon=0;
                if($result->num_rows>0)
                {
                    while($row=$result->fetch_assoc())
                        {
                            //Lấy dữ liệu từ cột trong dòng hiện tại
                            $id = $row['id'];
                            $camxuc = $row['emotion'];
                            $date = $row['date'];
                            $month = $row['month'];
                            $year = $row['year'];
                            $count++;
                            if($camxuc=='1')
                            {
                                echo "<a href='read_journal.php?id=",$id,"'><div class='container-view'><img class='img_emo' src='../img/vui.png'><div class='day-view'>",$date,"/",$month,"/",$year,"</div></div></a>";
                                $count_vui++;
                            }
                            elseif($camxuc=='2'){
                                echo "<a href='read_journal.php?id=",$id,"'><div class='container-view'><img class='img_emo' src='../img/buon.png'><div class='day-view'>",$date,"/",$month,"/",$year,"</div></div></a>";
                                $count_buon++;
                            }
                        }
                }else{
                    echo "";
                }

                
                ?>
            </div>
            <div id="reemo-container">
                <?php
                $date = getdate();
                $day = $date['mday'];
                $month = $date['mon'];
                $year = $date['year'];
                $sql_date = "SELECT * FROM journals WHERE date='$day' AND month='$month' AND year='$year' AND user_id='$userID';";
                $result_date =$conn->query($sql_date);
                if($result_date->num_rows==0){
                    echo "<div class='h3-viet' id='result-emo'><p>Hãy viết thêm cây cho khu vườn của bạn nào!</p></div>";
                }
                else{
                    if($count!=0)
                    {
                        if($count_vui>$count_buon){
                            echo "<div class='h3-viet' id='result-emo'><p>Vườn cây của bạn thật xanh tốt!</p></div>";
                        }
                        elseif($count_vui<$count_buon){
                            echo "<div class='h3-viet' id='result-emo'><p>Vườn cây của bạn bị úa vàng rồi!</p></div>";}
                        else{
                            echo "<div class='h3-viet' id='result-emo'><p>Vườn cây của bạn đồng đều nhỉ?</p></div>";
                        }
                    } else{
                        echo "";
                    }
                }
                $conn->close();
                  
                ?>
            </div>
        </div>
    </main>
</body>
</html>