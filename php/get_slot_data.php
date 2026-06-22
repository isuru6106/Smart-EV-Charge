<?php

session_start();

include "db.php";

$owner_id = $_SESSION['user_id'];

$sql = "

SELECT
    total_ports,
    total_slots,
    status

FROM charging_centers

WHERE owner_id='$owner_id'

LIMIT 1

";

$result = $conn->query($sql);

if($result->num_rows > 0){

    $row = $result->fetch_assoc();

    echo json_encode([

        "total_ports" =>
            $row['total_ports'],

        "available_slots" =>
            $row['total_slots'],


        "status" =>
            $row['status']

    ]);

}

?>