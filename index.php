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
define('USER', "officecequalit");
define('PASSWD', "Bimbamboum22");
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
    $sql = "INSERT INTO client_satisfaction (inter, tech, choice, survey_date, inter_date) VALUES (:inter, :tech, :choice, :dt, :interdt)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam('inter', $inter);
    $stmt->bindParam('tech', $tech);
    $stmt->bindParam('choice', $choice);
    $stmt->bindParam('dt', $dt);
    $stmt->bindParam('interdt', $interdt);
    $stmt->execute();
    $query = true;
} else {
    $errors .= "L'intervention " . $inter . " possède déjà un questionnaire de rempli.";
    $query = false;
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satisfaction Survey V2</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php
    if ($query) { ?>
        <!-- code... -->
    <?php } else { ?>
        <!-- code... -->
    <?php }
    ?>
    
</body>
</html>
