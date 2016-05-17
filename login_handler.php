<?php
$error_msg = '';
if (isset($_SESSION['loginReferer'])) {
    $error_msg = "Vänligen logga in för att komma åt sidan <b>" . $_SESSION['loginReferer'] . "</b>.";
}

if (isset($_POST['login'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error_msg = "Fel användarnamn eller lösenord";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = stripslashes($username);
        $password = stripslashes($password);
        $password = md5($password);

        if (databaseLogin($username, $password)) {
            $_SESSION['username'] = $username;
            if (isset($_SESSION["loginReferer"])) {
                if ($_SESSION["loginReferer"] == "hem")
                    header('Location: .');
                else
                    header('Location: ' . $_SESSION["loginReferer"]);
                unset($_SESSION["loginReferer"]);
            }
        } else {
            $error_msg = "Fel användarnamn eller lösenord";
        }
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}