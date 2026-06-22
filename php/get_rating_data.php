<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT AVG(r.rating) avg_rating

FROM ratings r

JOIN charging_centers c
ON r.center_id = c.center_id

WHERE c.owner_id='$owner_id'

";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

echo json_encode([
    "rating" => round($row['avg_rating'],1)
]);

?>