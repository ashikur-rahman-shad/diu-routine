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

 <body style="text-align: center;">
     <div>
         <h1>DIU Routine -SWE</h1>
         <div class="top-navigation">
             <a href="./login.php"> Login</a> &bull;
             <a href="./"> Home</a> &bull;
             <a href="./dashboard.html"> Dashboard</a> &bull;
             <a href="./day-slot-view.html"> Day wise routine</a> &bull;
             <a href="./room-slot-view.html"> Room wise routine</a> &bull;
             <br />
             <br />
         </div>
     </div>

     <form method="POST" enctype="multipart/form-data">
         <input type="text" name="initial" placeholder="Enter Teacher's initial" />
         <input type="submit" value="Login" />
     </form>
 </body>

 </html>