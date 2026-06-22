<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT
total_slots,
available_slots

FROM charging_centers

WHERE owner_id='$owner_id'

LIMIT 1

";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$available = $row['available_slots'];
$occupied = $row['total_slots'] - $available;

echo json_encode([
    "available"=>$available,
    "occupied"=>$occupied
]);

?>