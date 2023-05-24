<?php
require_once("auth.php");
require_once("./assets/api_keys.php");
require_once("db_config.php");

if (!checkAuth()) {
    header("Location: landing_page.php");
}

$conn = mysqli_connect(
    $db_config["host"],
    $db_config["user"],
    $db_config["password"],
    $db_config["name"]
) or die(mysqli_error($conn));

$query = "SELECT NAME, SURNAME FROM ACCOUNTS WHERE ID = " . $_SESSION["user_id"];

if ($res = mysqli_query($conn, $query)) {
    $entry = mysqli_fetch_assoc($res);
    $name = $entry["NAME"];
    $surname = $entry["SURNAME"];
}
?>


<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <script src="./scripts/fetch_random_pic.js" defer></script>
    <script src="./scripts/profile_page_articles.js" defer></script>

    <link rel="stylesheet" href="./stylesheets/main.css">
    <link rel="stylesheet" href="./stylesheets/navbar.css">
    <link rel="stylesheet" href="./stylesheets/profile.css">
    <link rel="stylesheet" href="./stylesheets/article_list.css">
    <link rel="stylesheet" href="./stylesheets/footer.css">

    <script>
        const user_id = <?php echo $_SESSION["user_id"]; ?>
    </script>
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
    </header>


    <div id="prof_img"></div>
    <div id="info">
        <div id="name">
            <?php echo ucfirst($name) . " " . ucfirst($surname) ?>
        </div>
        <div id="username">
            @<?php echo $_SESSION["username"] ?> -
            <?php
            $query = "SELECT * FROM FOLLOWS WHERE FOLLOWED=" . $_SESSION["user_id"];
            $res = mysqli_query($conn, $query);
            echo mysqli_num_rows($res);
            ?> Follower <?php if (mysqli_num_rows($res) > 1) echo "s"; ?>
            <img id="follow_ico" src="./assets/full_following.png">
        </div>
    </div>

    <div id="profile_content">
        <div class="section_title">
            <i class="fi fi-rr-plane-alt"></i>
            Contributi
        </div>
        <div id="articles">

        </div>

        <hr>

        <div class="section_title">
            <i class="fi fi-rr-star"></i>
            Mi piace
        </div>

        <div class="page">
            <?php
            $query = "SELECT ARTICLES.ID, IMAGE_URL, TITLE FROM LIKES INNER JOIN ARTICLES ON LIKES.ARTICLE = ARTICLES.ID WHERE USER=" . $_SESSION['user_id'];
            $res = mysqli_query($conn, $query);

            if (mysqli_num_rows($res) === 0) {
                echo 'Non hai ancora messo mi piace a nessun articolo';
            } else {
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                    $entry = mysqli_fetch_assoc($res);
                    echo '<a class="article" href=article.php?q=' . $entry["ID"] . '>';
                    echo '<div class="image_article" style="background-image: url(' . $entry["IMAGE_URL"] . ')"></div>';
                    echo '<div class="article_title">' . $entry['TITLE'] . '</div>';
                    echo '</a>';
                }
            }
            mysqli_free_result($res);

            ?>
        </div>

        <hr>

        <div class="section_title">
            <i class="fi fi-rr-following"></i>
            Seguiti
        </div>

        <div id="followed_list">
            <?php
            $query = 'SELECT USERNAME FROM ACCOUNTS WHERE ID IN (SELECT FOLLOWED FROM FOLLOWS WHERE FOLLOWER=' . $_SESSION['user_id'] . ')';
            $res = mysqli_query($conn, $query);

            if (mysqli_num_rows($res) === 0) {
                echo 'Non segui nessuno... esplora!';
            } else {
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                    $entry = mysqli_fetch_assoc($res);
                    echo '<a class="account" href="account.php?user=' . $entry['USERNAME'] . '">';
                    echo '@' . $entry['USERNAME'];
                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>

    <footer>
        Made by Daniele S. Cardullo - 1000014469
    </footer>
</body>
<?php
mysqli_close($conn);
?>

</html>