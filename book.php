<?php

session_start();

$message = "You are not eligible to make these changes";

if (isset($_SESSION['teacher']) && isset($_GET['day']) && isset($_GET['slot']) && isset($_GET['room']) && isset($_GET['course']) && isset($_GET['batch'])) {

    require './db-connect.php';
    date_default_timezone_set('Asia/Dhaka');

    $daysOfWeek = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
    $slots = [1, 2, 3, 4, 5, 6, 7, 8];

    $result = sql("SELECT DISTINCT room FROM `diu_routine`;");
    $rooms = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rooms[] = $r['room'];
    }

    $day = strtolower($_GET['day']);
    $slot = $_GET['slot'];
    $room = $_GET['room'];
    $course = $_GET['course'];
    $batch = $_GET['batch'];
    $teacher = $_SESSION['teacher'];

    if (in_array($day, $daysOfWeek) && in_array($slot, $slots) && in_array($room, $rooms)) {


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

                $daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                $currentDayOfWeek = strtolower(date('l', strtotime($currentDate)));

                $daysToAdd = (array_search($inputDay, $daysOfWeek) - array_search($currentDayOfWeek, $daysOfWeek) + 7) % 7;

                $nextDate = date('Y-m-d', strtotime("+$daysToAdd days", strtotime($currentDate)));

                if ($nextDate == $currentDate)
                    $nextDate = date('Y-m-d', strtotime("+7 days", strtotime($nextDate)));


                $query = "INSERT INTO `off_routine_class` (`day`, `slot`, `room`, `course`, `teacher`, `batch`, `date`) VALUES ('" . $day . "', '" . $slot . "', '" . $room . "', '" . $course . "', '" . $teacher . "', '" . $batch . "', '" . $nextDate . "') ";

                if (sql($query))
                    $message = "Room $room booked successfully on  $nextDate, $day, Slot $slot";
                else
                    $message = "Database error";
            }
        }
    }
}

echo $message;
