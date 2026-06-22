<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT

status,
COUNT(*) total

FROM bookings b

JOIN charging_centers c
ON b.center_id=c.center_id

WHERE c.owner_id='$owner_id'

GROUP BY status

";

$result = $conn->query($sql);

$labels = [];
$data = [];

while($row = $result->fetch_assoc()){

$labels[] = $row['status'];
$data[] = $row['total'];

}

echo json_encode([
"labels"=>$labels,
"data"=>$data
]);

?>