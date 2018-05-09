<?php
    session_start();
    if(!isset($_SESSION['user']))
        echo "false";
    else
        echo "true";
?>