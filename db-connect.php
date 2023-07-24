<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "diu_routine";


function sql($query)
{
  global $db_host, $db_user, $db_pass, $db_name;
  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  $result = mysqli_query($conn, $query);
  mysqli_close($conn);
  return $result;
}
