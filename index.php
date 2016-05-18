<?php
$page = 'hem';
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/databaseFunction.php';

if (isset($_SESSION["username"])) {
    echo <<<HTML

<div class="container">
    <button class="btn btn-primary mainButton" onclick="javascript:return DatabaseInsert();">asdasd!</button>
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
