<?php
require_once("../db_config.php");

if (empty($_GET["q"])) {
    echo "User vuoto";
    exit;
}

$conn = mysqli_connect(
    $db_config["host"],
    $db_config["user"],
    $db_config["password"],
    $db_config["name"]
) or die();

$query = "SELECT * FROM ARTICLES WHERE AUTHOR=" . mysqli_real_escape_string($conn, $_GET["q"]);

if ($res = mysqli_query($conn, $query)) {
    $response = [];
    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
        $entry = mysqli_fetch_assoc($res);
        $response[] = $entry;
    }
    echo json_encode(["articles" => $response]);
}
