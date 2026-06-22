<?php

session_start();

include "db.php";

$owner_id = $_SESSION['user_id'];

$result = $conn->query("

SELECT available_balance

FROM owner_earnings

WHERE owner_id='$owner_id'

");

$row = $result->fetch_assoc();

$amount = $row['available_balance'];

if($amount <= 0){

die("No available balance");

}

$conn->query("

INSERT INTO withdrawal_requests(

owner_id,
amount

)

VALUES(

'$owner_id',
'$amount'

)

");

echo "Withdrawal request submitted";

?>