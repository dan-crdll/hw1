<?php
if (!isset($_GET['q'])) {
    echo "Errore nella richiesta";
    exit;
}

require_once '../../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

$q = mysqli_real_escape_string($conn, $_GET['q']);

$query = "SELECT ID, TITLE, IMAGE_URL FROM ARTICLES WHERE TITLE LIKE '%" . $q . "%' OR CITY LIKE '%" . $q . "%' OR CONTENT LIKE '%" . $q . "%'";

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
