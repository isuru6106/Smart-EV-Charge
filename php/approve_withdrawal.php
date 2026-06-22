<?php

include "db.php";

$id = $_GET['id'];

$request = $conn->query("

SELECT *

FROM withdrawal_requests

WHERE request_id='$id'

");

$row = $request->fetch_assoc();

$owner_id = $row['owner_id'];
$amount = $row['amount'];

$conn->query("

UPDATE withdrawal_requests

SET

status='Approved',
approved_at=NOW()

WHERE request_id='$id'

");

$conn->query("

UPDATE owner_earnings

SET

withdrawn =
withdrawn + $amount,

available_balance =
available_balance - $amount

WHERE owner_id='$owner_id'

");

$conn->query("

UPDATE admin_account

SET total_balance =
total_balance - $amount

WHERE id=1

");

header(
"Location: ../admin/withdrawals.html"
);
$conn->query("

INSERT INTO withdrawal_receipts(

request_id,
owner_id,
amount

)

VALUES(

'$id',
'$owner_id',
'$amount'

)

");
?>