<?php
$error_msg = '';
if (isset($_POST['login'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error_msg = "Username or Password is invalid";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (databaseLogin($username, $password)) {
            $_SESSION['username'] = $username;
            $error_msg = $_SESSION['username'];
        } else {
            $error_msg = "Username or Password is invalid";
        }
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}