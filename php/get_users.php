<?php

include "db.php";

$sql = "
SELECT
id,
full_name,
email,
role
FROM users
ORDER BY id DESC
";

$result = $conn->query($sql);

$users = [];

while($row = $result->fetch_assoc()){

    $users[] = $row;

}

echo json_encode($users);

?>