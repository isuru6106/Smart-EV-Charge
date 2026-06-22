<?php

session_start();

include "db.php";

$booking_id = $_POST['booking_id'];

$booking_date = $_POST['booking_date'];

$booking_time = $_POST['booking_time'];

$charging_hours = $_POST['charging_hours'];

/* CHECK BOOKING TIME */

$check = $conn->query("

SELECT
booking_date,
booking_time,
center_id

FROM bookings

WHERE booking_id='$booking_id'

");

$row = $check->fetch_assoc();

$booking_datetime = strtotime(

$row['booking_date'] . " " .

$row['booking_time']

);

if(time() >= $booking_datetime){

    echo "

    <script>

    alert('Booking can no longer be edited');

    history.back();

    </script>

    ";

    exit();

}

/* UPDATE BOOKING */

$conn->query("

UPDATE bookings

SET

booking_date='$booking_date',
booking_time='$booking_time',
charging_hours='$charging_hours',

status='Pending'

WHERE booking_id='$booking_id'

");

/* GET CENTER OWNER */

$center_id = $row['center_id'];

$result = $conn->query("

SELECT owner_id

FROM charging_centers

WHERE center_id='$center_id'

");

$owner = $result->fetch_assoc();

$owner_id = $owner['owner_id'];

/* NOTIFICATION */

$conn->query("

INSERT INTO notifications(

user_id,
title,
message

)

VALUES(

'$owner_id',

'Booking Updated',

'An EV owner modified a booking and it requires approval again.'

)

");

/* REDIRECT */

header(

"Location: ../owner/my-bookings.html"

);

exit();

?>