<?php

include "db.php";

$center_id = $_GET['center_id'];

/* Average Rating */

$sql = "
SELECT
ROUND(AVG(rating),1) avg_rating,
COUNT(*) total_reviews

FROM ratings

WHERE center_id = $center_id
";

$row = $conn->query($sql)->fetch_assoc();

$avg_rating =
$row['avg_rating'] ?? 0;

$total_reviews =
$row['total_reviews'] ?? 0;

/* Latest Rating */

$sql = "
SELECT rating

FROM ratings

WHERE center_id = $center_id

ORDER BY rating_id DESC

LIMIT 1
";

$result = $conn->query($sql);

$last_rating = "No Rating";

if($result->num_rows > 0){

    $last_rating =
    $result->fetch_assoc()['rating']
    . " Stars";

}

echo json_encode([

    "avg_rating"=>$avg_rating,
    "total_reviews"=>$total_reviews,
    "last_rating"=>$last_rating

]);

?>