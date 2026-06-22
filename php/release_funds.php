<?php

include "db.php";

$payment_id = $_POST['payment_id'];

/* GET PAYMENT */

$payment = $conn->query("
SELECT booking_id, amount
FROM payments
WHERE payment_id='$payment_id'
")->fetch_assoc();

$booking_id = $payment['booking_id'];
$amount = $payment['amount'];

$owner_share = $amount * 0.95;

/* GET CENTER */

$booking = $conn->query("
SELECT center_id
FROM bookings
WHERE booking_id='$booking_id'
")->fetch_assoc();

$center_id = $booking['center_id'];

/* GET OWNER */

$center = $conn->query("
SELECT owner_id
FROM charging_centers
WHERE center_id='$center_id'
")->fetch_assoc();

$owner_id = $center['owner_id'];

/* CREDIT OWNER */

$conn->query("
UPDATE owner_earnings
SET
total_earned = total_earned + $owner_share,
available_balance = available_balance + $owner_share
WHERE owner_id='$owner_id'
");

/* MARK PAYMENT RELEASED */

$conn->query("
UPDATE payments
SET release_status='Released'
WHERE payment_id='$payment_id'
");

/* REMOVE HELD FUNDS */

$conn->query("
UPDATE admin_account
SET total_balance = total_balance - $amount
WHERE id=1
");

echo "success";

?>