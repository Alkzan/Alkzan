<?php
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
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/connect.css">
    <script src="https://kit.fontawesome.com/21149d0622.js" crossorigin="anonymous"></script>
    <script src="../index.js" defer></script>
    <title>Document</title>
</head>
<body class="shop">
<?php include 'header.php'; ?>

    <?php

    if (isset($_REQUEST["id"]))
        $id = $_REQUEST["id"];

    else
        $id = 0;

        // Si le bouton retour est cliquer
    if (isset($_REQUEST["cancel"])) {
        header("location:connect.php");
    }

    // Modifier des données de la BDD

    if (isset($_REQUEST["ok"])) {

        // Protection contre les caractères spéciaux
        // $id = mysqli_real_escape_string($cn,$_REQUEST["id"]);
        $uid = mysqli_real_escape_string($cn, $_REQUEST["uid"]);
        $nom = mysqli_real_escape_string($cn, $_REQUEST["nom"]);
        $prenom = mysqli_real_escape_string($cn, $_REQUEST["prenom"]);
        $naissance = mysqli_real_escape_string($cn, $_REQUEST["naissance"]);
        $email = mysqli_real_escape_string($cn, $_REQUEST["email"]);
        $telephone = mysqli_real_escape_string($cn, $_REQUEST["telephone"]);
        $psw = mysqli_real_escape_string($cn, $_REQUEST["psw"]);
        $civilite = mysqli_real_escape_string($cn, $_REQUEST["civilite"]);

        // Si des informations sont pas entrer dans la saisie
        if ((strlen($uid) == 0) || (strlen($nom) == 0) || (strlen($naissance) == 0) || (strlen($telephone) == 0) || (strlen($prenom) == 0) || (strlen($email) == 0) || (strlen($psw) == 0) || (strlen($civilite) == 0))
            echo "<h2>Il manque des informations obligatioires";
        else {
            if ($id == 0) {
                // Insertion des informations dans la BDD
                $r = mysqli_query($cn, "insert into ". TUTIT ." (". TUTITUID .",". TUTITNOM .",". TUTITPRENOM .",". TUTITNAISSANCE .",". TUTITEMAIL .",". TUTITTEL .",". TUTITPSW .",". TUTITCIVILITE .") values ('$uid','$nom','$prenom','$email','$naissance','$telephone','$psw','$civilite');");
                $id = mysqli_insert_id($cn);
                header("location:connect.php");
                exit;
            }
        }
    }

    // Lecture des données de la BDD
    if ($id > 0) {
        // Selection des informations dans la BDD
        $r = mysqli_query($cn, "select ". TUTITUID .",". TUTITNOM .",". TUTITPRENOM .",". TUTITNAISSANCE .",". TUTITEMAIL .",". TUTITTEL .",". TUTITPSW .",". TUTITCIVILITE ." from ". TUTIT ." where ". TUTITID ."=$id");
        if (mysqli_num_rows($r) == 0) {
            echo "<h2>Identifiant Inconnu";
            exit;
        } else {
            $d = mysqli_fetch_assoc($r);
            $uid = $d[TUTITUID];
            $nom = $d[TUTITNOM];
            $prenom = $d[TUTITPRENOM];
            $naissance = $d[TUTITNAISSANCE];
            $email = $d[TUTITEMAIL];
            $telephone = $d[TUTITTEL];
            $psw = $d[TUTITTEL];
            $civilite = $d[TUTITCIVILITE];
        }
    } else {
        $id = 0;
        $uid = "";
        $nom = "";
        $prenom = "";
        $naissance = "";
        $email = "";
        $telephone = "";
        $psw = "";
        $civilite = "";
    }

    $genre = array("Homme", "Femme");

    ?>

    <fieldset>
        <h2>Inscription au site e-Commerce</h2>
        <form method="post">
            <label><img src="../images/identifiant.png" alt="" /> </label><input type="text" name=uid placeholder="*Entrez votre uid" value="<?php echo $uid; ?>" /><br>
            <label><img src="../images/identifiant.png" alt="" /> </label><input type="text" name=nom placeholder="*Entrez votre Nom" value="<?php echo $nom; ?>" /><br>
            <label><img src="../images/prenom.jpg" alt="" /> </label><input type="text" name=prenom placeholder="*Entrez votre Prénom" value="<?php echo $prenom; ?>" /><br>
            <label><img src="../images/prenom.jpg" alt="" /> </label><input type="text" name=naissance placeholder="*Entrez votre naissance" value="<?php echo $naissance; ?>" /><br>
            <label><img src="../images/email.png" alt="" /> </label><input type="text" name=email placeholder="*Entrez votre Email" value="<?php echo $email; ?>" /><br>
            <label><img src="../images/tel.png" alt="" /> </label><input type="text" name=telephone placeholder="Entrez votre numéro de téléphone" value="<?php echo $telephone; ?>" /><br>
            <label><img src="../images/mdp.png" alt="" /> </label><input type="password" placeholder="*Entrez votre mot de passe" name=psw value="<?php echo $psw; ?>" /><br>
            <?php
            // Sexe de la personne
            for ($j = 0; $j < count($genre); $j++) {
                if ($civilite == $genre[$j]) {
                    $s = "checked";
                } else {
                    $s = "";
                }
                echo "<input class=ir type=radio name=civilite value=" . $genre[$j] . " $s /> " . $genre[$j] . " ";
            }

            ?>
            <br><input class="va" type=submit name=cancel value=Retour /> <input class="va" type=submit name=ok value=Inscription />
        </form>
    </fieldset>
</body>

</html>