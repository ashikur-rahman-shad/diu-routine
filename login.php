 <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        session_start();
        require './db-connect.php';

        $teacher =  strtoupper($_POST['initial']);;;;;;;;;
        $query = "SELECT Distinct teacher FROM `diu_routine` where teacher = '" . $teacher . "'";

        if (mysqli_num_rows(sql($query)) == 1) {
            $_SESSION['teacher'] = $teacher;
            header("Location: ./");
        }
    }

    ?>

 <html>

 <body>
     <form method="POST" enctype="multipart/form-data">
         <input type="text" name="initial" placeholder="Enter Teacher's initial"/>
         <input type="submit" value="Login" />
         <a href="day-slot-view.html"> View routine</a>
     </form>
 </body>

 </html>