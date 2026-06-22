<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$booking_id = $_POST['booking_id'];

/* GET BOOKING */

$getBooking = $conn->query("
SELECT *
FROM bookings
WHERE booking_id='$booking_id'
");

$booking = $getBooking->fetch_assoc();

if(!$booking){
    echo "booking_not_found";
    exit();
}

/* PREVENT DOUBLE COMPLETION */

if($booking['status'] == 'Completed'){
    echo "already_completed";
    exit();
}

$amount = $booking['estimated_amount'];

/* CHECK WALLET BALANCE */

$walletResult = $conn->query("
SELECT wallet_balance
FROM users
WHERE id='".$booking['user_id']."'
");

$wallet = $walletResult->fetch_assoc();

if($wallet['wallet_balance'] < $amount){
    echo "insufficient_balance";
    exit();
}

/* DEDUCT FROM WALLET */

$conn->query("
UPDATE users
SET wallet_balance = wallet_balance - $amount
WHERE id='".$booking['user_id']."'
");

/* WALLET TRANSACTION */

$conn->query("
INSERT INTO wallet_transactions(
user_id,
amount,
type,
description
)
VALUES(
'".$booking['user_id']."',
'$amount',
'Deduction',
'Charging Session Payment'
)
");

/* SPLIT REVENUE */

$owner_share = $amount * 0.95;
$admin_share = $amount * 0.05;

/* FIND OWNER */

$getOwner = $conn->query("
SELECT owner_id
FROM charging_centers
WHERE center_id='".$booking['center_id']."'
");

$owner = $getOwner->fetch_assoc();

/* OWNER EARNING 

$conn->query("

UPDATE owner_earnings

SET

total_earned = total_earned + $owner_share,
available_balance = available_balance + $owner_share

WHERE owner_id='".$owner['owner_id']."'

");
*/
/* OWNER EARNING DISABLED
FOR RELEASE FUNDS WORKFLOW
*/
$conn->query("

UPDATE owner_earnings

SET

total_earned = total_earned + $owner_share,
available_balance = available_balance + $owner_share

WHERE owner_id='".$owner['owner_id']."'

");



/* ADMIN COMMISSION */

$sql = "
UPDATE admin_account
SET
total_balance = total_balance + $amount,
commission_balance = commission_balance + $admin_share
WHERE id = 1
";

if(!$conn->query($sql)){
    die("ADMIN ERROR: ".$conn->error);
}
/* CREATE PAYMENT RECORD */

/* CREATE PAYMENT RECORD */

$checkPayment = $conn->query("
SELECT payment_id
FROM payments
WHERE booking_id='$booking_id'
");

if($checkPayment->num_rows == 0){

   $payment_method = $_POST['payment_method'];
    $conn->query("
    INSERT INTO payments
    (
        booking_id,
        amount,
        method,
        status,
        release_status,
        paid_at
    )
    VALUES
    (
        '$booking_id',
        '$amount',
        '$payment_method',
        'Paid',
        'Pending',
        NOW()
    )
    ");

}
//* COMPLETE BOOKING */

$result = $conn->query("
UPDATE bookings
SET
status='Completed',
payment_status='Paid'
WHERE booking_id='$booking_id'
");

if(!$result){
    die("UPDATE ERROR: " . $conn->error);
}

/* RELEASE SLOT */

$conn->query("
UPDATE charging_centers
SET available_slots = available_slots + 1
WHERE center_id='".$booking['center_id']."'
");

echo "success";
exit();
?>