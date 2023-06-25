<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "ispsc_library";


    try {
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }