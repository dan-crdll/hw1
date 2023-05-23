<?php
require_once("./assets/api_keys.php");

if (empty($_GET["q"])) {
    echo "Non dovresti essere qui";
    exit;
}

$url = "https://api.unsplash.com/search/photos?page=1&query=";
$conn = curl_init($url . $_GET["q"] . "&client_id=" . $api_keys["unsplash"]);
curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($conn);

$resultArray = json_decode($res)->results;

if (sizeof($resultArray)) {
    $resNum = rand(0, sizeof($resultArray) - 1);

    echo json_encode([
        "found" => true,
        "link" => json_decode($res)->results[$resNum]->urls->regular
    ]);
} else {
    echo json_encode(["found" => false]);
}