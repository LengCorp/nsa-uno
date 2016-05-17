<?php
include('database.php');
session_start();

$conn = databaseConnect();
$sql = "SELECT time, eventtype.type, eventtype.id FROM event JOIN eventtype ON event.type = eventtype.id ORDER BY event.id DESC";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $time = $row["time"];
    if ($time > $_SESSION["timeOfStatus"]) {
        echo "true";
    }
}