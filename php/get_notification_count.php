<?php

session_start();

include "db.php";

$user_id =
$_SESSION['user_id'];

$sql = "
SELECT COUNT(*) unread

FROM notifications

WHERE user_id = $user_id

AND is_read = 0
";

$row =
$conn->query($sql)
->fetch_assoc();

echo json_encode($row);

?>