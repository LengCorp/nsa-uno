<?php
include('database.php');

function databaseLogin($username, $password)
{

    $conn = databaseConnect();

    $sql = "SELECT * FROM login WHERE username = '" . $username . "' AND password = '" . $password . "'";
    $result = $conn->query($sql);
    $row = $result->num_rows;

    if ($row == 1) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

function databaseSelect($DBpage)
{

    $conn = databaseConnect();

    if ($DBpage == "index") {
        $sql = "SELECT time, eventtype.type, eventtype.id FROM event JOIN eventtype ON event.type = eventtype.id ORDER BY event.id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $time = $row["time"];
            $_SESSION["idOfStatus"] = $row["id"];
            $type = $row["type"];
            echo "<script type='text/javascript'>
$('.index_time').html('$time');
$('.index_status').html('$type');
</script>";

            changeButtonText($type);

        } else {
            echo "0 results";
        }


    } else if ($DBpage == "history") {
        $sql = "SELECT time, eventtype.type FROM event JOIN eventtype ON event.type = eventtype.id ORDER BY event.id DESC LIMIT 15";
        $result = $conn->query($sql);

        if ($result) {

            echo "<div class='container'>";
            echo "<table class='table table-striped'>";
            echo "<thead>";
            echo "<tr><th>Time</th><th>Status</th></tr>";
            echo "<tbody>";

            $event = [];
            $i = 0;

            while ($row = $result->fetch_assoc()) {
                $event[$i]["time"] = $row["time"];
                $event[$i]["type"] = $row["type"];
                $i++;
            }

            $colorClass = [];
            for ($i = 0; $i < sizeof($event); $i++) {

                if ($event[$i]["type"] == "ON" || $event[$i]["type"] == "OFF")
                    $colorClass[$i] = "offColor";
                else if ($event[$i]["type"] == "TRIGGER")
                    $colorClass[$i] = "onColor";

                echo "<tr class='$colorClass[$i] historyElement'>";
                echo "<td>" . $event[$i]["time"] . "</td><td>" . $event[$i]["type"] . " </td>";
                echo "</tr>";
            }


            echo "</div>";
        } else {
            echo "0 results";
        }
    }

    $conn->close();
}

//DatabaseInsert
if (isset($_GET["insert"])) {

    session_start();
    $conn = databaseConnect();
    $sql = "SELECT eventtype.type, event.id FROM event JOIN eventtype ON event.type = eventtype.id ORDER BY event.id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row["type"] == "ON") {
            getIdAndInsert($conn, 'OFF');
            $newStatus = "OFF";
        } else if ($row["type"] == "OFF") {
            getIdAndInsert($conn, 'ON');
            $newStatus = "ON";
        } else if ($row["type"] == "TRIGGER" && $_SESSION["showedTrigger"] == "done") {
            $_SESSION["showedTrigger"] = "waiting";
            getIdAndInsert($conn, 'OFF');
            $newStatus = "OFF";
        } else {
            $newStatus = $row["type"];
        }
        $conn->close();
        changeButtonText($newStatus);
        $timestamp = date("Y-m-d H:i:s");
        $_SESSION["idOfStatus"] = $row["id"];
        echo "<div class='index_time_source'>" . $timestamp . "</div><div class='index_status_source'>" . $newStatus . "</div>";
    }
}

function getIdAndInsert($conn, $state)
{
    $sql = "SELECT id FROM eventtype WHERE type = '$state'";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $value = $row["id"];
        $sql = "INSERT INTO event(type) VALUES($value)";
        $conn->query($sql);
    } else {
        echo "Error: no result";
    }
}

function changeButtonText($state){
    if ($state == "ON") {
        echo "<script type='text/javascript'>
$('.mainButton').html('OFF');
$('body').removeClass('triggered');
</script>";
    } else if ($state == "OFF") {
        echo "<script type='text/javascript'>
$('.mainButton').html('ON');
$('body').removeClass('triggered');
</script>";
    } else if ($state == "TRIGGER") {
        echo "<script type='text/javascript'>
$('.mainButton').html('Restart');
$('body').addClass('triggered');
</script>";
        $_SESSION["showedTrigger"] = "done";
    }
}

?>
