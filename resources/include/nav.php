<nav class="navbar navbar-default">
    <div class="container thinner">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>

        </div>
        <div id="navbar" class="collapse navbar-collapse container">
            <ul class="nav navbar-nav ">

                <li <?php if ($page == 'hem') echo 'class="active"' ?>>
                    <a href=".">Hem</a>
                </li>

                <li <?php if ($page == 'historik') echo 'class="active"' ?>>
                    <a href="historik.php">Historik</a>
                </li>

                <li <?php if ($page == 'login') echo 'class="active"' ?>>
                    <a href="login.php"><?php if (isset($_SESSION["username"])) echo 'Logga ut'; else echo 'Logga in' ?></a>
                </li>

            </ul>
        </div>
    </div>
</nav>

