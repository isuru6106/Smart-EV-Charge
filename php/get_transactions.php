<?php

session_start();
include "db.php";

$owner_id = $_SESSION['user_id'];

$result = $conn->query("

SELECT

'Payment' AS type,
total_earned AS amount

FROM owner_earnings

WHERE owner_id='$owner_id'

");

$data = [];

while($row=$result->fetch_assoc()){

$data[]=$row;

}

echo json_encode($data);

?>