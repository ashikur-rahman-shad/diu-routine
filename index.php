<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require './db-connect.php';

    $jsonData = file_get_contents($_FILES['file']['tmp_name']);
    $dataArray = json_decode($jsonData);
    $rowCount = count($dataArray);

    sql("TRUNCATE diu_routine");

    //sql("TRUNCATE off_routine_class");

    $query = "INSERT INTO `diu_routine` (`day`, `slot`, `room`, `course`, `teacher`, `batch`) VALUES ";
    $query .= "('" . strtoupper($dataArray[0][0]) . "', '" . $dataArray[0][1] . "', '" . $dataArray[0][2] . "', '" . ($dataArray[0][3]) . "', '" . $dataArray[0][4] . "', '" . $dataArray[0][5] . "')";

    for ($i = 1; $i < $rowCount; $i++) {
        $query .= ", ('" . strtoupper($dataArray[$i][0]) . "', '" . $dataArray[$i][1] . "', '" . $dataArray[$i][2] . "', '" . ($dataArray[$i][3]) . "', '" . $dataArray[$i][4] . "', '" . $dataArray[$i][5] . "')";
    }
    echo "<br>" . $rowCount . "<br>";

    if (sql($query)) {
        echo "New record created successfully";
        //echo $query;
    }
}

?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="complete.css" />
</head>

<body>
    <div>
        <h1>DIU Routine -SWE</h1>
        <div class="top-navigation">
            <a href="./login.php"> Login</a> &bull;
            <a href="./"> Home</a> &bull;
            <a href="./dashboard.html"> Dashboard</a> &bull;
            <a href="./day-slot-view.html"> Day wise routine</a> &bull;
            <a href="./room-slot-view.html"> Room wise routine</a> &bull;
            <a href="./book-room.html"> Book room</a> &bull;
            <br>
            <br>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" value="Upload" />

    </form>

    <?php if (isset($_SESSION['teacher'])) {
        echo "<br> Logged in as " . $_SESSION['teacher'] . "";
    } ?>
</body>

</html>