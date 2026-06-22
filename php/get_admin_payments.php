<?php

include "db.php";

$sql = "
SELECT
p.payment_id,
u.full_name AS user_name,
c.center_name,
p.amount,
p.status,
p.release_status

FROM payments p

JOIN bookings b
ON p.booking_id = b.booking_id

JOIN users u
ON b.user_id = u.id

JOIN charging_centers c
ON b.center_id = c.center_id

ORDER BY p.payment_id DESC
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

    $data[] = $row;

}

echo json_encode($data);

?>