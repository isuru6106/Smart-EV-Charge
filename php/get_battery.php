<?php

session_start();

include "db.php";

$user_id =
$_SESSION['user_id'];

$sql =

"SELECT battery_percentage

FROM vehicles

WHERE user_id='$user_id'";

$result =
$conn->query($sql);

if($result->num_rows > 0){

    $row =
    $result->fetch_assoc();

    echo json_encode($row);

}

?>