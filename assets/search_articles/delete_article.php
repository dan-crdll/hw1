<?php
if (!isset($_GET['article'])) {
    echo "Errore richiesta";
}

require_once '../../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
$article = mysqli_real_escape_string($conn, $_GET['article']);

$query = "DELETE FROM LIKES WHERE ARTICLE=" . $article;
mysqli_query($conn, $query);

$query = "DELETE FROM COMMENTS WHERE ARTICLE=" . $article;
mysqli_query($conn, $query);

$query = "DELETE FROM ARTICLES WHERE ID=" . $article;
mysqli_query($conn, $query);

echo json_encode(['success' => true]);
