<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT
DATE(p.paid_at) as day,
SUM(p.amount) as revenue

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN charging_centers c
ON b.center_id = c.center_id

WHERE c.owner_id = '$owner_id'

GROUP BY DATE(p.paid_at)

ORDER BY day ASC

";

$result = $conn->query($sql);

$days = [];
$revenue = [];

while($row = $result->fetch_assoc()){

    $days[] = $row['day'];
    $revenue[] = $row['revenue'];

}

echo json_encode([
    "days"=>$days,
    "revenue"=>$revenue
]);

?>