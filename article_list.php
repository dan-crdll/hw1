<?php
require_once 'auth.php';
if (!checkAuth()) {
    header('Location: login.php');
    exit;
}

require_once 'db_config.php';
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']);
$query = 'SELECT * FROM ARTICLES ORDER BY ID DESC';
$res = mysqli_query($conn, $query);
if (mysqli_num_rows($res) > 0) {
    $present = true;
} else {
    $present = false;
}

mysqli_close($conn);

?>

<html>

<head>
    <title>Esplora gli articoli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./stylesheets/navbar.css">
    <link rel="stylesheet" href="./stylesheets/main.css">
    <link rel="stylesheet" href="./stylesheets/article_list.css">
    <link rel="stylesheet" href="./stylesheets/footer.css">
    <link rel="stylesheet" href="./stylesheets/profile.css">
    <link rel="stylesheet" href="./stylesheets/list_footer.css">

    <script src="./scripts/article_creation.js" defer></script>
    <script src="./scripts/sandwich_btn.js" defer></script>
</head>

<body>

    <header id="navbar">
        <a href="/hw1/home.php" id="title_link">
            <img src="./assets/world.svg" id="logo">
            <div id="title">
                Globetrotters
            </div>
        </a>

        <div id="link-group">
            <a href="home.php" class="tabs">
                <i class="fi fi-rr-house-blank"></i>
                Home
            </a>

            <a href="article_list.php" class="tabs">
                <i class="fi fi-rr-plane"></i>
                Articoli
            </a>

            <a href="article_writing.php" class="tabs">
                <i class="fi fi-rr-pen-nib"></i>
                Scrivi un articolo
            </a>

            <a href="profile.php" class="tabs">
                <i class="fi fi-rr-user"></i>
                <?php echo $_SESSION["username"] ?>
            </a>

            <a id="logout_btn" href="logout.php">
                Logout
            </a>
        </div>

        <div id="sandwich_btn">
            <i class="fi fi-rr-settings-sliders"></i>
        </div>

    </header>

    <div id="sandwich">
        <a href="home.php" class="tabs">
            <i class="fi fi-rr-house-blank"></i>
            Home
        </a>

        <a href="article_list.php" class="tabs">
            <i class="fi fi-rr-plane"></i>
            Articoli
        </a>

        <a href="article_writing.php" class="tabs">
            <i class="fi fi-rr-pen-nib"></i>
            Scrivi un articolo
        </a>

        <a href="profile.php" class="tabs">
            <i class="fi fi-rr-user"></i>
            <?php echo $_SESSION["username"] ?>
        </a>

        <a id="logout_btn" href="logout.php">
            Logout
        </a>
    </div>


    <section class="page">
        <?php

        if (!$present) {
            echo '<div class="non_found">
                Non ci sono articoli da mostrare...
            </div>';
        } else {
            for ($i = mysqli_num_rows($res); $i > 0; $i--) {
                $entry = mysqli_fetch_assoc($res);
                echo '<a class="article" href=article.php?q=' . $entry["ID"] . '>';
                echo '<div class="image_article" style="background-image: url(' . $entry["IMAGE_URL"] . ')"></div>';
                echo '<div class="article_title">' .
                    (strlen($entry['TITLE']) > 60 ? (substr($entry['TITLE'], 0, 60) . '...') : $entry['TITLE'])
                    . '</div>';
                echo '</a>';
            }
        }
        mysqli_free_result($res);

        ?>
    </section>

    <footer>
        Made by Daniele S. Cardullo - 1000014469 <a href="https://github.com/dan-crdll"><img src="./assets/github.png"></a>
    </footer>
</body>

</html>