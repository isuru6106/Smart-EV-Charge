<?php

include "db.php";

$held = $conn->query("
SELECT IFNULL(SUM(amount),0) AS held_funds
FROM payments
WHERE status='Paid'
AND release_status='Pending'
")->fetch_assoc();

$commission = $conn->query("
SELECT commission_balance
FROM admin_account
WHERE id=1
")->fetch_assoc();

echo json_encode([
    "total_balance" => $held['held_funds'],
    "commission_balance" => $commission['commission_balance']
]);