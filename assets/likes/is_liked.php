<?php
if (!isset($_POST['user']) || !isset($_POST['article'])) {
    echo "Errore nella richiesta";
    exit;
}

require_once '../../auth.php';
if (!$userid = checkAuth()) {
    header('Location: login.php');
    exit;
}

if ($_POST['user'] !== $userid) {
    echo "non autorizzato";
    exit;
}

require_once '../../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

$user = mysqli_real_escape_string($conn, $_POST['user']);
$article = mysqli_real_escape_string($conn, $_POST['article']);

$query = "SELECT * FROM LIKES WHERE ARTICLE='" . $article . "' AND USER='" . $user . "'";
$res = mysqli_query($conn, $query);

if (mysqli_num_rows($res) > 0) {
    echo json_encode(["likes" => true]);
} else {
    echo json_encode(["likes" => false]);
}

mysqli_close($conn);
