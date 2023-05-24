<?php
# TODO: Security Checks

require_once '../../db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

$article = mysqli_real_escape_string($conn, $_POST['article']);
$query = "SELECT USERNAME, CONTENT, COMMENT_DATE FROM COMMENTS INNER JOIN ACCOUNTS ON ACCOUNTS.ID=AUTHOR WHERE ARTICLE=" . $article;

$res = mysqli_query($conn, $query);
$num = mysqli_num_rows($res);

if ($num === 0) {
    echo json_encode(["num" => 0]);
} else {
    $comments = [];
    for ($i = 0; $i < $num; $i++) {
        $comments[] = mysqli_fetch_assoc($res);
    }
    echo json_encode(["num" => $num, "comments" => $comments]);
}


mysqli_close($conn);
exit;
