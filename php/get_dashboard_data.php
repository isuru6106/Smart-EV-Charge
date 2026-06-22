<?php

session_start();

include "db.php";

$user_id =
$_SESSION['user_id'];

$response = [];

/* Upcoming Booking */

$sql1 =

"SELECT booking_date,
booking_time

FROM bookings

WHERE user_id='$user_id'

AND status='Approved'

ORDER BY booking_date ASC

LIMIT 1";

$result1 =
$conn->query($sql1);

if($result1->num_rows > 0){

    $booking =
    $result1->fetch_assoc();

    $response['upcoming'] =

    $booking['booking_date']

    . " "

    .

    $booking['booking_time'];

}

else{

    $response['upcoming'] =

    "No Booking";

}

/* Total Sessions */

$sql2 =

"SELECT COUNT(*) as total

FROM bookings

WHERE user_id='$user_id'

AND status='Completed'";

$result2 =
$conn->query($sql2);

$row2 =
$result2->fetch_assoc();

$response['sessions'] =

$row2['total'];

header("Content-Type: application/json");

echo json_encode($response);

?>