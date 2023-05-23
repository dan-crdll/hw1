<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
?>

<html>

<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./stylesheets/main.css">
    <link rel="stylesheet" href="./stylesheets/home.css">
    <link rel="stylesheet" href="./stylesheets/navbar.css">
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

    <div id="search_container">
        <form>
            <div id="search_bar">
                <label for="search">
                    <i class="fi fi-rr-search-location"></i>
                </label>
                <input type="text" name="search">
            </div>
        </form>
    </div>

    <section>
        <div id="section-title">
            <?php
            if (empty($_GET["search"])) {
                echo "Lasciati ispirare";
            } else {
                echo $_GET["search"];
            }
            ?>
        </div>
        <div id="section-subtitle">
            <?php
            if (empty($_GET["search"])) {
                echo "Ultimi tweet dell'account <span class=\"hashtag\">Trip Advisor</span>";
            } else {
                echo "Ultimi tweet di viaggi con l'hashtag <span class=\"hashtag\">#"
                    . preg_replace('/\s+/', '', $_GET["search"])
                    . "</span> e articoli di altri globetrotters se disponibili";
            }
            ?>
        </div>
        <br>
        <div id="article-container">
            <?php
            if (empty($_GET["search"])) {
                $request = "https://api.twitter.com/2/tweets/search/recent?query=from%3ATripadvisor%20has%3Amedia%20-is%3Aretweet&expansions=attachments.media_keys&media.fields=url";
            } else {
                $request = "https://api.twitter.com/2/tweets/search/recent?query=(%23"
                    . urlencode(preg_replace('/\s+/', '', $_GET["search"]))
                    . "%20OR%20"
                    . urlencode(preg_replace('/\s+/', '', $_GET["search"]))
                    . "%20)%20%23travel%20has%3Amedia%20-is%3Aretweet&expansions=attachments.media_keys&media.fields=url";
            }
            $conn = curl_init();
            curl_setopt($conn, CURLOPT_URL, $request);
            curl_setopt($conn, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $twitter_token]);
            curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($conn);
            curl_close($conn);
            if (!isset(json_decode($res)->includes)) {
                echo "Nessun risultato...";
            } else {
                $tweets = json_decode($res)->data;
                $media = json_decode($res)->includes->media;

                foreach ($tweets as $tweet) {
                    echo "<article class=\"tweet\">";
                    echo "<div class=\"tweet_text\">";
                    echo $tweet->text;
                    echo "<img src=";
                    foreach ($media as $m) {
                        if (isset($tweet->attachments)) {
                            if ($m->media_key === $tweet->attachments->media_keys[0]) {
                                if (isset($m->url)) {
                                    echo '"' . $m->url . '"';
                                }
                            }
                        }
                    }
                    echo " class=\"tweet_image\"\>";
                    echo "</div>";
                    echo "</article>";
                }
            }
            ?>
        </div>
    </section>

    <footer>
        Made by Daniele S. Cardullo - 1000014469
    </footer>
</body>

</html>