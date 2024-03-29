<?php
if (
    !isset($_POST['content']) || !isset($_POST['article']) || !isset($_POST['user'])
    || !isset($_POST['date'])
) {
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

$content = mysqli_real_escape_string($conn, $_POST['content']);
$article = mysqli_real_escape_string($conn, $_POST['article']);
$user = mysqli_real_escape_string($conn, $_POST['user']);
$date = mysqli_real_escape_string($conn, $_POST['date']);

$query = "INSERT INTO COMMENTS(AUTHOR, CONTENT, ARTICLE, COMMENT_DATE) VALUES (" . $user . ", '" . $content . "', " . $article . ", '" . $date . "')";

$res = mysqli_query($conn, $query);

mysqli_close($conn);
exit;
