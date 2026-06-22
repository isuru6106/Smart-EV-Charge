<?php

include "db.php";

$center_name =
$_POST['center_name'];

$address =
$_POST['address'];

$city =
$_POST['city'];

$total_slots =
$_POST['total_slots'];

$price_per_hour =
$_POST['price_per_hour'];

$conn->query("

INSERT INTO charging_centers(

center_name,
address,
city,
total_slots,
available_slots,
price_per_hour,
status

)

VALUES(

'$center_name',
'$address',
'$city',
'$total_slots',
'$total_slots',
'$price_per_hour',
'Open'

)

");

echo "success";

?>