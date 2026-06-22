<?php

session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode([
        "center_name" => "Guest"
    ]);
    exit();
}

$owner_id = $_SESSION['user_id'];

$sql = "
SELECT center_name
FROM charging_centers
WHERE owner_id = '$owner_id'
LIMIT 1
";

$result = $conn->query($sql);

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo json_encode($row);
}else{
    echo json_encode([
        "center_name" => "No Center Found"
    ]);
}
?>