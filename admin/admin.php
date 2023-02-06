<?php
//Affichage du détail des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();
$output = "";

// Déclaration des identifiants de connexion attendus
$identifiant = 'adminoc';
$password = 'Pa$$w0rdoc';

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
if (isset($_POST['id']) && isset($_POST['pwd'])) {
    $id = str_replace(' ', '', htmlspecialchars($_POST['id']));
    $pwd = str_replace(' ', '', htmlspecialchars($_POST['pwd']));
}

// Si déjà connecté, n'as pas besoin de se reconnecter
if (isset($_SESSION["login"]) && isset($_SESSION['password'])) {
    $id = $_SESSION["login"];
    $pwd = $_SESSION['password'];
}

// En cas d'erreur dans l'identification
if ($id !== $identifiant && $pwd !== $password) {
    $_SESSION["error"] = "Identifiant et mot de passe incorect";
    header('location: index.php');
    $_SESSION['connected'] = false;
} elseif ($id !== $identifiant) {
    $_SESSION["error"] = "Identifiant incorect";
    header('location: index.php');
    $_SESSION['connected'] = false;
} elseif ($pwd !== $password) {
    $_SESSION["error"] = "Mot de passe incorect";
    header('location: index.php');
    $_SESSION['connected'] = false;
}

$_SESSION["login"] = $id;
$_SESSION['password'] = $pwd;

// Requête si tri par technicien
if (isset($_POST['techForm'])) {
    $tech = $_POST['techForm'];
    $_SESSION['tech'] = $tech;
    if ($tech == 0) {
        $sql = "SELECT * FROM `client_satisfaction` ORDER BY `client_satisfaction`.`inter` DESC";
        $stmt = $db->prepare($sql);
    } else {
        $sql = "SELECT * FROM `client_satisfaction` WHERE tech = :tech ORDER BY `client_satisfaction`.`inter` DESC";
        $stmt = $db->prepare($sql);
        $stmt->bindParam('tech', $tech);
    }
} else {
    $sql = "SELECT * FROM `client_satisfaction` ORDER BY `client_satisfaction`.`inter` DESC";
    $stmt = $db->prepare($sql);
}
if (isset($_SESSION['tech'])) {
    $tech = $_SESSION['tech'];
    if ($tech == 0) {
        $sql = "SELECT * FROM `client_satisfaction` ORDER BY `client_satisfaction`.`inter` DESC";
        $stmt = $db->prepare($sql);
    } else {
        $sql = "SELECT * FROM `client_satisfaction` WHERE tech = :tech ORDER BY `client_satisfaction`.`inter` DESC";
        $stmt = $db->prepare($sql);
        $stmt->bindParam('tech', $tech);
    }
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
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satisfaction Survey - View</title>
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
        <a href="./logout.php"><button class="logout" onClick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');"><ion-icon name="log-out-outline"></ion-icon>Se déconnecter</button></a>
    </header>
    <div class="content">
        <div class="head">
            <h1>Liste des avis client</h1>
            <div class="moyenne">
                <?php
                $totalNote = 0;
                $i = 0;
                if (isset($_SESSION['tech'])) {
                    $techName = ucfirst(strtolower($_SESSION['tech']));
                    if ($tech == 0) {
                        $query = "SELECT DISTINCT `choice` FROM `client_satisfaction`";
                        $moyenne = $db->prepare($query);
                        $moyenne->execute();
                        while ($query = $moyenne->fetch()) {
                            $i++;
                            $totalNote += $query['choice'];
                        }
                        echo ' <p>Moyenne du service info : ' . round($totalNote / $i, 2) . '</p>';
                    } else {
                        $query = "SELECT DISTINCT `choice` FROM `client_satisfaction` WHERE tech = :tech";
                        $moyenne = $db->prepare($query);
                        $moyenne->bindParam('tech', $techName);
                        $moyenne->execute();
                        while ($query = $moyenne->fetch()) {
                            $i++;
                            $totalNote += $query['choice'];
                        }
                        echo ' <p>Moyenne de ' . $techName . ' : ' . round($totalNote / $i, 2) . '</p>';
                    }
                } else {
                    $query = "SELECT DISTINCT `choice` FROM `client_satisfaction`";
                    $moyenne = $db->prepare($query);
                    $moyenne->execute();
                    while ($query = $moyenne->fetch()) {
                        $i++;
                        $totalNote += $query['choice'];
                    }
                    echo ' <p>Moyenne du service info : ' . round($totalNote / $i, 2) . '</p>';
                }
                ?>
            </div>
            <div class="select-part">
                <label>Trier par technicien :</label>
                <div class="select">
                    <form action="" method="post" id="techForm">
                        <select name="techForm" id="techForm" onchange="document.getElementById('techForm').submit()" ;>
                            <option value=""></option>
                            <?php
                            $query = "SELECT DISTINCT `tech` FROM `client_satisfaction` GROUP BY `tech`";
                            $techs = $db->prepare($query);
                            $techs->execute();
                            while ($tech = $techs->fetch()) {
                                echo '<option value="' . strtolower($tech['tech']) . '">' . ucfirst(strtolower($tech['tech'])) . "</option>";
                            }
                            ?>
                            <option value="0">TOUS</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <section class="list">
            <table>
                <thead>
                    <th>Inter</th>
                    <th>Technicien</th>
                    <th class="th-email">Email</th>
                    <th class="th-note">Note</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    <?php
                    if (!isset($_SESSION['loop'])) {
                        if (isset($_POST['format'])) {
                            $loop = $_POST['format'];
                            $_SESSION['loop'] = $loop;
                        } else {
                            $loop = 15;
                        }
                    }
                    if (isset($_SESSION['loop'])) {
                        if (isset($_POST['format'])) {
                            $loop = $_POST['format'];
                            $_SESSION['loop'] = $loop;
                        } else {
                            $loop = $_SESSION['loop'];
                        }
                    }
                    $i = 0;
                    while ($query = $stmt->fetch()) {
                        $i++;
                        echo "<tr>";
                        echo "<td>" . $query['inter'] . "</td>";
                        echo "<td>"  . ucfirst(strtolower($query['tech'])) . "</td>";
                        echo "<td>" . $query['email'] . "</td>";
                        echo "<td>" . $query['choice'] . "</td>";
                        echo "<td>" . $query['inter_date'] . "</td>";
                        echo "</tr>";
                        if ($loop !== "0") {
                            if ($i == $loop) {
                                break;
                            }
                        }
                    } ?>
                </tbody>
            </table>
        </section>
        <footer>
            <div class="queryInPage">
                <label>Afficher</label>
                <div class="select">
                    <form action="" method="post" id="form">
                        <select name="format" id="format" onchange="document.getElementById('form').submit()" ;>
                            <option value=""></option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="0">★</option>
                        </select>
                    </form>
                </div>
                <label>formulaires</label>
            </div>
        </footer>
    </div>
    <div class="go-to-top">
        <button onClick="topFunction()" id="myBtn" title="Go to top">Aller en haut</button>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        let mybutton = document.getElementById("myBtn");
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 750 || document.documentElement.scrollTop > 750) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>

</html>