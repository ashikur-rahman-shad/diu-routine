<?php
if (
    isset($_GET["day"]) &&
    isset($_GET["teacher"]) &&
    isset($_GET["course"]) &&
    isset($_GET["batch"])
) {
    $day = strtoupper($_GET["day"]);
    $teacher = $_GET["teacher"];
    $batch = $_GET["batch"];
    $course = $_GET["course"];
    $pattern = '/^([A-Z]+)([0-9]+)([A-Z]?)([0-9]?)$/';
    $search_Start_Time="";

    if($day=="TODAY"){ 
        $day = strtoupper(date("l"));
        $search_Start_Time = "STR_TO_DATE(`end`, '%h:%i%p')> STR_TO_DATE('".date("g:iA")."', '%h:%i%p') AND";
    }

    if (preg_match($pattern, $course, $matches)) {
        $courseCode = $matches[1]; // Course code (e.g., "SE")
        $courseNumber = $matches[2]; // Course number (e.g., "122")
        $section = $matches[3]; // Section (e.g., "D")
        $group = $matches[4]; // Group (e.g., "1")
        $sectiongroup = "";
        if (!$section) {
            $section .= "A-Z";
        }
        if (!$group) $group .= "0-9";

        $query = "
        SELECT DISTINCT `slot`,`start`,`end` FROM slot_time WHERE $search_Start_Time slot NOT IN (
            SELECT DISTINCT slot FROM (
                SELECT *,NULL as `date`,NULL as `classtype` FROM diu_routine 
                UNION
                SELECT * FROM off_routine_class
            ) AS temp
            WHERE 
                day LIKE '$day'and (
                    teacher = '$teacher'
                    or (
                        batch = $batch
                        and course REGEXP '^[A-Z]+[0-9]+([$section])?[0-9]?( 1)?$'
                    )
                )
        );
        ";
        $result =
            sql($query);

        $slots = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $slots[] = $row;
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        //echo $query. "<br>";
        echo json_encode($slots);
    }
}
//api/slot-rooms/?day=Sunday&teacher=KBB&batch=40&course=SE122D