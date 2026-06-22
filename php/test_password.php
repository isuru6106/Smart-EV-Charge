<?php

include "db.php";

$result = $conn->query("
SELECT password_hash
FROM users
WHERE role='admin'
");

$row = $result->fetch_assoc();

if(password_verify(
    "admin123",
    $row['password_hash']
)){
    echo "PASSWORD OK";
}
else{
    echo "PASSWORD FAIL";
}

?>