<?php
$page = "historik";
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/databaseFunction.php';
?>

<?php

if (isset($_SESSION["username"]))
    databaseSelect("history");
else {
    $_SESSION['loginReferer'] = $page;
    header('Location: login');
}


include 'resources/include/footer.php';
?>
