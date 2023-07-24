<?php

session_start();

$message = "You are not eligible to make these changes";

if (isset($_SESSION['teacher']) && isset($_GET['day']) && isset($_GET['slot']) && isset($_GET['room'])) {

    require './db-connect.php';

    $day = strtolower($_GET['day']);
    $slot = $_GET['slot'];
    $room = $_GET['room'];
    $teacher = $_SESSION['teacher'];

    $query = "DELETE FROM `off_routine_class` where `day`='" . $day . "' and slot=" . $slot . " and room='" . $room . "' and teacher='" . $teacher . "'";
    if (sql($query))
        $message = "Canceled Successfully!";
    else
        $message = "Something went wrong!";
}

echo $message;
