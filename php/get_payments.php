<?php

session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

$sql = "

SELECT

p.payment_id,
p.amount,
p.method,
p.status,
p.paid_at,

b.booking_id,

c.center_name

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE b.user_id='$user_id'

ORDER BY p.payment_id DESC

";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

    $data[] = $row;

}

echo json_encode($data);

?>