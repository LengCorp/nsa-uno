<?php
$page = 'hem';
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/database.php';

if (isset($_SESSION["username"])) {
    echo <<<HTML

<div class="container">
    <button class="btn btn-primary onButton" onclick="javascript:return DatabaseInsert(1);">Starta larmet!</button>
    <br>
    <button class="btn btn-primary offButton" onclick="javascript:return DatabaseInsert(2);">Stäng av larmet!</button>
    <br>
    <button class="btn btn-primary triggerButton" onclick="javascript:return DatabaseInsert(3);">Skicka en trigger!
    </button>
</div>
<br>

<div class='container'>
    <table class='table table-striped'>
        <thead>
        <tr>
            <th>Time</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class='index_time'></td>
            <td class='index_status'></td>
        </tr>
        </tbody>
</div>

HTML;


    databaseSelect("index");
}
else {
    $_SESSION['loginReferer'] = $page;
    header('Location: login');
}


include 'resources/include/footer.php';
?>
