<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Système de connexion au site
    //////////////////////////////////

include_once "../mesvaleurs.php";
session_save_path(REPSESSION);
session_start();

$idsession = session_id();

// Connexion à la BDD via la function du Mesvaleurs.php
$cn = ConnecterBDD();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/connect.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <script src="https://kit.fontawesome.com/21149d0622.js" crossorigin="anonymous"></script>
    <script src="../index.js" defer></script>
    <title>Document</title>

</head>

<body class="shop">
    <?php include 'header.php'; ?>

    <?php

        // Si le bouton retour est cliquer
        if (isset($_REQUEST["cancel"])) {
            header("location:index.php");
        }

        if (isset($_POST["ok"])) {
            // Selection des informations dans la BDD
            $r = mysqli_query($cn, "select * from ". TUTIT ." where ". TUTITUID ."='" . $_POST["uid"] . "' and ". TUTITPSW ."='" . $_POST["psw"] . "' ");
            if (mysqli_num_rows($r) == 1) {
                $d = mysqli_fetch_assoc($r);
                $_SESSION["id"] = $d[TUTITID];
                $_SESSION["uid"] = $d[TUTITUID];
                $_SESSION["psw"] = $d[TUTITPSW];
                $_SESSION["grade"] = $d[TUTITGRADE];
                $_SESSION["acces"] = $d[TUTITACCES];
                $_SESSION["connexion"] = $d[TUTITCONNEXION];
                $connexion = date("Y-m-d G:i:s");
                // Modification des informations dans la BDD
                mysqli_query($cn, "update ". TUTIT ." set ". TUTITACCES ." = ". TUTITACCES ."+1 ,". TUTITCONNEXION ." = '$connexion' where ". TUTITUID ." = '" . $_POST["uid"] . "' and ". TUTITPSW ."='" . $_POST["psw"] . "'");
                header("location:Index.php");
            } else {
                // Selection des informations dans la BDD
                $r = mysqli_query($cn, "select * from ". TUTIT ." where ". TUTITUID ." = '" . $_POST["uid"] . "' and ". TUTITPSW ." = '" . $_POST["psw"] . "' ");
                if (mysqli_num_rows($r) == 1) {
                    $d = mysqli_fetch_assoc($r);
                } else {
                    echo "Mot de passe invalide";
                }
            }
        }


    ?>
    <fieldset>
        <h2>Connexion au site e-Commerce</h2>
        <form method=post>
                <label><img src="../images/identifiant.png" alt="" /> </label><input type="text" name=uid placeholder="*Entrez votre pseudo" value="" /><br>
                <label><img src="../images/mdp.png" alt="" /> </label><input type="password" placeholder="*Entrez votre mot de passe" name=psw value="" /><br>
                <br><input class="va" type=submit name=cancel value=Retour /> <input class="va" type=submit name=ok value=Valider />
                <br><a href='inscription.php'>Vous êtes nouveau ?</a>
        </form>
    </fieldset>
</body>

</html>