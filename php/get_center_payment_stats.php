<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

/* TOTAL REVENUE (RELEASED ONLY) */

$sql = "
SELECT IFNULL(SUM(p.amount * 0.95),0) AS total_revenue

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id = '$owner_id'
AND p.release_status = 'Released'
";

$total_revenue =
$conn->query($sql)->fetch_assoc()['total_revenue'];


/* TODAY REVENUE */

$sql = "
SELECT IFNULL(SUM(p.amount * 0.95),0) AS today_revenue

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id = '$owner_id'
AND p.release_status = 'Released'
AND DATE(p.paid_at) = CURDATE()
";

$today_revenue =
$conn->query($sql)->fetch_assoc()['today_revenue'];


/* PENDING PAYMENTS */

$sql = "
SELECT IFNULL(SUM(p.amount * 0.95),0) AS pending

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id = '$owner_id'
AND p.release_status = 'Pending'
";

$pending =
$conn->query($sql)->fetch_assoc()['pending'];


/* COMPLETED PAYMENTS */

$sql = "
SELECT COUNT(*) AS completed

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id = '$owner_id'
AND p.release_status = 'Released'
";

$completed =
$conn->query($sql)->fetch_assoc()['completed'];


/* RETURN JSON */

echo json_encode([
    "total_revenue" => round($total_revenue,2),
    "today_revenue" => round($today_revenue,2),
    "pending" => round($pending,2),
    "completed" => $completed
]);

?>