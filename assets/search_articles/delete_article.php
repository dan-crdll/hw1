<?php
require_once '../../auth.php';
if (!$userid = checkAuth()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['article'])) {
    echo "Errore richiesta";
}

require_once '../../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
$article = mysqli_real_escape_string($conn, $_GET['article']);

$query = "SELECT AUTHOR FROM ARTICLES WHERE ID = " . $article;
$res = mysqli_query($conn, $query);

$entry = mysqli_fetch_assoc($res);
if ($userid !== $entry['AUTHOR']) {
    echo "Non autorizzato";
}

$query = "DELETE FROM LIKES WHERE ARTICLE=" . $article;
mysqli_query($conn, $query);

$query = "DELETE FROM COMMENTS WHERE ARTICLE=" . $article;
mysqli_query($conn, $query);

$query = "DELETE FROM ARTICLES WHERE ID=" . $article;
mysqli_query($conn, $query);

header('Location: /hw1/article_list.php');
