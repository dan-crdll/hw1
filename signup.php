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
    $error = array();
    $conn = mysqli_connect(
        $db_config["host"],
        $db_config['user'],
        $db_config['password'],
        $db_config['name']
    ) or die(mysqli_error($conn));

    #TODO: VARI CHECK DI CONFORMITA' CAMPI

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
        
        if(mysqli_query($conn, $query)) {
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

    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">

    <link rel="stylesheet" href="./stylesheets/landing_style.css">
    <link rel="stylesheet" href="./stylesheets/main.css">
</head>

<body>
    <div id="container">
        <div id="left_container"></div>
        <div id="right_container">
            <div id="title">Globetrotters</div>
            <!-- Container per la registrazione -->
            <div id="signup_container" class="form_container">
                <div class="section_title">
                    Che bello averti a bordo!
                </div>

                <form method="post" name="signup_form">
                    <input type="hidden" value="signup" name="type">
                    <label for="name">Nome <span class="error hidden" id="su_name_error">
                            Nome non valido o troppo lungo.
                        </span></label>
                    <input type="text" id="name" name="name">
                    <label for="surname">Cognome <span class="error hidden" id="su_surname_error">
                            Cognome non valido o troppo lungo.
                        </span></label>
                    <input type="text" id="surname" name="surname">
                    <label for="su_username">Username <span class="error hidden" id="su_user_error">
                        </span></label>
                    <input type="text" id="su_username" name="username">
                    <label for="email">Email <span class="error hidden" id="su_email_error">
                        </span></label>
                    <input type="email" id="email" name="email">
                    <label for="su_password">Password <span class="error hidden" id="su_password_error">
                            La password deve avere minimo 8 caratteri,
                            contenere un numero, un simbolo ed un mix di
                            lettere maiuscole e minuscole, inoltre non
                            può essere più lunga di 50 caratteri
                        </span></label>
                    <input type="password" id="su_password" name="password">

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