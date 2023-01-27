<?php
//Affichage du détail des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();

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

$sql = "SELECT * FROM `client_satisfaction` WHERE 1";
$stmt = $db->prepare($sql);
$stmt->execute();

while ($query = $stmt->fetch() && $i <) {
    echo $query['inter'] . " ; ";
    echo $query['tech'] . " ; ";
    echo $query['email'] . " ; ";
    echo $query['choice'] . " ; ";
    echo $query['survey_date'] . " ; <br>";
}