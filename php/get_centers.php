<?php

include "db.php";

$sql = "SELECT *

FROM charging_centers";

$result =
$conn->query($sql);

$centers = [];

while (
$row =
$result->fetch_assoc()
) {

$centers[] = $row;

}

header(
"Content-Type: application/json"
);

echo json_encode($centers);

?>