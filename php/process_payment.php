<?php

include "db.php";

$booking_id = $_POST['booking_id'];
$method = $_POST['method'];

/* GET PAYMENT AMOUNT */

$result = $conn->query("

SELECT
estimated_amount

FROM bookings

WHERE booking_id='$booking_id'

");

$row = $result->fetch_assoc();

$amount = $row['estimated_amount'];

/* SAVE PAYMENT */

$conn->query("

INSERT INTO payments(

booking_id,
amount,
method,
status,
paid_at

)

VALUES(

'$booking_id',
'$amount',
'$method',
'Paid',
NOW()

)

");

/* UPDATE BOOKING */

$conn->query("

UPDATE bookings

SET payment_status='Paid'

WHERE booking_id='$booking_id'

");

/* FIND CENTER OWNER */

$getOwner = $conn->query("

SELECT
c.owner_id

FROM bookings b

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE b.booking_id='$booking_id'

");

$ownerData = $getOwner->fetch_assoc();

$owner_id = $ownerData['owner_id'];

/* CALCULATE REVENUE */

$owner_share = $amount * 0.95;
$admin_commission = $amount * 0.05;

/* ADMIN RECEIVES FULL PAYMENT */

$conn->query("

UPDATE admin_account

SET total_balance =
total_balance + $amount,

commission_balance =
commission_balance + $admin_commission

WHERE id = 1

");

/* CHECK OWNER RECORD */

$check = $conn->query("

SELECT *

FROM owner_earnings

WHERE owner_id='$owner_id'

");

/* ADD OWNER EARNINGS */

if($check->num_rows > 0){

    $conn->query("

    UPDATE owner_earnings

    SET

    total_earned =
    total_earned + $owner_share,

    available_balance =
    available_balance + $owner_share

    WHERE owner_id='$owner_id'

    ");

}
else{

    $conn->query("

    INSERT INTO owner_earnings(

    owner_id,
    total_earned,
    withdrawn,
    available_balance

    )

    VALUES(

    '$owner_id',
    '$owner_share',
    0,
    '$owner_share'

    )

    ");

}

/* REDIRECT */

header("Location: ../owner/payments.html");

exit();

?>