<?php
$page = "login";
include 'resources/include/header.php';
include 'resources/include/nav.php';
include 'resources/include/databaseFunction.php';

include 'login_handler.php';
?>

<?php

if (isset($_SESSION['username'])) {
    echo '<div class="container">Du är inloggad som: ' . $_SESSION['username'];
    echo <<<HTML

<form class="form-signin" action="login.php" method="post">
    <button class="btn btn-lg btn-primary btn-block" name="logout" type="submit">Logga ut</button>
</form>
</div>

HTML;

} else {
    echo <<<HTML

<div class="container">

    <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Logga in</h2>
        <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="AnvÃ¤ndarnamn" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="LÃ¶senord" required>
HTML;
    echo $error_msg;
    echo <<<HTML
        <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Logga in</button>
    </form>

</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
HTML;
}

?>
<?php
include 'resources/include/footer.php';
?>
