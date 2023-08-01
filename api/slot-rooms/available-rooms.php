<?php
if (
    isset($_GET["day"]) &&
    isset($_GET["slot"])
) {
    $day = strtoupper($_GET["day"]);
    $slot = $_GET["slot"];

    if ($day == "TODAY") {
        $day = strtoupper(date("l"));
    }




    $query = "
    SELECT room FROM rooms WHERE room not in
    (SELECT DISTINCT room from 
    (SELECT *, null as `date`, null as `classtype` FROM `diu_routine` 
    UNION 
    SELECT * from off_routine_class) 
    as temp WHERE day='$day' and slot=$slot);        
        ";
    $result =
        sql($query);

    $rooms = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json");
    //echo $query. "<br>";
    echo json_encode($rooms);
}
//api/slot-rooms/?day=Sunday&teacher=KBB&batch=40&course=SE122D