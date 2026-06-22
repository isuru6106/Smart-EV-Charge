<?php

include "db.php";

/* Revenue */

$row = $conn->query("
SELECT SUM(amount) total
FROM payments
WHERE status='Paid'
")->fetch_assoc();

$revenue = $row['total'] ?? 0;


/* Bookings */

$row = $conn->query("
SELECT COUNT(*) total
FROM bookings
")->fetch_assoc();

$bookings = $row['total'] ?? 0;


/* Active Centers */

$row = $conn->query("
SELECT COUNT(*) total
FROM charging_centers
WHERE status='Open'
")->fetch_assoc();

$centers = $row['total'] ?? 0;


echo json_encode([
    "revenue"=>$revenue,
    "bookings"=>$bookings,
    "centers"=>$centers
]);

?>