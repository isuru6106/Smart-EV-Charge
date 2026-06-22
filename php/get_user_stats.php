<?php

include "db.php";

$totalUsers = $conn->query(
"SELECT COUNT(*) total FROM users"
)->fetch_assoc()['total'];

$evOwners = $conn->query(
"SELECT COUNT(*) total
 FROM users
 WHERE role='ev_owner'"
)->fetch_assoc()['total'];

$centerOwners = $conn->query(
"SELECT COUNT(*) total
 FROM users
 WHERE role='center_owner'"
)->fetch_assoc()['total'];

echo json_encode([
    "users" => $totalUsers,
    "evOwners" => $evOwners,
    "centerOwners" => $centerOwners
]);

?>