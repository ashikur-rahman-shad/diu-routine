<?php
$result = sql("SELECT COUNT(DISTINCT slot) as total_slots FROM `diu_routine`;");
$row = mysqli_fetch_assoc($result);
if ($row) {
    $slots = $row["total_slots"];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    sql("TRUNCATE slot_time");
    $query = "INSERT INTO `slot_time` (`slot`, `start`, `end`) VALUES ";

    // Convert start time and end time to minutes since midnight
    $startMinutes = strtotime($startTime) / 60;
    $endMinutes = strtotime($endTime) / 60;

    // Calculate the time interval for each slot in minutes
    $minutesPerSlot = ($endMinutes - $startMinutes) / $slots;

    // Generate the $slotTime array
    $slotTime = [];
    $currentTime = $startMinutes;
    echo "Slots: $slots <br>";
    for ($i = 0; $i < $slots; $i++) {
        $slotStart = date("h:iA", $currentTime * 60);
        $currentTime += $minutesPerSlot;
        $slotEnd = date("h:iA", $currentTime * 60);

        $slotTime[] = [$slotStart, $slotEnd];
        echo "$slotStart - $slotEnd <br>";
    }

    for ($i = 1; $i < $slots; $i++) {
        $query .= "($i, '" . $slotTime[$i - 1][0] . "', '" . $slotTime[$i - 1][1] . "'),";
    };
    $query .= "($i, '" . $slotTime[$i - 1][0] . "', '" . $slotTime[$i - 1][1] . "')";
    //echo "<br>" . $query . "<br>";
    if (sql($query)) {
        echo "<br> Slots ready!";

        require './upload/teachers-update.php';
    }
}
