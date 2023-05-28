<?php
require_once 'auth.php';
if (!$user_id = checkAuth()) {
    header('Location: login.php');
    exit;
}
?>

<html>

<head>
    <title>Scrivi un articolo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./stylesheets/navbar.css">
    <link rel="stylesheet" href="./stylesheets/main.css">
    <link rel="stylesheet" href="./stylesheets/article_creation.css">
    <link rel="stylesheet" href="./stylesheets/footer.css">

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

    <form action="create_article.php" method="post" name="article_creation">
        <input type="hidden" name="image_url">
        <input type="hidden" name="author" value="<?php echo $_SESSION['user_id']; ?>">
        <section>
            <div id="article_img"></div>
            <div id="title_sec">
                <input class="title" type="text" name="article_title" id="article_title" value="Inserisci il titolo">

                <div class="error <?php if (!isset($_GET['err']) || !$_GET['err'] = 1) echo 'hidden'; ?>">
                    Problema nella creazione dell'articolo, forse ne esiste già uno con lo stesso nome?
                </div>

                <label for="city_sec">
                    Luogo
                    <input type="text" name="city" id="city_sec">
                </label>
            </div>
            <textarea name="article_body" id="article_body"></textarea>

            <button id="save_btn" type="submit" class="hidden">
                Pubblica
            </button>
        </section>
    </form>

    <footer>
        Made by Daniele S. Cardullo - 1000014469 <a href="https://github.com/dan-crdll"><img src="./assets/github.png"></a>
    </footer>
</body>

</html>