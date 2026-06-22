<?php

include "db.php";

$user_lat =
$_GET['lat'];

$user_lng =
$_GET['lng'];

$sql = "SELECT *

FROM charging_centers

WHERE status='Open'";

$result =
$conn->query($sql);

$nearest = null;

$minDistance = 999999;

while (
$row =
$result->fetch_assoc()
) {

$distance = sqrt(

pow(
$row['latitude'] - $user_lat,
2
)

+

pow(
$row['longitude'] - $user_lng,
2
)

);

if (
$distance < $minDistance
) {

$minDistance =
$distance;

$nearest =
$row;

}

}

header(
"Content-Type: application/json"
);

echo json_encode($nearest);

?>