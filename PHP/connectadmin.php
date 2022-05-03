<?php
session_save_path('../utilisateurs');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<style>
    h2 {
        font-size: 15px;
        text-align: center;
    }

    fieldset {
        border-style: none;
        text-align: center;
    }

    img {
        width: 25px;
        margin-bottom: -7px;
    }

    input {
        border-style: revert;
        height: 25px;
        margin: 5px;
    }

    .ir {
        height: 10px;
        margin-left: 30px;
        color: black;
    }

    .va {
        margin-left: 30px;
        width: 80px;
        height: 30px;
        border-style: none;
        cursor: pointer;
    }

    a {
        text-decoration: none;
        color: black;
        font-style: italic;
    }

    .va:hover {
        background-color: lightblue;
    }

    .droite {
        text-align: right;
        display: flex;
    }

    .button {
        text-align: left;
        padding: 0% 0% 0% 34%;
    }

    caption {
        font-weight: bold;
        font-size: larger;
        margin: 5px;
    }

    table {
        margin: auto;
        border-style: none;
        border-color: white;
    }

    fieldset {
        width: fit-content;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <?php
    require_once "../bdd.php";

    if (isset($_POST["ok"])) {
        $r = mysqli_query($cn, "select * from administrateur where uid='" . $_POST["uid"] . "' and psw='" . $_POST["psw"] . "' ");
        if (mysqli_num_rows($r) == 1) {
            $d = mysqli_fetch_assoc($r);
            $_SESSION["uid"] = $d["uid"];
            $_SESSION["psw"] = $d["psw"];
            header("location:Index.php");
        } else {
            $r = mysqli_query($cn, "select * from administrateur where uid='" . $_POST["uid"] . "' and psw='" . $_POST["psw"] . "' ");
            if (mysqli_num_rows($r) == 1) {
                $d = mysqli_fetch_assoc($r);
            } else {
                echo "Mot de passe invalide";
            }
        }
    }


    ?>
    <fieldset>
        <h2>Administrateur - Connexion au site e-Commerce</h2>
        <form method=post>
                <label><img src="../images/identifiant.png" alt="" /> </label><input type="text" name=uid placeholder="*Entrez votre pseudo" value="" /><br>
                <label><img src="../images/mdp.png" alt="" /> </label><input type="password" placeholder="*Entrez votre mot de passe" name=psw value="" /><br>
                <br><input class="va" type=submit name=ok value=Valider /> <input class="va" type=submit name=cancel value=Retour />
        </form>
        </fieldset>
</body>

</html>