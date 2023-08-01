<?php

$query = "SELECT DISTINCT room FROM `diu_routine`;";
$result = sql($query);
$rows = array();
while ($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r['room'];
};

$numberOfRows = count($rows);

sql("TRUNCATE rooms");
$query = "INSERT IGNORE INTO rooms (room, department) VALUES ";
for ($i = 0; $i < $numberOfRows-1; $i++) {
    $query .= "('".$rows[$i]."', 'SWE'),";
}
$query .= "('".$rows[$i]."',  'SWE');";

if(sql($query)){
    echo "<br> Total number of rooms: $numberOfRows";
}