<?php
    include 'db_config.php';

    session_start();
    session_destroy();

    header('Location: login.php');
?>