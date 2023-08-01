<?php
session_start();

if (isset($_FILES['file']['tmp_name']) && isset($_POST['startTime']) && isset($_POST['endTime'])) {

    require './db-connect.php';

    $jsonData = file_get_contents($_FILES['file']['tmp_name']);
    $dataArray = json_decode($jsonData);
    $rowCount = count($dataArray);

    sql("TRUNCATE diu_routine");

    //sql("TRUNCATE off_routine_class");

    $query = "INSERT INTO `diu_routine` (`day`, `slot`, `room`, `course`, `teacher`, `batch`) VALUES ";
    $query .= "('" . strtoupper($dataArray[0][0]) . "', '" . $dataArray[0][1] . "', '" . $dataArray[0][2] . "', '" . ($dataArray[0][3]) . "', '" . str_replace(' ', '', $dataArray[0][4]) . "', '" . $dataArray[0][5] . "')";

    for ($i = 1; $i < $rowCount; $i++) {
        $query .= ", ('" . strtoupper($dataArray[$i][0]) . "', '" . $dataArray[$i][1] . "', '" . $dataArray[$i][2] . "', '" . ($dataArray[$i][3]) . "', '" . str_replace(' ', '', $dataArray[$i][4]) . "', '" . $dataArray[$i][5] . "')";
    }
    echo "<br>" . $rowCount . " ";

    if (sql($query)) {
        echo " new record created successfully";

        require './upload/slot-time-update.php';
    }
}
