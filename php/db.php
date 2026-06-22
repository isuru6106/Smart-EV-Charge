<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "ev_charging_system",
    3306
);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

?>