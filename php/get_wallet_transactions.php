<?php

session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT *
FROM wallet_transactions
WHERE user_id='$user_id'
ORDER BY created_at DESC
");

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);