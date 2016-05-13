<?php
$page = "historik";
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/database.php';
?>

<?php

databaseSelect("history");


include 'resources/include/footer.php';
?>
