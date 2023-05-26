<?php
require_once '../../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

$query = "SELECT ARTICLES.ID AS ID, TITLE, IMAGE_URL, COUNT(*) AS L FROM LIKES INNER JOIN ARTICLES ON LIKES.ARTICLE = ARTICLES.ID GROUP BY ARTICLE ORDER BY L DESC";

$res = mysqli_query($conn, $query);
$response = [];


if (mysqli_num_rows($res) === 0) {
    $response[] = ["num" => 0];
    echo json_encode($response);
    exit;
}

for ($i = 0; $i < mysqli_num_rows($res); $i++) {
    $response[] = mysqli_fetch_assoc($res);
}
echo json_encode($response);
