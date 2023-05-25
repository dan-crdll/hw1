<?php
require_once 'auth.php';

# TODO: CHECK ACCESSO CORRETTO

require_once 'db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

$title = mysqli_real_escape_string($conn, $_POST['article_title']);
$content = mysqli_real_escape_string($conn, $_POST['article_body']);
$img_url = mysqli_real_escape_string($conn, $_POST['image_url']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$author = mysqli_real_escape_string($conn, $_POST['author']);

$query = 'INSERT INTO ARTICLES(TITLE, CITY, CONTENT, AUTHOR, IMAGE_URL) VALUES("' . $title . '", "' . $city . '", "' . $content . '", ' . $author . ', "' . $img_url . '")';

try {
    mysqli_query($conn, $query);
    header('Location: article.php?q=' . mysqli_insert_id($conn));
} catch (Exception $e) {
    header('Location: article_writing.php?err=1');
} finally {
    mysqli_close($conn);
    exit;
}
