<?php

session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

/* Average Rating */

$sql = "
SELECT ROUND(AVG(rating),1) avg_rating
FROM ratings
";

$row = $conn->query($sql)->fetch_assoc();

$avg_rating = $row['avg_rating'] ?? 0;

/* Total Reviews */

$sql = "
SELECT COUNT(*) total_reviews
FROM ratings
";

$row = $conn->query($sql)->fetch_assoc();

$total_reviews = $row['total_reviews'];

/* Top Rated Center */

$sql = "
SELECT
c.center_name,
AVG(r.rating) avg_rate

FROM ratings r

JOIN charging_centers c
ON r.center_id = c.center_id

GROUP BY c.center_id

ORDER BY avg_rate DESC

LIMIT 1
";

$result = $conn->query($sql);

$top_center = "No Ratings";

if($result->num_rows > 0){

    $top_center =
    $result->fetch_assoc()['center_name'];

}

/* Last User Rating */

$sql = "
SELECT rating

FROM ratings

WHERE user_id = $user_id

ORDER BY rating_id DESC

LIMIT 1
";

$result = $conn->query($sql);

$last_rating = "None";

if($result->num_rows > 0){

    $last_rating =
    $result->fetch_assoc()['rating']
    . " Stars";

}

echo json_encode([

    "avg_rating"=>$avg_rating,
    "total_reviews"=>$total_reviews,
    "top_center"=>$top_center,
    "last_rating"=>$last_rating

]);

?>