<?php
#TODO: SECURITY CHECK

require_once '../../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

$article = mysqli_real_escape_string($conn, $_POST['article']);
$user = mysqli_real_escape_string($conn, $_POST['user']);

$query = "INSERT INTO LIKES(ARTICLE, USER) VALUES (" . $article . ", " . $user . ")";

if ($res = mysqli_query($conn, $query)) {
    $response[] = ["success" => true];
} else {
    $response[] = ["success" => false];
    echo json_encode($response);
    exit;
}

$query = "SELECT COUNT(*) AS NUM FROM LIKES WHERE ARTICLE=" . $article . " GROUP BY ARTICLE";
$res = mysqli_query($conn, $query);
$entry = mysqli_fetch_assoc($res);
$response[] = ["num" => $entry['NUM']];
echo json_encode($response);
exit;