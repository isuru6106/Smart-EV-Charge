<?php

include "db.php";

$sql = "
SELECT
center_id,
center_name,
address,
city,
total_slots,
available_slots,
status
FROM charging_centers
ORDER BY center_id DESC
";

$result = $conn->query($sql);

$centers = [];

while($row = $result->fetch_assoc()){

    $centers[] = $row;

}

echo json_encode($centers);

?>