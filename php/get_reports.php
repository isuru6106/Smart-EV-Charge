<?php

include "db.php";

$data = [];

$sql1 =
"SELECT COUNT(*) AS total_users
FROM users";

$sql2 =
"SELECT COUNT(*) AS total_bookings
FROM bookings";

$sql3 =
"SELECT SUM(amount) AS total_revenue
FROM payments
WHERE status='Paid'";

$data['users'] =
$conn->query($sql1)
->fetch_assoc();

$data['bookings'] =
$conn->query($sql2)
->fetch_assoc();

$data['revenue'] =
$conn->query($sql3)
->fetch_assoc();

header(
"Content-Type: application/json"
);

echo json_encode($data);

?>