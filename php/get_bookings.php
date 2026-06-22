<?php

session_start();

include "db.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "

SELECT
    bookings.*,
    charging_centers.center_name,
    charging_centers.city

FROM bookings

JOIN charging_centers

ON bookings.center_id =
charging_centers.center_id

WHERE bookings.user_id='$user_id'

ORDER BY bookings.booking_id DESC

LIMIT 10

";

$result = $conn->query($sql);

$bookings = [];

while($row = $result->fetch_assoc()){

    $bookings[] = $row;

}

header("Content-Type: application/json");

echo json_encode($bookings);

?>