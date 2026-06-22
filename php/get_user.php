<?php

session_start();

header("Content-Type: application/json");

if(isset($_SESSION['full_name'])){

    echo json_encode([

        "success" => true,

        "full_name" =>
        $_SESSION['full_name']

    ]);

}

else{

    echo json_encode([

        "success" => false

    ]);

}

?>