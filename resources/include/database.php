<?php

function databaseConnect()
{

    $servername = "localhost";
    $username = "simon";
    $password = "lammkott";
    $dbname = "nsa-uno-db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_error()) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

function databaseLogin($username, $password){

    $conn = databaseConnect();

    $sql = "SELECT * FROM login WHERE username = '".$username."' AND password = '".$password."'";
    $result = $conn->query($sql);
    $row = $result->num_rows;

    if ($row == 1){
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
        $sql = "SELECT time, eventtype.type, eventtype.id FROM event JOIN eventtype ON event.type = eventtype.id WHERE eventtype.type = 'ON' OR eventtype.type = 'OFF' ORDER BY event.id DESC";
        $result = $conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $time = $row["time"];
            $type = $row["type"];
            echo "<script type='text/javascript'>
$('.index_time').html('$time');
$('.index_status').html('$type');
</script>";

            if ($row["type"] == "ON") {
                echo "<script type='text/javascript'>
$('.onButton').addClass('disabled');
$('.offButton').removeClass('disabled');
</script>";
            } else if ($row["type"] == "OFF") {
                echo "<script type='text/javascript'>
$('.onButton').removeClass('disabled');
$('.offButton').addClass('disabled');
</script>";
            }
            tryToSoundTheAlarm();
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

            //decide color for the output
            $colorClass = [];
            for ($i = sizeof($event) - 1; $i >= 0; $i--) {
                if ($event[$i]["type"] == "ON")
                    $colorClass[$i] = "onColor";
                else if ($event[$i]["type"] == "OFF")
                    $colorClass[$i] = "offColor";
                else if ($i == sizeof($event) - 1)
                    $colorClass[$i] = "modeChangeColor";
                else
                    $colorClass[$i] = $colorClass[$i + 1];
            }

            for ($i = 0; $i < sizeof($event); $i++) {

                if ($event[$i]["type"] == "ON" || $event[$i]["type"] == "OFF")
                    $colorClass[$i] = "modeChangeColor";

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

    $type = $_GET["insert"];
    $alarmStatus = $type;
    $timestamp = "";
    $conn = databaseConnect();

    $sql = "SELECT id, type FROM eventtype WHERE type = 'ON' OR type ='OFF'";
    $result = $conn->query($sql);
    if ($result) {
        while($row = $result->fetch_assoc()){
            if ($row["type"] == $type){
                $type = $row["id"];
                break;
            }
        }
    }

    $sql = "SELECT time, event.type FROM event JOIN eventtype ON event.type = eventtype.id WHERE eventtype.type = 'ON' OR eventtype.type = 'OFF' ORDER BY event.id DESC";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $timestamp = $row["time"];
        $alarmStatus = $row["type"];
    } else {
        echo "0 results";
    }

    $conn->close();

    if (!($alarmStatus == $type)) {

        $conn = databaseConnect();

        $sql = "INSERT INTO event(type) VALUES($type)";
        $timestamp = date("Y-m-d H:i:s");

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully <br>";
        } else {
            echo "Error: " . $sql . " <br>" . $conn->error;
        }

        $conn->close();
    }

    $conn = databaseConnect();

    $sql = "SELECT eventtype.type FROM eventtype WHERE id=$type";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $type = $row["type"];
    } else {
        echo "0 results";
    }

    if ($type != "TRIGGER") {

        echo "<div class='index_time_source'>" . $timestamp . "</div><div class='index_status_source'>" . $type . "</div>";
    }

    tryToSoundTheAlarm();

    $conn->close();
}

function tryToSoundTheAlarm()
{
    $conn = databaseConnect();
    $time = time();
    $type = "OFF";

    $sql = "SELECT time, eventtype.type FROM event JOIN eventtype ON event.type = eventtype.id WHERE eventtype.type = 'ON' OR eventtype.type = 'OFF' ORDER BY event.id DESC";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $time = $row["time"];
        $type = $row["type"];
    }

    $sql = "SELECT time FROM event JOIN eventtype ON event.type = eventtype.id WHERE eventtype.type = 'TRIGGER' ORDER BY event.id DESC";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $time2 = $row["time"];
        if ($time2 > $time && $type == "ON") {
            echo "<script type='text/javascript'>
$('body').addClass('triggered');
</script>";
        } else {
            echo "<script type='text/javascript'>
$('body').removeClass('triggered');
</script>";
        }
    }
    $conn->close();
}

?>
