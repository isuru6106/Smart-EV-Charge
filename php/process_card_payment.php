<?php

session_start();

include "db.php";

$user_id = $_SESSION['user_id'];

$amount = $_POST['amount'];

$conn->query("
UPDATE users
SET wallet_balance = wallet_balance + $amount
WHERE id='$user_id'
");

$conn->query("
INSERT INTO wallet_transactions(
user_id,
amount,
type,
description
)
VALUES(
'$user_id',
'$amount',
'TopUp',
'Card Payment'
)
");

header("Location: ../owner/payment-success.html");

exit();

?>