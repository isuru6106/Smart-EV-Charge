<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$data = [];

/* Available Slots */
$sql = "
SELECT IFNULL(SUM(total_ports),0) AS available
FROM charging_centers
WHERE owner_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$data['available'] = $stmt->get_result()->fetch_assoc()['available'];

/* Pending Bookings */
$sql = "
SELECT COUNT(*) AS pending
FROM bookings b
JOIN charging_centers c
ON b.center_id = c.center_id
WHERE c.owner_id = ?
AND b.status='Pending'
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$data['pending'] = $stmt->get_result()->fetch_assoc()['pending'];

/* Revenue */
$sql = "
SELECT IFNULL(SUM(p.amount),0) AS revenue
FROM payments p
JOIN bookings b
ON p.booking_id = b.booking_id
JOIN charging_centers c
ON b.center_id = c.center_id
WHERE c.owner_id = ?
AND p.status='Paid'
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$data['revenue'] = $stmt->get_result()->fetch_assoc()['revenue'];

/* Rating */
$sql = "
SELECT IFNULL(ROUND(AVG(r.rating),1),0) AS rating
FROM ratings r
JOIN charging_centers c
ON r.center_id = c.center_id
WHERE c.owner_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$data['rating'] = $stmt->get_result()->fetch_assoc()['rating'];

echo json_encode($data);