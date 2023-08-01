<?php
if (isset($_GET["slots"])) {
    $result = sql("SELECT `slot`,`start`,`end` FROM slot_time");

    $slots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $slots[] = $row;
    }

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json");

    //echo $query. "<br>";
    echo json_encode($slots);
}
