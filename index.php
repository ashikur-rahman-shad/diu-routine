<?php

require "./upload/upload.php";
?>
<!DOCTYPE html>
<html>

<head>
<script src="./kawaii-ui/kawaii-ui.js" defer></script>
</head>

<body>
    <div>
        <h1>DIU Routine -SWE</h1>
        <div class="top-navigation">
            <a href="./login.php"> Login</a> &bull;
            <a href="./"> Home</a> &bull;
            <a href="./dashboard.html"> Dashboard</a> &bull;
            <a href="./day-slot-view.html"> Day wise routine</a> &bull;
            <a href="./room-slot-view.html"> Room wise routine</a> &bull;
            <br>
            <br>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" />
        <br>
        <label>
            Class start time:
            <input type="text" name="startTime" placeholder="8:30AM" value="8:30AM" />
        </label>
        <br>
        <label>
            Class end time:
            <input type="text" name="endTime" placeholder="5:30PM" value="5:30PM" />
        </label>
        <br>
        <input type="submit" value="Upload" />

    </form>

    <?php if (isset($_SESSION['teacher'])) {
        echo "<br> Logged in as " . $_SESSION['teacher'] . "";
    } ?>
</body>

</html>