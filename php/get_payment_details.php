<?php

include "db.php";

$booking_id =
$_GET['booking_id'];

$result =
$conn->query("

SELECT
estimated_amount

FROM bookings

WHERE booking_id='$booking_id'

");

$row =
$result->fetch_assoc();

echo json_encode([

"amount" =>
$row['estimated_amount']

]);

?>