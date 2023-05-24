<?php
if (!isset($_GET['email'])) {
    echo 'Errore nella richiesta';
    exit;
}

require_once '../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
$email = mysqli_real_escape_string($conn, $_GET['email']);
$query = "SELECT EMAIL FROM ACCOUNTS WHERE EMAIL='$email'";
$res = mysqli_query($conn, $query);

if (mysqli_num_rows($res) > 0) {
    echo json_encode(['present' => true]);
} else {
    echo json_encode(['present' => false]);
}
