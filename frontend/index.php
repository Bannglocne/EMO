<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] === 'expert') {
        header("Location: experts/expert_page.php");
    } else {
        header("Location: users/home.php");
    }
    exit();
} else {
    header("Location: accounts/login.php");
    exit();
}
?>
