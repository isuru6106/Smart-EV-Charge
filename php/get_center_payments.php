<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT

p.payment_id,

ROUND(p.amount * 0.95, 2) AS amount,

p.method,
p.status,
p.paid_at,

b.booking_id,

u.full_name

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN users u
ON b.user_id = u.id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id='$owner_id'
AND p.release_status='Released'

ORDER BY p.payment_id DESC

";
$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

    $data[] = $row;

}

echo json_encode($data);

?>