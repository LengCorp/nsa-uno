<?php

function DatabaseConnect(){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nsa-uno-db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_error()) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    echo "Connected successfully<br>";

    return $conn;
}

function DatabaseSelect($DBpage){

    $conn = DatabaseConnect();

    if ($DBpage == "index") {
        $sql = "SELECT time, eventtype.type FROM event JOIN eventtype on event.type = eventtype.id WHERE eventtype.type = 'ON' OR eventtype.type = 'OFF' ORDER BY event.id DESC";
        $result = $conn->query($sql);

        if ($result) {
            echo "<div class='container'>";
            echo "<table class='table table-striped'>";
            echo "<thead>";
            echo "<tr><th>Time</th><th>Status</th></tr>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["time"] . "</td><td>" . $row["type"] . "</td>";
                echo "</tr>";
                break;
            }
            echo "</div>";
        } else {
            echo "0 results";
        }
    }

    else if($DBpage == "history"){
        $sql = "SELECT event.id, time, eventtype.type FROM event JOIN eventtype on event.type = eventtype.id ORDER BY event.id ASC";
        $result = $conn->query($sql);

        if ($result) {

            echo "<div class='container'>";
            echo "<table class='table table-striped'>";
            echo "<thead>";
            echo "<tr><th>id</th><th>Time</th><th>Status</th></tr>";
            echo "<tbody>";

            $event = [];
            $i = 0;

            while ($row = $result->fetch_assoc()) {
                $event[$i]["id"] = $row["id"];
                $event[$i]["time"] = $row["time"];
                $event[$i]["type"] = $row["type"];
                $i++;
            }

            //decide color for the output
            $color = "black";
            for($i = 0; $i < sizeof($event); $i++){
                if($event[$i]["type"] == "ON")
                    $color = "red";
                else if($event[$i]["type"] == "OFF")
                    $color = "green";
                echo "<tr style='color: $color; font-weight: bold;'>";
                echo "<td>" . $event[$i]["id"] . "</td><td>" . $event[$i]["time"] . "</td><td>" . $event[$i]["type"] . "</td>";
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
if(isset($_GET["insert"])){

    $type = $_GET["insert"];
    $conn = DatabaseConnect();

    $sql = "INSERT INTO event (id, time, type) VALUES (NULL, CURRENT_TIMESTAMP, $type)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

}
?>

<script type="text/javascript">
function DatabaseInsert(){
    $.ajax({
        url: "resources/include/database.php?insert=3",
        context: document.body
    }).done(function() {
        alert("dooone");
    });
    return false;
}
</script>
