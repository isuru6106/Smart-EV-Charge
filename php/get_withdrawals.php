<?php

session_start();

include "db.php";

$owner_id = $_SESSION['user_id'];

$result = $conn->query("

SELECT *

FROM withdrawal_requests

WHERE owner_id='$owner_id'

ORDER BY request_id DESC

");

$data = [];

while($row = $result->fetch_assoc()){

$data[] = $row;

}

echo json_encode($data);

?>