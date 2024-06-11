<?php
    session_start();
    //Xóa tất cả các biết phiên làm việc và hàm
    session_unset();
    //Hủy phiên làm việc
    session_destroy();
    header("Location: login.php");
?>