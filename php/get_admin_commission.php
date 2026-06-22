<?php

include "db.php";

$result = $conn->query("

SELECT wallet_balance

FROM users

WHERE role='Admin'

LIMIT 1

");

$row = $result->fetch_assoc();

echo json_encode($row);

?>