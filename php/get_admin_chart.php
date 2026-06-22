<?php

include "db.php";

$sql = "

SELECT
DATE(paid_at) day,
SUM(amount) revenue

FROM payments

WHERE status='Paid'

GROUP BY DATE(paid_at)

ORDER BY day

";

$result = $conn->query($sql);

$days = [];
$revenue = [];

while($row = $result->fetch_assoc()){

    $days[] = $row['day'];
    $revenue[] = $row['revenue'];

}

echo json_encode([
    "days"=>$days,
    "revenue"=>$revenue
]);

?>