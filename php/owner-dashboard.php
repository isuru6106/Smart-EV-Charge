<?php

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.html");

    exit();

}

$full_name =
$_SESSION['full_name'];

?>