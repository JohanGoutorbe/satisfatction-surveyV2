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
                <a href="https://www.officecenter.fr"><button type="button">OK</button></a>
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
                <a href="https://www.officecenter.fr"><button type="button">OK</button></a>
            </div>
        <?php } ?>

        <script type="text/javascript">
            let count = 5;
            let redirect = "https://www.officecenter.fr/qualite/ajouter_un_commentaire";

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
            //countdown();
        </script>-->
</body>

</html>