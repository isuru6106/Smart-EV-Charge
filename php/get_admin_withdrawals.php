<?php

include "db.php";

$result = $conn->query("

SELECT

w.*,
u.full_name

FROM withdrawal_requests w

JOIN users u

ON w.owner_id=u.id

ORDER BY w.request_id DESC

");

$data=[];

while($row=$result->fetch_assoc()){

$data[]=$row;

}

echo json_encode($data);

?>