<?php
require_once("auth.php");
require_once("./assets/api_keys.php");
require_once("db_config.php");

if (!checkAuth()) {
    header("Location: landing_page.php");
    exit();
}

if (trim($_GET['user']) === $_SESSION['username']) {
    header("Location: profile.php");
    exit();
}

$conn = mysqli_connect(
    $db_config["host"],
    $db_config["user"],
    $db_config["password"],
    $db_config["name"]
) or die(mysqli_error($conn));

$query = "SELECT * FROM ACCOUNTS WHERE USERNAME='" . trim(mysqli_real_escape_string($conn, $_GET["user"])) . "'";

if ($res = mysqli_query($conn, $query)) {
    $account = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
}
?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
    <script src="./scripts/fetch_random_pic.js" defer></script>


    <link rel="stylesheet" href="./stylesheets/main.css">
    <link rel="stylesheet" href="./stylesheets/navbar.css">
    <link rel="stylesheet" href="./stylesheets/profile.css">
    <link rel="stylesheet" href="./stylesheets/account.css">
    <link rel="stylesheet" href="./stylesheets/article_list.css">
    <link rel="stylesheet" href="./stylesheets/footer.css">

    <script>
        const follower = <?php echo $_SESSION['user_id']; ?>;
        const followed = <?php echo $account['ID']; ?>;
    </script>

    <script src="./scripts/add_follow.js" defer></script>
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

    <div id="prof_img"></div>
    <div id="info">
        <div id="name">
            <?php echo "@" . $account["USERNAME"] ?>
        </div>
        <div id="follow">
            <img>
            <div id="num_follow">
                <?php
                $query = 'SELECT COUNT(*) AS NUM FROM FOLLOWS WHERE FOLLOWED=' . $account['ID'] . ' GROUP BY FOLLOWED';

                $res = mysqli_query($conn, $query);
                if (mysqli_num_rows($res)) {
                    $entry = mysqli_fetch_assoc($res);
                    echo $entry['NUM'];
                } else {
                    echo '0';
                }
                ?></div>
        </div>
    </div>

    <div id="profile_content">
        <div class="section_title">
            <i class="fi fi-rr-plane-alt"></i>
            Contributi
        </div>
        <div id="articles">
            <?php
            $query = "SELECT * FROM ARTICLES WHERE AUTHOR=" . $account["ID"];

            if ($res = mysqli_query($conn, $query)) {
                if (mysqli_num_rows($res) > 0) {
                    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                        $entry = mysqli_fetch_assoc($res);
                        echo '<a class="article" href=article.php?q=' . $entry["ID"] . '>';
                        echo '<div class="image_article" style="background-image: url(' . $entry["IMAGE_URL"] . ')"></div>';
                        echo '<div class="article_title">' . $entry['TITLE'] . '</div>';
                        echo '</a>';
                    }
                } else {
                    echo "Non è stato trovato nessun contributo...";
                }
            }
            ?>
        </div>

        <hr>
    </div>

    <footer>
        Made by Daniele S. Cardullo - 1000014469 <a href="https://github.com/dan-crdll"><img src="./assets/github.png"></a>
    </footer>
</body>
<?php
mysqli_close($conn);
?>

</html>