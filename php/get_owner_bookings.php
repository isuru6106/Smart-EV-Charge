<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT

b.booking_id,
u.full_name,
v.model,
b.booking_date,
b.booking_time,
b.status

FROM bookings b

JOIN users u
ON b.user_id = u.id

LEFT JOIN vehicles v
ON v.user_id = u.id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id = '$owner_id'

ORDER BY b.booking_date DESC

";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

    $data[] = $row;

}

echo json_encode($data);


?>