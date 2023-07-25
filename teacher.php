<?php
    session_start();

    if (isset($_SESSION['teacher']))
        echo  $_SESSION['teacher'];
    