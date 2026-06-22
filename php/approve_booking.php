<?php

include "db.php";

$booking_id = $_POST['booking_id'];

/* Get center */

$result = $conn->query("
SELECT center_id
FROM bookings
WHERE booking_id='$booking_id'
");

$row = $result->fetch_assoc();

$center_id = $row['center_id'];

/* Approve booking */

$conn->query("
UPDATE bookings
SET status='Approved'
WHERE booking_id='$booking_id'
");

/* Reduce available slot */

$conn->query("
UPDATE charging_centers
SET available_slots = available_slots - 1
WHERE center_id='$center_id'
AND available_slots > 0
");

echo "success";

?>