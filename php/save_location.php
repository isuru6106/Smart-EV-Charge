<?php

include "db.php";

$user_id =
$_POST['user_id'];

$latitude =
$_POST['latitude'];

$longitude =
$_POST['longitude'];

$sql = "UPDATE vehicles

SET
latitude='$latitude',
longitude='$longitude'

WHERE user_id='$user_id'";

if ($conn->query($sql)) {

echo "Location saved!";

} else {

echo $conn->error;

}

?>