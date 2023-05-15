<!-- URL Type : http://localhost/satisfaction-surveyV2/index.php?inter=999888&tech=goutorbe&date=23/01/2023&choix=4&mail=test@officecenter.fr&NumClient=8888&NumPack=9999 -->
<?php
//Affichage du détail des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();

//Déclaration des variables
$errors = "";
$format = "d/m/Y";
$query = 0;
$request = false;

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

// Récupération de l'url
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url = "https://";
} else {
    $url = "http://";
}
$url .= $_SERVER['HTTP_HOST'];
$sturl = $url;
$url .= $_SERVER['REQUEST_URI'];

// Récupération des paramètres de l'url
$components = parse_url($url);
parse_str($components['query'], $results);
$inter = htmlspecialchars($results['inter']);
$tech = strtolower(htmlspecialchars($results['tech']));
$interdt = htmlspecialchars($results['date']);
$choice = htmlspecialchars($results['choix']);
$email = strtolower(htmlspecialchars($results['mail']));
$NumClient = htmlspecialchars($results['NumClient']);
$NumPack = htmlspecialchars($results['NumPack']);

// Vérification du respect de la charte des paramètres de l'url
if (ctype_digit($inter)) {
    if ($inter > 120000 && $inter < 1000000) {
        if (ctype_alpha($tech) && strlen($tech) < 50) {
            if (DateTime::createFromFormat($format, $interdt)) {
                if ($choice > 0 && $choice < 6) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if (ctype_digit($NumClient)) {
                            if (ctype_digit($NumPack)) {
                                $request = true;
                            } else {
                                $errors .= "Le numéro du pack <strong>" . $email . "</strong> est incorrect";
                            }
                        } else {
                            $errors .= "Le numéro client <strong>" . $email . "</strong> est incorrect";
                        }
                    } else {
                        $errors .= "L'adresse email <strong>" . $email . "</strong> est incorrecte";
                    }
                } else {
                    $errors .= "La notation sélectionnée <strong>" . $choice . "</strong> est incorrecte";
                }
            } else {
                $errors .= "La date saisie <strong>" . $interdt . "</strong> est incorrecte";
            }
        } else {
            $errors .= "Le nom du technicien <strong>" . $tech . "</strong> est incorrect";
        }
    } else {
        $errors .= "Le numéro de l'intervention <strong>" . $inter . "</strong> est incorrect";
    }
} else {
    $errors .= "Le numéro de l'intervention <strong>" . $inter . "</strong> est incorrect";
}

if ($request) {
    // Récupération de la date actuelle
    $getdt = new \DateTime();
    $dt = $getdt->format('d/m/Y');

    // Vérification si l'inter a déjà été notée
    $stmt = $db->prepare("SELECT inter FROM `client_satisfaction` where inter = ?");
    $stmt->execute([$inter]);
    $interCount = $stmt->rowCount();
    $stmt = "";
    if ($interCount == 0) {
        // Vérification si l'email a déjà voté pour 5 étoiles
        $getEmail = $db->prepare("SELECT * FROM `client_satisfaction` where email = ? and choice = 5");
        $getEmail->execute([$email]);
        $emailCount = $getEmail->rowCount();

        // Application de la requête préparée
        $sql = "INSERT INTO `client_satisfaction` (inter, tech, choice, survey_date, inter_date, email, NumClient, NumPack) VALUES (:inter, :tech, :choice, :dt, :interdt, :email, :NumClient, :NumPack)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam('inter', $inter);
        $stmt->bindParam('tech', $tech);
        $stmt->bindParam('choice', $choice);
        $stmt->bindParam('dt', $dt);
        $stmt->bindParam('interdt', $interdt);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('NumClient', $NumClient);
        $stmt->bindParam('NumPack', $NumPack);
        $stmt->execute();

        // Si l'email n'a pas encore mis 5 étoiles, rediriger vers la note Google
        if ($emailCount == 0 && $choice == 5) {
            header("Location: https://g.page/r/CQ_CHW3pUmqBEAI/review");
        }
        $query = 1;
    } elseif ($interCount == 1) {
        // Vérification si l'email a déjà voté pour 5 étoiles
        $getEmail = $db->prepare("SELECT * FROM `client_satisfaction` where email = ? and choice = 5");
        $getEmail->execute([$email]);
        $emailCount = $getEmail->rowCount();

        // Application de la requête préparée
        $update = "UPDATE `client_satisfaction` SET survey_date = :dt, choice = :choice WHERE inter = :inter";
        $stmt = $db->prepare($update);
        $stmt->bindParam('dt', $dt);
        $stmt->bindParam('choice', $choice);
        $stmt->bindParam('inter', $inter);
        $stmt->execute();
        $query = 2;

        // Si l'email n'a pas encore mis 5 étoiles, rediriger vers la note Google
        if ($emailCount == 0 && $choice == 5) {
            echo '<script>window.location.href = "https://g.page/r/CQ_CHW3pUmqBEAI/review";</script>';
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
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
    </style>
</head>

<body>
    <?php
    if ($query == 1) { ?>
        <div class="container">
            <div class="popup">
                <img src="./tick.png">
                <h1>Merci d'avoir donné votre avis</h1>
                <p>Votre note de <?php echo $choice ?> étoiles concernant l'intervention <?php echo $inter; ?> a bien été pris en compte</p>
                <p><span id="timer"></span></p>
                <a href=<?php echo 'http://localhost/satisfaction-surveyV2/ajouter_un_commentaire/index.php?inter=' . $inter; ?>><button type="button">Ajouter un commentaire</button></a>
            </div>
        </div>
    <?php } elseif ($query == 0) { ?>
        <div class="container">
            <div class="popup open-popup">
                <img src="./no.png">
                <h1>Une erreur est survenue :</h1>
                <p><?php echo $errors; ?></p>
                <p><span id="timer"></span></p>
                <a href="https://www.officecenter.fr"><button type="button">OK</button></a>
            </div>
        </div>
    <?php } elseif ($query == 2) { ?>
        <div class="container">
            <div class="popup open-popup">
                <img src="./tick.png">
                <h1>Votre choix a bien été modifié</h1>
                <p>Votre nouvelle note de <?php echo $choice ?> étoiles concernant l'intervention <?php echo $inter; ?> a bien été pris en compte</p>
                <p><span id="timer"></span></p>
                <a href=<?php echo 'http://localhost/satisfaction-surveyV2/ajouter_un_commentaire?inter=' . $inter; ?>><button type="button">Ajouter un commentaire</button></a>
            </div>
    <?php } ?>

        <script type="text/javascript">
            let count = 10;
            let redirect = "https://www.officecenter.fr";

            function countdown() {
                let timer = document.getElementById("timer");
                if (count > 0) {
                    count--;
                    timer.innerHTML = "<br>Cette page sera redirigée dans <br><strong>" + count + " secondes.</strong>";
                    setTimeout("countdown()", 1000);
                } else {
                    window.location.href = redirect;
                }
            }
            countdown();
        </script>-->
</body>

</html>