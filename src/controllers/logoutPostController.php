<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['login_bool']);
    header("Location: ../auth/login/index.php");
}
