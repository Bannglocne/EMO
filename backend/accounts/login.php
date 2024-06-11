<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/login_register.css">
    <script>
        function validate(){
            var username = document.getElementById('username').value;
            var psw =document.getElementById('password').value;

            sessionStorage.username=username;
            sessionStorage.psw=psw;
        }
        function init(){
            var regForm =document.getElementById('registerForm');
            regForm.onsubmit = validate;
        }
        window.onload = init;
        
    </script>
</head>
<body>
    <div id='pattern'></div>
    <main>
        <div id="wlc">
            <div id="wlc-content">
                <div id="wlc-login">
                    <h1 id="wlc-txt">Đăng nhập</h1>
                </div>
                <?php
                session_start();
                if(isset($_SESSION['username_log_ma']) and isset($_SESSION['pwd_log_ma'])){
                    $username = $_SESSION['username_log_ma'];
                    $pwd = $_SESSION['pwd_log_ma'];
                }
                ?>
                <form action="check_login.php" method="post">
                    <label for="username">Tên đăng nhập</label><br>
                    <input class="input-in" type="text" id="username" name="username" placeholder="Tên đăng nhập" value="<?php if(isset($username)){echo $username; unset($_SESSION['$username_log_ma']);} ?>" required>
                    <br>
                    <label for="password">Mật khẩu</label><br>
                    <input class="input-in" type="password" id="password" name="password" placeholder="Mật khẩu"  value="<?php if(isset($pwd)){echo $pwd; unset($_SESSION['$pwd_log_ma']);} ?>" required>
                    <br>
                    <div id="error-container">
                        <?php
                            $error = "";
                            if(isset($_SESSION['error_login_ma'])){
                                $error = $_SESSION['error_login_ma'];
                                echo "<p class='error'>",$error,"</p>";
                                unset($_SESSION['error_login_ma']);
                            }
                            else{
                                echo "";
                            }
                        ?>
                    </div>
                    <div id="div-sub"><input type="submit" value="Đăng nhập" id="sub"></div>
                </form>
                <!-- Nút Đăng ký -->
                <div id="qs">
                    <p id="txt-qs">Bạn chưa có tài khoản? <a href="register.php" id="a-in">Đăng ký ngay</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
