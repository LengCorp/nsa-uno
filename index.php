<?php
$page = 'hem';
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/database.php';

?>

<div class="container">
    <button class="btn btn-primary" onclick="javascript:return DatabaseInsert(1);">Starta larmet!</button>
    <br>
    <button class="btn btn-primary" onclick="javascript:return DatabaseInsert(2);">Stäng av larmet!</button>
    <br>
    <button class="btn btn-primary" onclick="javascript:return DatabaseInsert(3);">Skicka en trigger!</button>
</div>

<?php

echo '<br>';
DatabaseSelect("index");


include 'resources/include/footer.php';
?>
