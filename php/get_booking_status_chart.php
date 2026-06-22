<?php

include "db.php";

$labels = [];
$data = [];

$sql = "

SELECT
status,
COUNT(*) total

FROM bookings

GROUP BY status

";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

    $labels[] = $row['status'];
    $data[] = $row['total'];

}

echo json_encode([
    "labels"=>$labels,
    "data"=>$data
]);

?>