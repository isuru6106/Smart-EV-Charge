<?php

session_start();

include "db.php";

if(!isset($_SESSION['user_id'])){

    echo "Login required";
    exit();

}

$user_id = $_SESSION['user_id'];

$center_id = $_POST['center_id'];
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$charging_hours = $_POST['charging_hours'];

/* GET CENTER PRICE */

$price_result = $conn->query("

    SELECT price_per_kwh

    FROM charging_centers

    WHERE center_id='$center_id'

");

$price_row = $price_result->fetch_assoc();

$price_per_hour = $price_row['price_per_kwh'];

$estimated_amount =
    $price_per_hour * $charging_hours;

/* VALIDATE DATE */

if($booking_date < date("Y-m-d")){

    echo "
    <script>
    alert('Past dates are not allowed.');
    window.history.back();
    </script>
    ";

    exit();

}

/* VALIDATE HOURS */

if(

    $charging_hours < 1 ||

    $charging_hours > 24

){

    echo "
    <script>
    alert('Charging hours must be between 1 and 24.');
    window.history.back();
    </script>
    ";

    exit();

}

/* VALIDATE TIME */

if(

    $booking_date == date("Y-m-d")

){

    if(

        $booking_time < date("H:i")

    ){

        echo "
        <script>
        alert('Past time is not allowed.');
        window.history.back();
        </script>
        ";

        exit();

    }

}


/* ---------------------------------
   CALCULATE REQUESTED TIME RANGE
---------------------------------- */

$requested_start = strtotime(
    $booking_date . " " . $booking_time
);

$requested_end = $requested_start +
(
    $charging_hours * 3600
);

/* ---------------------------------
   GET CENTER TOTAL PORTS
---------------------------------- */

$center_result = $conn->query("

    SELECT total_ports

    FROM charging_centers

    WHERE center_id = '$center_id'

");

$center = $center_result->fetch_assoc();

$total_ports = (int)$center['total_ports'];

/* ---------------------------------
   CHECK OVERLAPPING BOOKINGS
---------------------------------- */

$result = $conn->query("

    SELECT
        booking_time,
        charging_hours

    FROM bookings

    WHERE center_id = '$center_id'

    AND booking_date = '$booking_date'

    AND status IN ('Pending','Approved')

");

$active_bookings = 0;

while($row = $result->fetch_assoc()){

    $existing_start = strtotime(

        $booking_date . " " .

        $row['booking_time']

    );

    $existing_end = $existing_start +

    (

        $row['charging_hours'] * 3600

    );

    /* TIME OVERLAP CHECK */

    if(

        $requested_start < $existing_end

        &&

        $requested_end > $existing_start

    ){

        $active_bookings++;

    }

}

/* ---------------------------------
   NO PORTS AVAILABLE
---------------------------------- */

if($active_bookings >= $total_ports){

    echo "

    <script>

        alert(
            'No charging ports available during this time period.'
        );

        window.history.back();

    </script>

    ";

    exit();

}
//prevents booking without enough money
$getWallet =
$conn->query("

SELECT wallet_balance

FROM users

WHERE id='$user_id'

");

$wallet =
$getWallet->fetch_assoc();

if(
$wallet['wallet_balance'] < $estimated_amount)
{

echo "

<script>

alert(
'Insufficient wallet balance.'
);

window.history.back();

</script>

";

exit();

}
/* ---------------------------------
   CREATE BOOKING
---------------------------------- */

$sql = "

INSERT INTO bookings(

    user_id,
    center_id,
    booking_date,
    booking_time,
    charging_hours,
    status,
    estimated_amount,
    payment_status

)

VALUES(

    '$user_id',
    '$center_id',
    '$booking_date',
    '$booking_time',
    '$charging_hours',
    'Pending',
    '$estimated_amount',
    'Pending'

)

";

if($conn->query($sql)){

    /* CREATE NOTIFICATION */

    $conn->query("

        INSERT INTO notifications(

            user_id,
            title,
            message

        )

        VALUES(

            '$user_id',

            'Booking Submitted',

            'Your charging slot booking has been submitted successfully and is awaiting center approval.'

        )

    ");

    header(

        "Location: ../owner/my-bookings.html"

    );

    exit();

}
else{

    echo "Booking failed: " . $conn->error;

}

?>