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

// Récupération des informations de connexion
$id = htmlspecialchars($_POST['id']);
$pwd = htmlspecialchars($_POST['pwd']);

//Vérifiation de la connexion
if ($id == 'admin' && $pwd == 'Pa$$w0rdoc') {
} else {
    $_SESSION["error"] = "Identifiant ou mot de passe incorect !";
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <button class="export">Exporter les données</button>
        <button class="logout"><ion-icon name="log-out-outline"></ion-icon>Se déconnecter</button>
    </header>
    <div class="content">
        <h1>Liste des questionnaires</h1>
        <section class="list">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </section>
        <footer>
            <div class="changePage">
                <button type="submit" class="previous">Précédent</button><span class="space"></span>
                <button type="submit" class="next">Suivante</button>
            </div>
            <div class="queryInPage">
                <label>Combien afficher par page?</label>
                <select name="nbInPage">
                    <option value="10">10 formulaires par page</option>
                    <option value="20">20 formulaires par page</option>
                    <option value="50">50 formulaires par page</option>
                    <option value="100">100 formulaires par page</option>
                    <option value="200">200 formulaires par page</option>
                    <option value="0">Tout afficher</option>
                </select>
            </div>
        </footer>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>