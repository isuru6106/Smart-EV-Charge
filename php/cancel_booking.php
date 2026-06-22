<?php

session_start();

include "db.php";

if(!isset($_SESSION['user_id'])){

    echo "Login required";

    exit();

}

$booking_id = $_POST['booking_id'];

/* GET BOOKING DETAILS */

$result = $conn->query("

SELECT

booking_date,
booking_time,
status,
center_id

FROM bookings

WHERE booking_id='$booking_id'

");

if($result->num_rows == 0){

    echo "Booking not found";

    exit();

}

$booking = $result->fetch_assoc();

/* CHECK BOOKING TIME */

$booking_datetime = strtotime(

    $booking['booking_date'] . " " .

    $booking['booking_time']

);

if(time() >= $booking_datetime){

    echo "

    <script>

    alert('Booking can no longer be cancelled.');

    history.back();

    </script>

    ";

    exit();

}

/* CHECK STATUS */

if(

    $booking['status'] == "Completed" ||

    $booking['status'] == "Rejected" ||

    $booking['status'] == "Cancelled"

){

    echo "

    <script>

    alert('This booking cannot be cancelled.');

    history.back();

    </script>

    ";

    exit();

}

/* CANCEL BOOKING */

$conn->query("

UPDATE bookings

SET status='Cancelled'

WHERE booking_id='$booking_id'

");

/* FIND CENTER OWNER */

$center_id = $booking['center_id'];

$ownerResult = $conn->query("

SELECT owner_id

FROM charging_centers

WHERE center_id='$center_id'

");

$owner = $ownerResult->fetch_assoc();

$owner_id = $owner['owner_id'];

/* SEND NOTIFICATION */

$conn->query("

INSERT INTO notifications(

user_id,
title,
message

)

VALUES(

'$owner_id',

'Booking Cancelled',

'An EV owner has cancelled a charging reservation.'

)

");

/* SUCCESS */

echo "success";

?>