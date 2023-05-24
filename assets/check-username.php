<?php
if (!isset($_GET['user'])) {
    echo 'Errore nella richiesta';
    exit;
}

require_once '../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
$user = mysqli_real_escape_string($conn, $_GET['user']);
$query = "SELECT USERNAME FROM ACCOUNTS WHERE USERNAME='$user'";
$res = mysqli_query($conn, $query);

if (mysqli_num_rows($res) > 0) {
    echo json_encode(['present' => true]);
} else {
    echo json_encode(['present' => false]);
}
