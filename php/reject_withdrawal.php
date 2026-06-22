<?php

include "db.php";

$id = $_GET['id'];

$conn->query("

UPDATE withdrawal_requests

SET status='Rejected'

WHERE request_id='$id'

");

header(
"Location: ../admin/withdrawals.html"
);

?>