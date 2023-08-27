<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký tài khoản</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/login_register.css">
    <script>
        function validate(){
            var username = document.getElementById('username').value;
            var mail =document.getElementById('email').value;
            var psw =document.getElementById('password').value;
            var conPwd =document.getElementById('confirmPassword').value;

            sessionStorage.username=username;
            sessionStorage.mail=mail;
            sessionStorage.psw=psw;
            sessionStorage.conPwd=conPwd;
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
            <div ><img id="img-wlc" src="../img/Design.png"></div>
            <div id="wlc-content">
                <div id="wlc-login">
                    <h1 id="wlc-txt">Chào mừng bạn đến với</h1>
                    <img id="emo" src="../img/logo.png">
                </div>
                <?php 
                session_start();
                if((isset($_SESSION['username_rig'])) and ($_SESSION['email_rig']) and ($_SESSION['password_rig']) and ($_SESSION['conpwd_rig']))
                {
                    $username = $_SESSION['username_rig'];
                    $email = $_SESSION['email_rig'];
                    $password = $_SESSION['password_rig'];
                    $conpwd = $_SESSION['conpwd_rig'];
                }
                ?>
                <form action="check_register.php" method="post" id="registerForm">
                    <label for="username">Tên tài khoản*</label><br>
                    <input class="input-in" type="text" id="username" name="username" placeholder="Tên tài khoản" value="<?php if(isset($username)){echo $username; unset($_SESSION['username_rig']);} ?>" required>
                    <br>
                    <label for="email">Email*</label><br>
                    <input class="input-in" type="email" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email; unset($_SESSION['email_rig']);} ?>" required>
                    <br>
                    <label for="password">Mật khẩu*</label><br>
                    <input class="input-in" type="password" id="password" name="password" value="<?php if(isset($password)){echo $password; unset($_SESSION['password_rig']);} ?>" placeholder="Mật khẩu" required>
                    <br>
                    <label for="password">Xác nhận mật khẩu*</label><br>
                    <input class="input-in" type="password" id="confirmPassword" name="confirmPassword" placeholder="Nhập lại mật khẩu" value="<?php if(isset($conpwd)){echo $conpwd; unset($_SESSION['conpwd_rig']);} ?>" required>
                    <br>
                    <div id="error-container">
                        <?php
                            $error = "";
                            if(isset($_SESSION['error_rig'])){
                                $error = $_SESSION['error_rig'];
                                echo "<p id='error'>",$error,"</p>";
                                unset($_SESSION['error_rig']);
                            }
                            else{
                                echo "";
                            }
                        ?>
                    </div>

                    <div id="div-sub"><input type="submit" value="Đăng ký" id="sub"></div>
                </form>
                <!-- Nút Đăng ký -->
                <div id="qs">
                    <p id="txt-qs">Bạn đã có tài khoản? <a href="login.php" id="a-in">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>