<?php

session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

$sql = "

SELECT
booking_id,
estimated_amount

FROM bookings

WHERE user_id='$user_id'

AND status='Completed'

AND payment_status='Pending'

ORDER BY booking_id DESC

LIMIT 1

";

$result = $conn->query($sql);

if($result->num_rows > 0){

    $row = $result->fetch_assoc();

    echo json_encode([
        "booking_id" => $row['booking_id'],
        "amount" => $row['estimated_amount']
    ]);

}
else{

    echo json_encode([
        "booking_id" => 0,
        "amount" => 0
    ]);

}