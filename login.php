<?php
$page = "login";
include 'resources/include/header.php';
include 'resources/include/nav.php';
?>
<body>

<div class="container">

    <form class="form-signin">
        <h2 class="form-signin-heading">Logga in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Användarnamn" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Lösenord" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Kom ihåg mig
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
<?php
include 'resources/include/footer.php';
?>
