<?php
session_start();

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
$interid = $results['inter'];
$techname = $results['tech'];
$interdt = $results['date'];
$choice = $results['choix'];

echo " Inter ID : " . $interid . "<br> Technicien : " . $techname . "<br> Date de l'inter : " . $interdt . "<br>Choix du client : " . $choice;


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
    
</body>
</html>
