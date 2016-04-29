<?php
$page = 'hem';
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/database.php';

?>

<button onclick="javascript:return DatabaseInsert();">Lägg till en trigger!</button>

<?php

echo '<br>';
DatabaseSelect();


include 'resources/include/footer.php';
?>
