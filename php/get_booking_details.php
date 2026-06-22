<?php

include "db.php";

$booking_id = $_GET['booking_id'];

$result = $conn->query("

SELECT *

FROM bookings

WHERE booking_id='$booking_id'

");

$row = $result->fetch_assoc();

header("Content-Type: application/json");

echo json_encode($row);

?>