<?php

include "db.php";

$user_id =
$_POST['user_id'];

$center_id =
$_POST['center_id'];

$rating =
$_POST['rating'];

$comment =
$_POST['comment'];

$sql = "INSERT INTO ratings
(
user_id,
center_id,
rating,
comment
)

VALUES
(
'$user_id',
'$center_id',
'$rating',
'$comment'
)";

if ($conn->query($sql)) {

header(
"Location: ../owner/ratings.html"
);

exit();

} else {

echo $conn->error;

}

?>