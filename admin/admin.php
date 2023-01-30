<?php
//Affichage du détail des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();
$output = "";

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

// Requête si tri par technicien
if (isset($_POST['techForm'])) {
    $tech = $_POST['techForm'];
    $sql = "SELECT * FROM `client_satisfaction` WHERE tech = :tech ORDER BY `client_satisfaction`.`inter` DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindParam('tech', $tech);
} else {
    $sql = "SELECT * FROM `client_satisfaction` WHERE 1 ORDER BY `client_satisfaction`.`inter` DESC";
    $stmt = $db->prepare($sql);
}
$stmt->execute();

// Export des données dans un tableau Excel
if (isset($_POST['export'])) {
    // Récupération de la date actuelle
    $getdt = new \DateTime();
    $dt = $getdt->format('d/m/Y');

    $query = "SELECT DISTINCT `inter`, `tech`, `choice`, `survey_date`, `inter_date`, `email` FROM `client_satisfaction` ORDER BY `inter` DESC";
    $export = $db->prepare($query);
    $export->execute();

    $output .= '<table class="table"><tr><th>Intervention</th><th>Technicien</th><th>Note</th><th>Date</th><th>Email</th>';
    if (!empty($export)) {
        foreach ($export as $row) {
            $output .= "\t" . '<tr><td>' . $row["inter"] . '</td>' . "\n" . '<td>' . $row["tech"] . '</td>' . "\n" . '<td>' . $row["choice"] . '</td>' . "\n" . '<td>' . $row["survey_date"] . '</td>' . "\n" . '<td>' . $row["email"] . '</td></tr>';
        }
    }
    $output .= '</table>';
    $filename = "export_questionnaire_satisfaction_" . $dt . ".xls";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo $output;
    exit();
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
        <form action="" method="post">
            <button class="export" type="submit" name="export"><ion-icon name="download-outline"></ion-icon>Exporter</button>
        </form>
        <a href="./logout.php"><button class="logout"><ion-icon name="log-out-outline"></ion-icon>Se déconnecter</button></a>
    </header>
    <div class="content">
        <div class="head">
            <h1>Liste des questionnaires</h1>
            <div class="select-part">
                <label>Trier par technicien :</label>
                <div class="select">
                    <form action="" method="post" id="techForm">
                        <select name="techForm" id="techForm" onchange="document.getElementById('techForm').submit()";>
                            <option value=""></option>
                            <option value="charles">Charles</option>
                            <option value="goutorbe">Goutorbe</option>
                            <option value="lingua">Lingua</option>
                            <option value="primiterra">Primiterra</option>
                            <option value="raspailj">Raspail</option>
                            <option value="tassel">Tassel</option>
                        </select>
                    </form>
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
            $i = 0;
            if (isset($_POST['format'])) {
                $loop = $_POST['format'];
            } else {
                $loop = 15;
            }
            
            while ($query = $stmt->fetch()) {
                $i++;
                echo "<tr>";
                echo "<td>" . $query['inter'] . "</td>";
                echo "<td>"  . ucfirst($query['tech']) . "</td>";
                echo "<td>" . $query['email'] . "</td>";
                echo "<td>" . $query['choice'] . "</td>";
                echo "<td>" . $query['inter_date'] . "</td>";
                echo "</tr>";
                if ($i == $loop) {
                    break;
                }
            }?>
            </tbody>
        </table>
        </section>
        <footer>
            <div class="queryInPage">
                <label>Afficher</label>
                <div class="select">
                    <form action="" method="post" id="form">
                        <select name="format" id="format" onchange="document.getElementById('form').submit()";>
                            <option value=""></option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
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