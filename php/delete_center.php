<?php

include "db.php";

$center_id = $_POST['center_id'];

$conn->query("
DELETE FROM charging_centers
WHERE center_id='$center_id'
");

echo "success";

?>