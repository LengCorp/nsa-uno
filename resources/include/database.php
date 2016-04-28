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

function DatabaseSelect(){

    $conn = DatabaseConnect();

    $sql = "SELECT event.id, time, eventtype.type FROM event JOIN eventtype on event.type = eventtype.id ORDER BY event.id DESC";
    $result = $conn->query($sql);

    if ($result) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Time: " . $row["time"]. "  - Type: " . $row["type"]. "<br>";
        }
    } else {
        echo "0 results";
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
