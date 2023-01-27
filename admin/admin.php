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
if (isset($_SESSION["login"]) && isset($_SESSION['password'])) {
    $id = $_SESSION["login"];
    $pwd = $_SESSION['password'];
}

if (isset($_POST['id']) && isset($_POST['pwd'])) {
    $id = str_replace(' ', '', htmlspecialchars($_POST['id']));
    $pwd = str_replace(' ', '', htmlspecialchars($_POST['pwd']));
}

// En cas d'erreur dans l'identification
if ($id !== 'admin' && $pwd !== 'Pa$$w0rdoc') {
    $_SESSION["error"] = "Identifiant et mot de passe incorect";
    header('location: index.php');
    $_SESSION['connected'] = false;
} elseif ($id !== 'admin') {
    $_SESSION["error"] = "Identifiant incorect";
    header('location: index.php');
    $_SESSION['connected'] = false;
} elseif ($pwd !== 'Pa$$w0rdoc') {
    $_SESSION["error"] = "Mot de passe incorect";
    header('location: index.php');
    $_SESSION['connected'] = false;
}

$_SESSION["login"] = $id;
$_SESSION['password'] = $pwd;


$sql = "SELECT * FROM `client_satisfaction` WHERE 1 ORDER BY `client_satisfaction`.`inter` DESC";
$stmt = $db->prepare($sql);
$stmt->execute();

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
        <button class="export"><ion-icon name="download-outline"></ion-icon>Exporter</button>
        <a href="./logout.php"><button class="logout"><ion-icon name="log-out-outline"></ion-icon>Se déconnecter</button></a>
    </header>
    <div class="content">
        <div class="head">
            <h1>Liste des questionnaires</h1>
            <div class="select-part">
                <label>Trier par technicien :</label>
                <div class="select">
                    <select name="format" id="format">
                        <option value="10">Charles</option>
                        <option value="20">Goutorbe</option>
                        <option value="50">Lingua</option>
                        <option value="100">Primiterra</option>
                        <option value="200">RaspailJ</option>
                        <option value="200">Tassel</option>
                    </select>
                </div>
            </div>
        </div>
        <section class="list">
        <table>
            <thead>
                <th>Intervention</th>
                <th>Technicien</th>
                <th>Adresse mail</th>
                <th>Note du client</th>
                <th>Date du formulaire</th>
            </thead>
            <tbody>
            <?php
            while ($query = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $query['inter'] . "</td>";
                echo "<td>"  . $query['tech'] . "</td>";
                echo "<td>" . $query['email'] . "</td>";
                echo "<td>" . $query['choice'] . "</td>";
                echo "<td>" . $query['survey_date'] . "</td>";
                echo "</tr>";
            }?>
            </tbody>
        </table>
        </section>
        <footer>
            <div class="changePage">
                <button type="submit" class="previous"><ion-icon class="previous-page" name="chevron-back-circle-outline"></ion-icon></button>
                <span class="space"></span>
                <button type="submit" class="next"><ion-icon class="next-page" name="chevron-forward-circle-outline"></ion-icon></button>
            </div>
            <div class="queryInPage">
                <label>Afficher</label>
                <div class="select">
                    <form action="" method="post" id="form">
                        <select name="format" id="format" onchange="document.getElementById('form').submit()";>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        </select>
                    </form>
                </div>
                <label>formulaires</label>
            </div>
        </footer>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>