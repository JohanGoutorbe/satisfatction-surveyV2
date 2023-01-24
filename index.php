<!-- URL Type : http://localhost/satisfaction-surveyV2/index.php?inter=123456&tech=goutorbe&date=23/01/2023&choix=3 -->
<?php
//Affichage des erreurs en détail
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();

//Déclaration des variables
$errors = "";

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
$tech = htmlspecialchars($results['tech']);
$interdt = htmlspecialchars($results['date']);
$choice = htmlspecialchars($results['choix']);

// Récupération de la date actuelle sous le format JJ/MM/AAAA
$getdt = new \DateTime();
$dt = $getdt->format('d/m/Y');

// Vérification de la validité du numéro d'intervention
$stmt = $db->prepare("SELECT * FROM client_satisfaction where inter = ?");
$stmt->execute([$inter]);
$interCount = $stmt->rowCount();
$stmt = "";

if ($interCount == 0) {
    // Application de la requête préparée
    $sql = "INSERT INTO client_satisfaction (inter, tech, choice, survey_date, inter_date) VALUES (:inter, :tech, :choice, :dt, :interdt)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam('inter', $inter);
    $stmt->bindParam('tech', $tech);
    $stmt->bindParam('choice', $choice);
    $stmt->bindParam('dt', $dt);
    $stmt->bindParam('interdt', $interdt);
    $stmt->execute();
    $query = true;
} elseif ($interCount > 0) {
    $errors .= "L'intervention " . $inter . " possède déjà un questionnaire.";
    $query = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satisfaction Survey V2</title><link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital@1&display=swap" rel="stylesheet"> 
    <style>
        * {
            margin: 0;
            padding : 0;
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
        }
        .popup {
            width: 400px;
            background: #fff;
            border-radius: 6px;
            position: absolute;
            text-align: center;
            padding: 0 30px 30px;
            color: #333;
            animation: open 0.5s ease;
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
            background: #6fd649;
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
    if ($query == true) { ?>
    <div class="container">
        <div class="popup">
            <img src="./tick.png">
            <h1>Merci d'avoir donné votre avis</h1>
            <p>Votre retour concernant l'intervention <?php echo $inter; ?> a bien été pris en compte</p>
            <p><span id="timer"></span></p>
            <a href="https://www.officecenter.fr"><button type="button">OK</button></a>
        </div>
    </div>
    <?php } else { ?>
    <div class="container">
        <div class="popup open-popup">
            <img src="./no.png">
            <h1>Une erreur est survenue :</h1>
            <p><?php echo $errors; ?></p>
            <p><span id="timer"></span></p>
            <a href="https://www.officecenter.fr"><button type="button">OK</button></a>
        </div>
    </div>
    <?php }
    ?>
    
    <script type="text/javascript">
        let count = 10;
        let redirect = "https://www.officecenter.fr/";
        function countdown() {
            let timer = document.getElementById("timer");
            if (count > 0) {
                count--;
                timer.innerHTML = "Cette page sera redirigée dans "+count+" secondes.";
                setTimeout("countdown()", 1000);
            } else {
                window.location.href = redirect;
            }
        }
        //countdown();
    </script>-->
</body>
</html>
