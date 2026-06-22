<?php

session_start();

include "db.php";

$user_id = $_SESSION['user_id'];

/* WALLET BALANCE */

$walletResult = $conn->query("
SELECT wallet_balance
FROM users
WHERE id='$user_id'
");

$wallet = $walletResult->fetch_assoc();

/* LAST TOP UP */

$topupResult = $conn->query("

SELECT amount

FROM wallet_transactions

WHERE user_id='$user_id'
AND type='TopUp'

ORDER BY transaction_id DESC

LIMIT 1

");

$topup = $topupResult->fetch_assoc();

echo json_encode([

    "wallet_balance" =>
    $wallet['wallet_balance'],

    "last_topup" =>
    $topup ? $topup['amount'] : 0

]);

?>