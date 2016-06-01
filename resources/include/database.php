<?php

function databaseConnect()
{

    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "nsa-uno-db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_error()) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
