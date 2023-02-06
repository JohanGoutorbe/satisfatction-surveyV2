<?php
//Affichage du détail des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();

//Déclaration des variables
$caracteresMAX = 500;
$_SESSION['errors'] = '';
$_SESSION['commun'] = '171618458';

// Connexion à la base de données
define('USER', "root");
define('PASSWD', "");
define('SERVER', "localhost");
define('BASE', 'officecequalit');

$dsn = "mysql:dbname=" . BASE . ";host=" . SERVER;

try {
    $db = new PDO($dsn, USER, PASSWD);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage() . "<br>");
}

$inter = htmlspecialchars($_SESSION['inter']);

if (isset($_POST['comment'])) {
    $comment = htmlspecialchars($_POST['comment']);
    $len = strlen($comment);
    if ($len < $caracteresMAX){
        $sql = "UPDATE client_satisfaction SET comment = :comment WHERE inter = :inter";
        $stmt = $db->prepare($sql);
        $stmt->bindParam('inter', $inter);
        $stmt->bindParam('comment', $comment);
        $stmt->execute();
        $_SESSION['comment'] = $_SESSION['commun'];
    } else {
        $caractersSupp = $len - $caracteresMAX;
        $_SESSION['comment'] = $comment;
        $_SESSION['errors'] = '<p style="color:red; font-size:13px">500 caractères maximum.<br>Veuillez retirer ' . $caractersSupp . ' caractères au message<p>';
    }
} else {
    $_SESSION['comment'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satisfaction Survey V2</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital@1&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            width: 100%;
            height: 100vh;
            background: #3c5077;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .popup {
            width: 400px;
            background: #fff;
            border-radius: 6px;
            position: absolute;
            text-align: center;
            padding: 0 30px 30px;
            color: #333;
            animation: open 0.75s ease;
        }

        @keyframes open {
            0% {
                top: 0;
                left: 50%;
                transform: translate(-50%, -50%) scale(0.1);
                visibility: hidden;
            }

            100% {
                visibility: visible;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .popup img {
            width: 100px;
            margin-top: -50%;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .popup h1 {
            font-size: 38px;
            font-weight: 500;
            margin: 30px 0 10px;
            padding-bottom: 10px;
        }

        .popup button {
            width: 100%;
            margin-top: 35px;
            padding: 10px 0;
            background: #1b74e4;
            color: #fff;
            border: 0;
            outline: none;
            font-size: 18px;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
        }

        textarea {
            padding : 10px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="popup">
            <img src="../tick.png">
            <h1>Ajoutez un commentaire : </h1>
            <form action="" method="post" name="commentForm">
                <textarea name="comment" id="comment" cols="40" rows="5"></textarea>
                <?php
                    if (isset($_SESSION['errors'])) {
                        echo "<br>" . $_SESSION['errors'];
                    }
                    ?>
                <button type="submit">OK</button>
            </form>
        </div>
    </div>
</body>

</html>