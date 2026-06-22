<?php

session_start();

include "db.php";

$user_id =
$_SESSION['user_id'];

$battery =
$_POST['battery_percentage'];

$conn->query("

UPDATE vehicles

SET battery_percentage='$battery'

WHERE user_id='$user_id'

");

echo "success";

?>