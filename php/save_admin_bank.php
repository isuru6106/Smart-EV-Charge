<?php

session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

$account_name = $_POST['account_name'];
$bank_name = $_POST['bank_name'];
$branch = $_POST['branch'];
$account_number = $_POST['account_number'];

$check = $conn->query("
SELECT *
FROM bank_details
WHERE user_id='$user_id'
");

if($check->num_rows > 0){

    $conn->query("
    UPDATE bank_details
    SET
    account_name='$account_name',
    bank_name='$bank_name',
    branch='$branch',
    account_number='$account_number'
    WHERE user_id='$user_id'
    ");

}else{

    $conn->query("
    INSERT INTO bank_details(
    user_id,
    account_name,
    bank_name,
    branch,
    account_number
    )
    VALUES(
    '$user_id',
    '$account_name',
    '$bank_name',
    '$branch',
    '$account_number'
    )
    ");

}

header("Location: ../admin/admin-bank-details.html");

?>