<?php

session_start();

include "db.php";

$owner_id = $_SESSION['user_id'];

$total_ports = $_POST['total_ports'];

$sql = "

UPDATE charging_centers

SET

total_ports = '$total_ports',
total_slots = '$total_ports'

WHERE owner_id = '$owner_id'

";

if($conn->query($sql)){

    header(
        "Location: ../center/manage-slots.html"
    );

    exit();

}else{

    echo $conn->error;

}

?>