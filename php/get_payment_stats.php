<?php

session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

/* TOTAL PAID */

$sql = "
SELECT IFNULL(SUM(p.amount),0) AS total_paid

FROM payments p
JOIN bookings b
ON p.booking_id = b.booking_id

WHERE b.user_id = '$user_id'
AND p.status='Paid'
";

$total_paid =
$conn->query($sql)->fetch_assoc()['total_paid'];


/* PENDING */

$sql = "
SELECT IFNULL(SUM(p.amount),0) AS pending

FROM payments p
JOIN bookings b
ON p.booking_id = b.booking_id

WHERE b.user_id = '$user_id'
AND p.status='Pending'
";

$pending =
$conn->query($sql)->fetch_assoc()['pending'];


/* COMPLETED COUNT */

$sql = "
SELECT COUNT(*) AS completed

FROM payments p
JOIN bookings b
ON p.booking_id = b.booking_id

WHERE b.user_id = '$user_id'
AND p.status='Paid'
";

$completed =
$conn->query($sql)->fetch_assoc()['completed'];


/* LAST PAYMENT */

$sql = "
SELECT IFNULL(amount,0) AS last_payment

FROM payments p
JOIN bookings b
ON p.booking_id = b.booking_id

WHERE b.user_id = '$user_id'
AND p.status='Paid'

ORDER BY p.paid_at DESC

LIMIT 1
";

$result = $conn->query($sql);

if($result->num_rows > 0){

    $last_payment =
    $result->fetch_assoc()['last_payment'];

}else{

    $last_payment = 0;

}

echo json_encode([
    "total_paid"   => $total_paid,
    "pending"      => $pending,
    "completed"    => $completed,
    "last_payment" => $last_payment
]);

?>