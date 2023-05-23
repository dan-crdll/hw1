<?php
require_once("api_keys.php");

$url = "https://api.unsplash.com/photos/random?client_id=" . $api_keys["unsplash"];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($curl);
$json = json_decode($res);
curl_close($curl);

echo json_encode(["link" => $json->urls->regular]);
