<?php
include('database.php');
session_start();

$conn = databaseConnect();
$sql = "SELECT eventtype.type, event.id FROM event JOIN eventtype ON event.type = eventtype.id ORDER BY event.id DESC";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $id = $row["id"];
    if ($id > $_SESSION["idOfStatus"]) {
        echo "true";
        $_SESSION["idOfStatus"] = $id;
    }
}