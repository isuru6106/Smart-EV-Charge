<?php

include "db.php";

$booking_id =
$_POST['booking_id'];

$amount =
$_POST['amount'];

$method =
$_POST['method'];

$sql = "INSERT INTO payments
(
booking_id,
amount,
method,
status,
paid_at
)

VALUES
(
'$booking_id',
'$amount',
'$method',
'Paid',
NOW()
)";

if ($conn->query($sql)) {

header(
"Location: ../owner/payments.html"
);

exit();

} else {

echo $conn->error;

}

?>