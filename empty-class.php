<?php

$query = "SELECT * FROM `diu_routine` ";

$options = "";

if (isset($_GET['day'])) $options .= "and day like '" . $_GET['day'] . "'";
if (isset($_GET['slot'])) $options .= "and slot = '" . $_GET['slot'] . "'";
if (isset($_GET['room'])) $options .= "and room like  '" . $_GET['room'] . "'";
if (isset($_GET['course'])) $options .= "and course like  '" . $_GET['course'] . "'";
if (isset($_GET['teacher']) && isset($_GET['batch'])) {
    $options .= "and (teacher like  '" . $_GET['teacher'] . "' or(batch=";

}
//if (isset($_GET['classtype'])) $options .= "and classtype like '" . $_GET['classtype'] . "'";
if (isset($_GET['batch'])) {
    $options .= "and batch like " . $_GET['batch'];
    if (isset($_GET['section'])) {

        if (isset($_GET['group'])) {
            $options .= " or course REGEXP '^[A-Z]+[0-9]+([" . strtoupper($_GET['section']) . "])?([" . $_GET['group'] . "])?$'";
        } else {
            $options .= " or course REGEXP '^[A-Z]+[0-9]+([" . strtoupper($_GET['section']) . "])?([0-9])?$'";
        }
    };
}




if (count_chars($options)) {
    date_default_timezone_set('Asia/Dhaka');

    require './db-connect.php';
    $rows = array();
    $options = substr($options, 4);
    $query .= " where " . $options; //. " and `date`>='" . date("Y-m-d") . "'";
    //echo $query;
    $result = sql($query);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }

    // Allow cross-origin requests from any domain
    header("Access-Control-Allow-Origin: *");

    // Allow specific HTTP methods (e.g., GET, POST, OPTIONS, etc.)
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    // Allow specific HTTP headers in the request
    header("Access-Control-Allow-Headers: Content-Type");

    // Allow cookies to be sent in cross-origin requests (if needed)
    header("Access-Control-Allow-Credentials: true");

    // Set the Content-Type header for JSON responses
    header("Content-Type: application/json");
    echo json_encode($rows);
}
