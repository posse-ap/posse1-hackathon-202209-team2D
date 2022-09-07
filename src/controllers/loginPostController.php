<?php
require '../dbconnect.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_stmt = $db->prepare('select * from users where email = :email limit 1;');
    $user_stmt->bindValue(':email', $_POST['email']);
    $user_stmt->execute();
    $user = $user_stmt->fetch();
    if ($_POST['password'] === $user['password']) {
        $_SESSION['login_bool'] = 1;
    } else {
        $_SESSION['login_bool'] = 0;
    }
    if ($_SESSION['login_bool'] === 1) {
        header("Location: ../index.php");
        exit;
    } elseif ($_SESSION['login_bool'] === 0) {
        header("Location: ../auth/login/index.php");
        exit;
    }
}