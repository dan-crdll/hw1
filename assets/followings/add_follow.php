<?php
if (!isset($_POST['follower']) || !isset($_POST['followed'])) {
    echo "Errore nella richiesta";
    exit;
}

require_once '../../auth.php';
if (!$userid = checkAuth()) {
    header('Location: login.php');
    exit;
}

if ($_POST['follower'] !== $userid || $_POST['followed'] === $userid) {
    echo "non autorizzato";
    exit;
}

require_once '../../db_config.php';

$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
$follower = mysqli_real_escape_string($conn, $_POST['follower']);
$followed = mysqli_real_escape_string($conn, $_POST['followed']);

$query = 'INSERT INTO FOLLOWS(FOLLOWER, FOLLOWED) VALUES (' . $follower . ', ' . $followed . ')';

if (mysqli_query($conn, $query)) {
    $response[] = ["success" => true];
} else {
    $response[] = ["success" => true];
    echo json_encode($response);
    mysqli_close($conn);
    exit;
}

$query = 'SELECT COUNT(*) AS NUM FROM FOLLOWS WHERE FOLLOWED=' . $followed . ' GROUP BY FOLLOWED';

$res = mysqli_query($conn, $query);
$entry = mysqli_fetch_assoc($res);
$response[] = ["num" => $entry['NUM']];

echo json_encode($response);
mysqli_close($conn);
exit;
