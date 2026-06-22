<?php

include "db.php";

$sql = "SELECT *

FROM charging_centers";

$result =
$conn->query($sql);

$data = [];

while (
$row =
$result->fetch_assoc()
) {

$data[] = $row;

}

header(
"Content-Type: application/json"
);

echo json_encode($data);

?>