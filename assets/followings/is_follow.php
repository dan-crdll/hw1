<?php
    #TODO: CHECK SEC

    require_once '../../db_config.php';
    $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
    $follower = mysqli_real_escape_string($conn, $_POST['follower']);
    $followed = mysqli_real_escape_string($conn, $_POST['followed']);

    $query = "SELECT * FROM FOLLOWS WHERE FOLLOWER='" . $follower . "' AND FOLLOWED='" . $followed . "'";
    $res = mysqli_query($conn, $query);

    if(mysqli_num_rows($res) > 0) {
        echo json_encode(["follows" => true]);
    } else {
        echo json_encode(["follows" => false]);
    }

    mysqli_close($conn);
?>