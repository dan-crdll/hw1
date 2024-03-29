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

    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./stylesheets/main.css">
    <link rel="stylesheet" href="./stylesheets/home.css">
    <link rel="stylesheet" href="./stylesheets/navbar.css">
    <link rel="stylesheet" href="./stylesheets/footer.css">
    <link rel="stylesheet" href="./stylesheets/article_list.css">

    <script src="./scripts/home.js" defer></script>
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



    <div id="search_container">
        <form name="search_form">
            <div id="search_bar">
                <label for="search_bar">
                    <button type="submit">
                        <i class="fi fi-rr-search-location"></i>
                    </button>
                </label>
                <input type="text" name="search_bar">
            </div>
        </form>
    </div>

    <section>
        <div id="section-title">
            Lasciati ispirare
        </div>
        <div id="section-subtitle">
            Ultimi tweet dell'account <span class="hashtag">Trip Advisor</span> e articoli più popolari
        </div>
        <br>
        <div id="article-container" class="page">
            <div id="most_popular">

            </div>

            <div id="article-list">

            </div>
        </div>

        <div id="hourglass">
            <img src="./assets/hourglass.gif" class="hidden">
        </div>
    </section>

    <footer>
        Made by Daniele S. Cardullo - 1000014469 <a href="https://github.com/dan-crdll"><img src="./assets/github.png"></a>
    </footer>
</body>

</html>