<?php

include "db.php";

/* Total Users */

$row = $conn->query("
SELECT COUNT(*) total
FROM users
WHERE role='ev_owner'
")->fetch_assoc();

$users = $row['total'];

/* Total Centers */

$row = $conn->query("
SELECT COUNT(*) total
FROM charging_centers
")->fetch_assoc();

$centers = $row['total'];

/* Total Bookings */

$row = $conn->query("
SELECT COUNT(*) total
FROM bookings
")->fetch_assoc();

$bookings = $row['total'];

/* Revenue */

$row = $conn->query("
SELECT SUM(amount) total
FROM payments
WHERE status='Paid'
")->fetch_assoc();

$revenue = $row['total'] ?? 0;

echo json_encode([
    "users" => $users,
    "centers" => $centers,
    "bookings" => $bookings,
    "revenue" => $revenue
]);

?>