<?php

include "db.php";

$booking_id = $_POST['booking_id'];
$status = $_POST['status'];

$conn->query("

UPDATE bookings

SET status='$status'

WHERE booking_id='$booking_id'

");

echo "success";

?>