<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Gestion de mofication d'article
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
    <link rel="stylesheet" href="../css/inscription.css">
    <link rel="stylesheet" href="../css/paiement2.css">
    <title>Document</title>
</head>

<body>
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

    if (isset($_REQUEST["commands"])) {

        // Protection des caractères spéciaux
        // $id = mysqli_real_escape_string($cn,$_REQUEST["id"]);
        $nom = mysqli_real_escape_string($cn, $_REQUEST["nom"]);
        $prenom = mysqli_real_escape_string($cn, $_REQUEST["prenom"]);
        $genre = mysqli_real_escape_string($cn, $_REQUEST["genre"]);
        $email = mysqli_real_escape_string($cn, $_REQUEST["email"]);
        $tel = mysqli_real_escape_string($cn, $_REQUEST["tel"]);
        $adressefac = mysqli_real_escape_string($cn, $_REQUEST["adressefac"]);
        $postalfac = mysqli_real_escape_string($cn, $_REQUEST["postalfac"]);
        $villefac = mysqli_real_escape_string($cn, $_REQUEST["villefac"]);
        $adresseliv = mysqli_real_escape_string($cn, $_REQUEST["adresseliv"]);
        $postalliv = mysqli_real_escape_string($cn, $_REQUEST["postalliv"]);
        $villeliv = mysqli_real_escape_string($cn, $_REQUEST["villeliv"]);

        // Si des informations ne sont pas saisie
        if ((strlen($nom) == 0) || (strlen($adressefac) == 0) || (strlen($tel) == 0) || (strlen($prenom) == 0) || (strlen($email) == 0) || (strlen($villefac) == 0) || (strlen($email) == 0))
            echo "<h2>Il manque des informations obligatioires";
        else {
            if ($id == 0) {
                // Insertion des informations dans la base Facture

            $valdate = Date("Y/m/j G:i");
    
            $r3 = mysqli_query($cn, "select *,". TPANQTE ."*". TARTPRIX .", ". TPAN .".". TPANID ." from ". TPAN .",". TART ." where ". TPANREFA ." = ".TART .".". TARTID ." and ". TPANIDS ." = '$idsession'");

            while ($d3 = mysqli_fetch_assoc($r3)) {
                
                $idfacture = mysqli_insert_id($cn);
                $client = $d3[TARTREFC];
                $artic = $d3[TPANREFA];
                $qte = $d3[TPANQTE];
                $prix = $d3[TARTPRIX];
                $phot = $d2[TARTIMG];
                echo "insert into ". TDETAILF ." (". TDETAILFIMAGESA .",". TDETAILFREFA .",". TDETAILFREFF .",". TDETAILFPRIXV .",". TDETAILFQTE .") values ('$phot','$artic','$idfacture','$prix','$qte')";
                
                echo "insert into ". TFAC ." (". TFACREFC .",". TFACQTE .",". TFACREFA .",". TFACPRIX .",". TFACNOM .",". TFACPRENOM .",". TFACGENRE .",". TFACADRESSEF .",". TFACPOSTALF .",". TFACVILLEF .",". TFACEMAIL .",". TFACTEL .",". TFACVILLELIV .",". TFACADRESSELIV .",". TFACPOSTALLIV .",". TFACDATEF .") values ('$client','$qte','$artic','$prix','$nom','$prenom','$genre','$adressefac','$postalfac','$villefac','$email','$tel','$adresseliv','$postalfac','$villefac','$valdate');";
            
                $r = mysqli_query($cn, "insert into ". TFAC ." (". TFACREFC .",". TFACQTE .",". TFACREFA .",". TFACPRIX .",". TFACNOM .",". TFACPRENOM .",". TFACGENRE .",". TFACADRESSEF .",". TFACPOSTALF .",". TFACVILLEF .",". TFACEMAIL .",". TFACTEL .",". TFACVILLELIV .",". TFACADRESSELIV .",". TFACPOSTALLIV .",". TFACDATEF .") values ('$client','$qte','$artic','$prix','$nom','$prenom','$genre','$adressefac','$postalfac','$villefac','$email','$tel','$adresseliv','$postalfac','$villefac','$valdate');");
            }

            // Recupération de l'id facture crée

            $idfacture = mysqli_insert_id($cn);
            echo "<br>idfacture = $idfacture<br>" ; 

            // Selection des informations dans la BDD Article et Panier
            echo "select *,". TPANQTE ."*". TARTPRIX .", ". TPAN .".". TPANID ." from ". TPAN .",". TART ." where ". TPANREFA ." = ".TART .".". TARTID ." and ". TPANIDS ." = '$idsession'";
                
            $r2 = mysqli_query($cn, "select *,". TPANQTE ."*". TARTPRIX .", ". TPAN .".". TPANID ." from ". TPAN .",". TART ." where ". TPANREFA ." = ".TART .".". TARTID ." and ". TPANIDS ." = '$idsession'");

            while ($d2 = mysqli_fetch_assoc($r2)) {
                
                $prix = $d2[TARTPRIX];
                $qte = $d2[TPANQTE];
                $artic = $d2[TPANREFA];
                $phot = $d2[TARTIMG];
                echo "insert into ". TDETAILF ." (". TDETAILFIMAGESA .",". TDETAILFREFA .",". TDETAILFREFF .",". TDETAILFPRIXV .",". TDETAILFQTE .") values ('$phot','$artic','$idfacture','$prix','$qte')";
                
                mysqli_query($cn, "insert into ". TDETAILF ." (". TDETAILFIMAGESA .",". TDETAILFREFA .",". TDETAILFREFF .",". TDETAILFPRIXV .",". TDETAILFQTE .") values ('$phot','$artic','$idfacture','$prix','$qte')");
                
                mysqli_query($cn, "update ". TART ." set ". TARTSTOCK ." = ". TARTSTOCK ." - $qte where ". TARTID ." = $artic");
            }

            mysqli_query($cn, "delete from ". TPAN ." where ". TPANIDS ." = '$idsession'");            

            header("location:facture.php?idfacture=$idfacture");
            // exit;
            }
        }
    }

    // Lecture des données de la BDD
    if ($id > 0) {
        // Selection des informations dans la BDD Facture"
        $r = mysqli_query($cn, "select ". TFACNOM .",". TFACPRENOM .",". TFACGENRE .",". TFACADRESSEF .",". TFACPOSTALF .",". TFACVILLEF .",". TFACEMAIL .",". TFACTEL .",". TFACVILLELIV .",". TFACADRESSELIV .",". TFACPOSTALLIV ." from ". TFAC ." where ". TFACID ."=$id");
        if (mysqli_num_rows($r) == 0) {
            echo "<h2>Facture Inconnu";
            exit;
        } else {

            $d = mysqli_fetch_assoc($r);
            $nom = $d[TFACNOM];
            $prenom = $d[TFACNOM];
            $genre = $d[TFACGENRE];
            $email = $d[TFACEMAIL];
            $tel = $d[TFACTEL];
            $adressefac = $d[TFACADRESSEF];
            $postalfac = $d[TFACPOSTALF];
            $villefac = $d[TFACVILLEF];
            $adresseliv = $d[TFACADRESSELIV];
            $postalliv = $d[TFACPOSTALLIV];
            $villeliv = $d[TFACVILLELIV];
        }
    } else {
        $id = 0;
        $nom = "";
        $prenom = "";
        $genre = "";
        $email = "";
        $tel = "";
        $adressefac = "";
        $postalfac = "";
        $villefac = "";
        $adresseliv = "";
        $postalliv = "";
        $villeliv = "";
    }

    $civilite = array("Homme", "Femme");

    ?>

    <fieldset>
        <h2>En route vers le paiement du site e-commerce</h2>
        <form method="post">
            <label>Nom : </label><input type="text" name=nom placeholder="*Entrez votre Nom" value="<?php echo $nom; ?>" /><br>
            <label>Prenom : </label><input type="text" name=prenom placeholder="*Entrez votre Prénom" value="<?php echo $prenom; ?>" /><br>
            <label>Email : </label><input type="text" name=email placeholder="*Entrez votre Email" value="<?php echo $email; ?>" /><br>
            <label>Numéro de téléphone : </label><input type="text" name=tel placeholder="Entrez votre numéro de téléphone" value="<?php echo $tel; ?>" /><br>
            <label>Adresse de facturation : </label><input type="text" name=adressefac placeholder="Entrez votre adresse de facturation" value="<?php echo $adressefac; ?>" /><br>
            <label>Adresse postal de facturation : </label><input type="text" name=postalfac placeholder="Entrez votre adresse postal de facturation" value="<?php echo $postalfac; ?>" /><br>
            <label>Ville de facturation : </label><input type="text" name=villefac placeholder="Entrez votre adresse ville de facturation" value="<?php echo $villefac; ?>" /><br>
            <label>Adresse de Livraison : </label><input type="text" name=adresseliv placeholder="Entrez votre adresse de livraison" value="<?php echo $adresseliv; ?>" /><br>
            <label>Adresse postal de livraison : </label><input type="text" name=postalliv placeholder="Entrez votre adresse postal de livraison" value="<?php echo $postalliv; ?>" /><br>
            <label>Ville de livraison : </label><input type="text" name=villeliv placeholder="Entrez votre ville de livraison" value="<?php echo $villefac; ?>" /><br>
            <?php
            // Sexe de la personne
            for ($j = 0; $j < count($civilite); $j++) {
                if ($genre == $civilite[$j]) {
                    $s = "checked";
                } else {
                    $s = "";
                }
                echo "<input class=ir type=radio name=genre value=" . $civilite[$j] . " $s /> " . $civilite[$j] . " ";
            }

            ?>
            <br><input class="va" type=submit name=back value='Continuer mes achats' /> <input class="va" type=submit name=commands value='Continuer vers le paiement' />
            <br><a target='iiframe' href='connect.php' name=connects >Connectez-vous</a>
        </form>
    </fieldset>
</body>

</html>