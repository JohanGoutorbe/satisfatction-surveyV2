<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satisfaction Survey - Login Page - LOGIN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="box">
        <form class="form" method="post" action="admin.php">
            <h2>Se connecter</h2>
            <div class="inputBox">
                <input type="text" name="id" required>
                <span>Identifiant</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="pwd" required>
                <span>Mot de passe</span>
                <i></i>
            </div>
            <div class="links">
                <a href="#">Mot de passe oublié</a>
            </div>
            <input type="submit" value="Login">
            <p>
                <?php
                session_start();
                if (isset($_SESSION["error"])) {
                    echo $_SESSION["error"];
                }
                session_destroy() ?>
            </p>
        </form>
    </div>
</body>

</html>