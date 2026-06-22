<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT

DATE(p.paid_at) day,
COUNT(*) bookings,
SUM(p.amount) income

FROM payments p

JOIN bookings b
ON p.booking_id=b.booking_id

JOIN charging_centers c
ON b.center_id=c.center_id

WHERE c.owner_id='$owner_id'

GROUP BY DATE(p.paid_at)

ORDER BY day DESC

LIMIT 30

";

$result = $conn->query($sql);

$rows = [];

while($row = $result->fetch_assoc()){

$row['energy'] =
$row['bookings'] * 20;

$rows[] = $row;

}

echo json_encode($rows);

?>