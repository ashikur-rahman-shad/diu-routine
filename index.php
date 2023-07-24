 <?php
    session_start();

    if (isset($_SESSION['teacher'])) {
        echo "Logged in as " . $_SESSION['teacher'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require './db-connect.php';

        $jsonData = file_get_contents($_FILES['file']['tmp_name']);
        $dataArray = json_decode($jsonData);
        $rowCount = count($dataArray);

        $query = "TRUNCATE diu_routine";
        sql($query);

        $query = "INSERT INTO `diu_routine` (`day`, `slot`, `room`, `course`, `teacher`, `batch`) VALUES ";
        $query .= "('" . $dataArray[0][0] . "', '" . $dataArray[0][1] . "', '" . $dataArray[0][2] . "', '" . $dataArray[0][3] . "', '" . $dataArray[0][4] . "', '" . $dataArray[0][5] . "')";

        for ($i = 1; $i < $rowCount; $i++) {
            $query .= ", ('" . $dataArray[$i][0] . "', '" . $dataArray[$i][1] . "', '" . $dataArray[$i][2] . "', '" . $dataArray[$i][3] . "', '" . $dataArray[$i][4] . "', '" . $dataArray[$i][5] . "')";
        }
        echo $rowCount . "<br>";

        if (sql($query)) {
            echo "New record created successfully";
        }
    }

    ?>

 <html>

 <body>
     <form method="POST" enctype="multipart/form-data">
         <input type="file" name="file" />
         <input type="submit" value="Upload" />
         <a href="day-slot-view.html"> View routine</a>
         <a href="login.php"> Login</a>
     </form>
 </body>

 </html>