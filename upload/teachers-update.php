<?php

$query = "SELECT DISTINCT teacher FROM `diu_routine`;";
$result = sql($query);
$rows = array();
while ($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r['teacher'];
};

$numberOfRows = count($rows);

$query = "INSERT IGNORE INTO teachers (initial) VALUES ";
for ($i = 0; $i < $numberOfRows-1; $i++) {
    $query .= "('".$rows[$i]."'),";
}
$query .= "('".$rows[$i]."');";

if(sql($query)){
    echo "<br> Teacher's found $numberOfRows";
    require './upload/rooms-update.php';
}