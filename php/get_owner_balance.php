<?php

session_start();

include "db.php";

$owner_id = $_SESSION['user_id'];

$result = $conn->query("

SELECT available_balance

FROM owner_earnings

WHERE owner_id='$owner_id'

");

echo json_encode(
$result->fetch_assoc()
);

?>