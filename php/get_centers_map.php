<?php

include "db.php";

$sql = "
SELECT
    center_id,
    center_name,
    address,
    latitude,
    longitude,
    available_slots,
    total_slots,
    price_per_kwh,
    status
FROM charging_centers
";

$result = $conn->query($sql);

$centers = [];

while($row = $result->fetch_assoc()){

    $centers[] = $row;

}

header('Content-Type: application/json');

echo json_encode($centers);

?>