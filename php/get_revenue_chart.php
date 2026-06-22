<?php

include "db.php";

$days = [];
$revenue = [];

$sql = "

SELECT
DATE(paid_at) as day,
SUM(amount) as total

FROM payments

WHERE status='Paid'

GROUP BY DATE(paid_at)

ORDER BY day ASC

LIMIT 7

";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

    $days[] = $row['day'];
    $revenue[] = $row['total'];

}

echo json_encode([
    "days"=>$days,
    "revenue"=>$revenue
]);

?>