<?php

session_start();

$message = "You are not eligible to make these changes";

if (isset($_SESSION['teacher']) && isset($_GET['day']) && isset($_GET['slot']) && isset($_GET['room']) && isset($_GET['course']) && isset($_GET['batch']) && isset($_GET['classtype'])) {

    require '../db-connect.php';

    $daysOfWeek = array('SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY');

    $slots = array();
    $result = sql("SELECT DISTINCT slot FROM `slots`;");
    while ($r = mysqli_fetch_assoc($result)) $slots[] = $r['slot'];

    $rooms = array();
    $result = sql("SELECT DISTINCT room FROM `rooms`;");
    while ($r = mysqli_fetch_assoc($result)) $rooms[] = $r['room'];

    $day = strtoupper($_GET['day']);
    $slot = $_GET['slot'];
    $room = $_GET['room'];
    $course = strtoupper($_GET['course']);
    $batch = $_GET['batch'];
    $teacher = $_SESSION['teacher'];
    $classtype = $_GET['classtype'];

    if (
        empty($course) || empty($batch) || empty($classtype)
        or
        $course == "null" || $batch == "null" || $classtype == "null"
    )
        $message = "You must enter class type, course name, and batch no";

    else if (
        in_array($day, $daysOfWeek) && in_array($slot, $slots) && in_array($room, $rooms)
    ) {


        $query = "SELECT * FROM `diu_routine` where 
                `day`='" . $day . "' and 
                slot = " . $slot . " and 
                room = '" . $room . "'";

        $message = "room not available";

        if (mysqli_num_rows(sql($query)) == 0) {

            $query = "SELECT * FROM `off_routine_class` where 
                    `day`='" . $day . "' and 
                    slot = " . $slot . " and 
                    room = '" . $room . "' and
                    `date` >= '" . date("Y-m-d") . "'
                    ";

            if (mysqli_num_rows(sql($query)) == 0) {

                $inputDay = $day;
                $currentDate = date('Y-m-d');


                $currentDayOfWeek = strtoupper(date('l', strtotime($currentDate)));

                $daysToAdd = (array_search($inputDay, $daysOfWeek) - array_search($currentDayOfWeek, $daysOfWeek) + 7) % 7;

                $nextDate = date('Y-m-d', strtotime("+$daysToAdd days", strtotime($currentDate)));

                if ($nextDate == $currentDate)
                    $nextDate = date('Y-m-d', strtotime("+7 days", strtotime($nextDate)));


                $query = "INSERT INTO `off_routine_class` (`day`, `slot`, `room`, `course`, `teacher`, `batch`, `date`, `classtype`) VALUES ('" . $day . "', '" . $slot . "', '" . $room . "', '" . $course . "', '" . $teacher . "', '" . $batch . "', '" . $nextDate . "', '" . $classtype . "'  ) ";

                if (sql($query))
                    $message = "$classtype class successfully booked on  $day, $nextDate at Room $room, Slot $slot";
                else
                    $message = "Database error";
            }
        }
    }
}

echo $message;
