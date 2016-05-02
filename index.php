<?php
$page = 'hem';
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/database.php';

?>

<button onclick="javascript:return DatabaseInsert(1);">Starta larmet!</button><br>
<button onclick="javascript:return DatabaseInsert(2);">Stäng av larmet!</button><br>
<button onclick="javascript:return DatabaseInsert(3);">Skicka en trigger!</button>

<?php

echo '<br>';
DatabaseSelect("index");


include 'resources/include/footer.php';
?>
