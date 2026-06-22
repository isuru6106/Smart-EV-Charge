<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$data = [];

/* TODAY */

$sql = "
SELECT COALESCE(SUM(p.amount),0) total
FROM payments p
JOIN bookings b ON p.booking_id=b.booking_id
JOIN charging_centers c ON b.center_id=c.center_id
WHERE c.owner_id='$owner_id'
AND DATE(p.paid_at)=CURDATE()
";

$data['today'] =
$conn->query($sql)->fetch_assoc()['total'];


/* WEEK */

$sql = "
SELECT COALESCE(SUM(p.amount),0) total
FROM payments p
JOIN bookings b ON p.booking_id=b.booking_id
JOIN charging_centers c ON b.center_id=c.center_id
WHERE c.owner_id='$owner_id'
AND YEARWEEK(p.paid_at,1)=YEARWEEK(CURDATE(),1)
";

$data['week'] =
$conn->query($sql)->fetch_assoc()['total'];


/* MONTH */

$sql = "
SELECT COALESCE(SUM(p.amount),0) total
FROM payments p
JOIN bookings b ON p.booking_id=b.booking_id
JOIN charging_centers c ON b.center_id=c.center_id
WHERE c.owner_id='$owner_id'
AND MONTH(p.paid_at)=MONTH(CURDATE())
AND YEAR(p.paid_at)=YEAR(CURDATE())
";

$data['month'] =
$conn->query($sql)->fetch_assoc()['total'];


/* PENDING */

$sql = "
SELECT COALESCE(SUM(amount),0) total
FROM payments
WHERE status='Pending'
";

$data['pending'] =
$conn->query($sql)->fetch_assoc()['total'];


/* SESSIONS */

$sql = "
SELECT COUNT(*) total
FROM bookings b
JOIN charging_centers c
ON b.center_id=c.center_id
WHERE c.owner_id='$owner_id'
AND b.status='Completed'
";

$data['sessions'] =
$conn->query($sql)->fetch_assoc()['total'];


/* ENERGY */

$data['energy'] =
$data['sessions'] * 20;


/* AVG SESSION */

$data['avg'] = 0;

if($data['sessions'] > 0){

$data['avg'] =
round(
$data['month'] /
$data['sessions'],
2
);

}

/* COMMISSION */

$data['commission'] =
round(
$data['month'] * 0.10,
2
);

echo json_encode($data);

?>