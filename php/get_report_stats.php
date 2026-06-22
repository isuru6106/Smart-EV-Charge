<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

/* MONTHLY REVENUE */

$sql = "

SELECT IFNULL(SUM(p.amount),0) revenue

FROM payments p

JOIN bookings b
ON p.booking_id=b.booking_id

JOIN charging_centers c
ON b.center_id=c.center_id

WHERE c.owner_id='$owner_id'
AND MONTH(p.paid_at)=MONTH(CURDATE())

";

$revenue =
$conn->query($sql)->fetch_assoc()['revenue'];

/* COMPLETED BOOKINGS */

$sql = "

SELECT COUNT(*) completed

FROM bookings b

JOIN charging_centers c
ON b.center_id=c.center_id

WHERE c.owner_id='$owner_id'
AND b.status='Completed'

";

$completed =
$conn->query($sql)->fetch_assoc()['completed'];

/* AVG RATING */

$sql = "

SELECT IFNULL(AVG(r.rating),0) rating

FROM ratings r

JOIN charging_centers c
ON r.center_id=c.center_id

WHERE c.owner_id='$owner_id'

";

$rating =
round(
$conn->query($sql)->fetch_assoc()['rating'],
1
);

echo json_encode([
    "revenue"=>$revenue,
    "completed"=>$completed,
    "rating"=>$rating
]);

?>