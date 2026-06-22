<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT IFNULL(SUM(b.energy_kwh),0) total_energy

FROM bookings b

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id='$owner_id'

";

$row = $conn->query($sql)->fetch_assoc();

echo json_encode([
    "energy" => $row['total_energy']
]);

?>