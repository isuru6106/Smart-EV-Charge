<?php

include "db.php";

$labels = [];
$data = [];

$statuses = [
    "Pending",
    "Approved",
    "Completed",
    "Cancelled"
];

foreach($statuses as $status){

    $row = $conn->query("
    SELECT COUNT(*) total
    FROM bookings
    WHERE status='$status'
    ")->fetch_assoc();

    $labels[] = $status;
    $data[] = $row['total'];
}

echo json_encode([
    "labels"=>$labels,
    "data"=>$data
]);

?>