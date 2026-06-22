<?php

session_start();

include "db.php";

$user_id = $_SESSION['user_id'];

$sql = "
SELECT *
FROM notifications
WHERE user_id = $user_id
ORDER BY notification_id DESC
";

$result = $conn->query($sql);

$notifications = [];

while($row = $result->fetch_assoc()){

    $notifications[] = $row;

}

echo json_encode($notifications);

?>