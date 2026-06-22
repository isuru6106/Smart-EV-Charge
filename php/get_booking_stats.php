<?php

session_start();

include "db.php";

$user_id = $_SESSION['user_id'];

$total =
$conn->query(
"SELECT COUNT(*) total
FROM bookings
WHERE user_id='$user_id'"
)->fetch_assoc()['total'];

$approved =
$conn->query(
"SELECT COUNT(*) total
FROM bookings
WHERE user_id='$user_id'
AND status='Approved'"
)->fetch_assoc()['total'];

$pending =
$conn->query(
"SELECT COUNT(*) total
FROM bookings
WHERE user_id='$user_id'
AND status='Pending'"
)->fetch_assoc()['total'];

$completed =
$conn->query(
"SELECT COUNT(*) total
FROM bookings
WHERE user_id='$user_id'
AND status='Completed'"
)->fetch_assoc()['total'];

echo json_encode([
    "total"=>$total,
    "approved"=>$approved,
    "pending"=>$pending,
    "completed"=>$completed
]);

?>