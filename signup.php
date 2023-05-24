<?php
require_once 'auth.php';

if (checkAuth()) {
    header('Location: home.php');
    exit;
}

if (
    !empty($_POST['name']) && !empty($_POST['surname']) &&
    !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])
) {
    $error = [];
    $conn = mysqli_connect(
        $db_config["host"],
        $db_config['user'],
        $db_config['password'],
        $db_config['name']
    ) or die(mysqli_error($conn));


    #CONFORMITA' USERNAME

    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $_POST['username'])) {
        $error[] = "Formato username non valido";
    } else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $query = "SELECT * FROM ACCOUNTS WHERE USERNAME = '$username'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            $error[] = "Username gia preso!";
        }
    }

    #CONFORMITA' PASSWORD

    if (!preg_match('/^(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $_POST['password'])) {
        $error[] = "Formato password non valido";
    }

    #CONFORMITA' EMAIL

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
        $error[] = "Formato email non valido";
    } else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = "SELECT * FROM ACCOUNTS WHERE EMAIL = '$email'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            $error[] = "email gia registrata!";
        }
    }

    #CONFORMITA' NOME E COGNOME
    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $_POST['name'])) {
        $error[] = "Formato nome non valido";
    }

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $_POST['surname'])) {
        $error[] = "Formato cognome non valido";
    }

    #REGISTRAZIONE NEL DATABASE
    if (count($error) == 0) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $query = "INSERT INTO ACCOUNTS(NAME, SURNAME, USERNAME, EMAIL, PASSWORD) VALUES ('"
            . $name . "', '" . $surname . "', '" . $username . "', '"
            . $email . "', '" . $password . "')";

        if (mysqli_query($conn, $query)) {
            $_SESSION["username"] = $_POST['username'];
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } else {
            $error[] = "Errore di connessione al database";
        }
    }
}
?>

<html>

<head>
    <title>Globetrotters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Work+Sans:ital,wght@0,100;0,400;0,500;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">

    <link rel="stylesheet" href="./stylesheets/landing_style.css">
    <link rel="stylesheet" href="./stylesheets/main.css">

    <script src="./scripts/error_check.js" defer></script>
</head>

<body>
    <div id="container">
        <div id="left_container">

        </div>
        <div id="right_container">
            <div id="title">Globetrotters</div>
            <?php
            if (isset($error) && count($error)) {
                foreach ($error as $e) {
                    echo '<span class="error">' . $e . '</span>';
                }
            }
            ?>
            <!-- Container per la registrazione -->
            <div id="signup_container" class="form_container">
                <div class="section_title">
                    Che bello averti a bordo!
                </div>

                <form method="post" name="signup_form">
                    <label for="name">Nome <span class="error hidden" id="name_error">
                            Nome non valido o troppo lungo.
                        </span></label>
                    <input type="text" id="name" name="name">
                    <label for="surname">Cognome <span class="error hidden" id="surname_error">
                            Cognome non valido o troppo lungo.
                        </span></label>
                    <input type="text" id="surname" name="surname">
                    <label for="username">Username <span class="error hidden" id="username_error">
                            Username non valido o già utilizzato
                        </span></label>
                    <input type="text" id="username" name="username">
                    <label for="email">Email <span class="error hidden" id="email_error">
                            Email non valida o già utilizzata
                        </span></label>
                    <input type="email" id="email" name="email">
                    <label for="password">Password <span class="error hidden" id="password_error">
                            Password non valida
                        </span></label>
                    <input type="password" id="password" name="password">

                    <button type="submit" id="su_btn">Registrati</button>
                </form>

                <a href="login.php" id="toLoginLink">
                    Sei già un globetrotter? Accedi!
                </a>
            </div>
        </div>
    </div>
</body>

</html>