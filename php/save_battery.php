<?php

session_start();

include "db.php";

if(!isset($_SESSION['user_id'])){

    exit();

}

$user_id =
$_SESSION['user_id'];

$battery =
$_POST['battery'];

$sql =

"UPDATE vehicles

SET battery_percentage='$battery'

WHERE user_id='$user_id'";

$conn->query($sql);

echo "success";

?>