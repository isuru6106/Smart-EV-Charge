<?php

session_start();

include "db.php";

$owner_id = $_SESSION['user_id'];

$account_name = $_POST['account_name'];
$bank_name = $_POST['bank_name'];
$branch = $_POST['branch'];
$account_number = $_POST['account_number'];

$check = $conn->query("

SELECT *

FROM owner_bank_details

WHERE owner_id='$owner_id'

");

if($check->num_rows > 0){

    $conn->query("

    UPDATE owner_bank_details

    SET

    account_name='$account_name',
    bank_name='$bank_name',
    branch='$branch',
    account_number='$account_number'

    WHERE owner_id='$owner_id'

    ");

}
else{

    $conn->query("

    INSERT INTO owner_bank_details(

    owner_id,
    account_name,
    bank_name,
    branch,
    account_number

    )

    VALUES(

    '$owner_id',
    '$account_name',
    '$bank_name',
    '$branch',
    '$account_number'

    )

    ");

}

header("Location: ../owner/bank-details.html");

?>