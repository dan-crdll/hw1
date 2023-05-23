<?php
    #TODO: SECURITY CHECKS

    require_once '../../db_config.php';
    $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
    $follower = mysqli_real_escape_string($conn, $_POST['follower']);
    $followed = mysqli_real_escape_string($conn, $_POST['followed']);

    $query = 'DELETE FROM FOLLOWS WHERE (FOLLOWER=' . $follower . ' AND FOLLOWED=' . $followed .')';

    $response = array();

    if(mysqli_query($conn, $query)) {
        $response[] = ["success" => true]; 
    } else {
        echo json_encode(["success" => false]);
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
