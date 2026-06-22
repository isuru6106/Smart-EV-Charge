<?php

session_start();

include "../php/db.php";

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.html");

    exit();

}

$user_id = $_SESSION['user_id'];

/* TOTAL BOOKINGS */

$total_sql =

"SELECT COUNT(*) AS total

FROM bookings

WHERE user_id='$user_id'";

$total_result =

$conn->query($total_sql);

$total_bookings =

$total_result->fetch_assoc()['total'];

/* APPROVED */

$approved_sql =

"SELECT COUNT(*) AS approved

FROM bookings

WHERE user_id='$user_id'

AND status='Approved'";

$approved_result =

$conn->query($approved_sql);

$approved =

$approved_result->fetch_assoc()['approved'];

/* PENDING */

$pending_sql =

"SELECT COUNT(*) AS pending

FROM bookings

WHERE user_id='$user_id'

AND status='Pending'";

$pending_result =

$conn->query($pending_sql);

$pending =

$pending_result->fetch_assoc()['pending'];

/* COMPLETED */

$completed_sql =

"SELECT COUNT(*) AS completed

FROM bookings

WHERE user_id='$user_id'

AND status='Completed'";

$completed_result =

$conn->query($completed_sql);

$completed =

$completed_result->fetch_assoc()['completed'];

/* BOOKINGS TABLE */

$sql =

"SELECT bookings.*,

charging_centers.center_name,

charging_centers.city

FROM bookings

JOIN charging_centers

ON bookings.center_id =
charging_centers.center_id

WHERE bookings.user_id='$user_id'

ORDER BY bookings.booking_id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,
initial-scale=1.0">

<title>My Bookings</title>

<link rel="stylesheet"
href="../assets/css/style.css">

</head>

<body>

<div class="dashboard-bg"></div>

<div class="dashboard-overlay"></div>

<nav class="navbar">

<div class="logo">

⚡ Smart<span>EV</span> Charge

</div>

<div class="nav-links">

<a href="owner-dashboard.html">

Dashboard

</a>

<a href="gps-map.html">

GPS Centers

</a>

<a href="book-slot.html">

Book Slot

</a>

<a class="active"
href="my-bookings.php">

My Bookings

</a>

<a href="../php/logout.php">

Logout

</a>

</div>

</nav>

<main class="dashboard-modern">

<section class="grid dashboard-kpis">

<div class="card">

<h3>Total Bookings</h3>

<p>All charging reservations</p>

<div class="kpi">

<?php echo $total_bookings; ?>

</div>

</div>

<div class="card">

<h3>Approved</h3>

<p>Confirmed charging bookings</p>

<div class="kpi">

<?php echo $approved; ?>

</div>

</div>

<div class="card">

<h3>Pending</h3>

<p>Waiting for center approval</p>

<div class="kpi">

<?php echo $pending; ?>

</div>

</div>

<div class="card">

<h3>Completed</h3>

<p>Finished charging sessions</p>

<div class="kpi">

<?php echo $completed; ?>

</div>

</div>

</section>

<section class="card"
style="margin-top:30px;">

<div style="
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
">

<div>

<h2>Recent Bookings</h2>

<p>

Your latest charging bookings

</p>

</div>

<a class="btn"
href="book-slot.html">

+ Book New Slot

</a>

</div>

<div class="table-wrapper">

<table class="booking-table">

<thead>

<tr>

<th>ID</th>

<th>Center</th>

<th>Date</th>

<th>Time</th>

<th>Hours</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

while($row =
$result->fetch_assoc()){

?>

<tr>

<td>

#BK<?php
echo $row['booking_id'];
?>

</td>

<td>

<?php
echo $row['center_name'];
?>

<br>

<small>

<?php
echo $row['city'];
?>

</small>

</td>

<td>

<?php
echo $row['booking_date'];
?>

</td>

<td>

<?php
echo $row['booking_time'];
?>

</td>

<td>

<?php
echo $row['charging_hours'];
?>

hrs

</td>

<td>

<span class="status-badge">

<?php
echo $row['status'];
?>

</span>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</section>

</main>

</body>

</html>