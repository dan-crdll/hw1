<?php
require_once './api_keys.php';
$headers = [
    "Authorization: Basic " . base64_encode($api_keys['twitter'] . ':' . $api_secrets['twitter']),
    "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
];

$body = "grant_type=client_credentials";

$curl = curl_init('https://api.twitter.com/oauth2/token');
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

$res = curl_exec($curl);
curl_close($curl);

$token = json_decode($res)->access_token;

if (!isset($_GET['q']) || empty($_GET['q'])) {
    $tweets = fetchFromTripAdvisor($token);
} else {
    $tweets = fetchRequested($token, $_GET['q']);
}

$data = $tweets->data;
$media = $tweets->includes->media;

$response = [];

foreach($data as $t) {
    foreach($media as $m) {
        if($m->media_key === $t->attachments->media_keys[0] && $m->type === "photo") {
            $response[] = ["content" => $t->text, "photo" => $m->url];
        } else {
            continue;
        }
    }
}

if(empty($response)) {
    $response = ["num" => 0];
}

echo json_encode($response);

function fetchFromTripAdvisor($token)
{
    $headers = ["Authorization: Bearer " . $token];
    $endpoint = "https://api.twitter.com/2/tweets/search/recent?query=";
    $query = urlencode("from:Tripadvisor has:media -is:retweet");
    $expansion = '&expansions=' . urlencode("attachments.media_keys") . '&media.fields=url';

    $curl = curl_init($endpoint . $query . $expansion);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $res = curl_exec($curl);
    curl_close($curl);
    return json_decode($res);
}

function fetchRequested($token, $q)
{
    $headers = ["Authorization: Bearer " . $token];
    $endpoint = "https://api.twitter.com/2/tweets/search/recent?query=";
    $query = urlencode("(trip OR travel) " . $q . " has:media -is:retweet");
    $expansion = '&expansions=' . urlencode("attachments.media_keys") . '&media.fields=url';

    $curl = curl_init($endpoint . $query . $expansion);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $res = curl_exec($curl);
    curl_close($curl);
    return json_decode($res);
}
