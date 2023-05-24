<?php
    include 'auth.php';
    if (checkAuth()) {
        header('Location: home.php');
        exit;
    }

    if (!empty($_POST["username"]) && !empty($_POST['password'])) {
        require_once('db_config.php');
        $conn = mysqli_connect(
            $db_config["host"],
            $db_config["user"],
            $db_config["password"],
            $db_config["name"]
        );

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $query = "SELECT * FROM ACCOUNTS WHERE USERNAME = '" . $username . "'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['PASSWORD'])) {
                $_SESSION['user_id'] = $entry['ID'];
                $_SESSION['username'] = $entry['USERNAME'];
                header('Location: home.php');
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        $error = "Username e/o password errati.";
    } else if (isset($_POST['username']) || isset($_POST['password'])) {
        $error = 'Inserisci username e password';
    }
?>

<html>

<head>
    <title>Globetrotters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylesheets/landing_style.css">
    <link rel="stylesheet" href="./stylesheets/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">
</head>

<body>
    <div id="container">
        <div id="left_container"></div>
        <div id="right_container">
            <div id="title">Globetrotters</div>

            <!-- Container per il login -->
            <div id="login_container" class="form_container">
                <div class="section_title">
                    Bentornato globetrotter!
                </div>

                <form method="post" name="login_form">
                    <input type="hidden" value="login" name="type">
                    <label for="username">Username <span class="error hidden" id="lo_user_error">

                        </span></label>
                    <input type="text" id="username" name="username">
                    <label for="password">Password <span class="error hidden" id="lo_password_error">
                            La password deve avere minimo 8 caratteri,
                            contenere un numero, un simbolo ed un mix di
                            lettere maiuscole e minuscole, inoltre non
                            può essere più lunga di 50 caratteri
                        </span></label>
                    <input type="password" id="password" name="password">

                    <button type="submit">Log In</button>
                </form>

                <a href="/hw1/signup.php" id="toSignupLink">
                    Non sei ancora un globetrotter? Registrati!
                </a>
            </div>
        </div>
    </div>
</body>

</html>