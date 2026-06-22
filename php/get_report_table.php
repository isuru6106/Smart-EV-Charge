<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT

DATE(b.booking_date) day,

COUNT(*) bookings,

SUM(
CASE
WHEN b.status='Completed'
THEN 1
ELSE 0
END
) completed,

IFNULL(SUM(p.amount),0) revenue

FROM bookings b

LEFT JOIN payments p
ON b.booking_id=p.booking_id

JOIN charging_centers c
ON b.center_id=c.center_id

WHERE c.owner_id='$owner_id'

GROUP BY DATE(b.booking_date)

ORDER BY DATE(b.booking_date) DESC

";

$result = $conn->query($sql);

$data=[];

while($row=$result->fetch_assoc()){

$data[]=$row;

}

echo json_encode($data);

?>