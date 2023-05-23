<!-- PAGINA PHP CHE SI OCCUPA DELLA VISUALIZZAZIONE DI UN ARTICOLO SELEZIONATO -->
<?php
#TODO CONTROLLI ACCESSI SBAGLIATI

#ACCESSO CORRETTO
require_once 'auth.php';
if (!$user_id = checkAuth()) {
    header('Location: login.php');
    exit;
}

require_once 'db_config.php';

$conn = mysqli_connect(
    $db_config['host'],
    $db_config['user'],
    $db_config['password'],
    $db_config['name']
) or die(mysqli_error($conn));

$article = mysqli_real_escape_string($conn, $_GET['q']);
$query = "SELECT * FROM ARTICLES INNER JOIN ACCOUNTS ON AUTHOR=ACCOUNTS.ID WHERE ARTICLES.ID=" . $article;

$res = mysqli_query($conn, $query);
$entry = mysqli_fetch_assoc($res);

mysqli_free_result($res);
mysqli_close($conn);
?>


<html>

<head>
    <title><?php echo $entry["TITLE"]; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./stylesheets/navbar.css">
    <link rel="stylesheet" href="./stylesheets/main.css">
    <link rel="stylesheet" href="./stylesheets/article.css">
    <link rel="stylesheet" href="./stylesheets/footer.css">
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

    <section>
        <div id="article_img" style="background-image: url('<?php echo (empty($entry["IMAGE_URL"]) ? "" : str_replace('"', "", $entry["IMAGE_URL"])  . '"') ?>');">
        </div>
        <div id="title_sec">
            <div id="article_title" class="title"><?php echo $entry["TITLE"] ?></div>
            <div type="text" name="city" id="city_sec">
                <i class="fi fi-rr-marker"></i>
                <?php
                echo $entry["CITY"];
                ?>
                <br>
                <i class="fi fi-rr-circle-user"></i>
                <a href="account.php?user= <?php echo $entry["USERNAME"] ?>">
                    <?php
                    echo "@" . $entry["USERNAME"];
                    ?>
                </a>
            </div>
        </div>
        <div id="article_body">
            <?php
            echo $entry["CONTENT"];
            ?>
        </div>

        <div id="reaction_sec">
            <div id="stats">
                <div id="likes">
                    <img src="./assets/star.png">
                    0
                </div>

                <div id="comments">
                    <img src="./assets/comment.png">
                    0
                </div>
            </div>
        </div>
    </section>

    <footer>
        Made by Daniele S. Cardullo - 1000014469
    </footer>
</body>

</html>