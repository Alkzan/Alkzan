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

// Location de connexion si on est pas déjà connecter
if (isset($_SESSION["id"]) == false) {
    header("location:connect.php");
}
$idsession = session_id();

// Connexion à la BDD via la function du Mesvaleurs.php
$cn = ConnecterBDD();
?>
<style>
    body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: baseline;
    }

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

    .pho {
        width: 50px;
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
        width: 70px;
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
</style>
<?php

if (isset($_REQUEST["id"]))
    $id = $_REQUEST["id"];

else
    $id = 0;

// Bouton retour est cliquer
if (isset($_REQUEST["cancel"])) {
    header("location:adminmarque.php");
}

// Modifier des données de la BDD

if (isset($_REQUEST["ok"])) {

    // Protection contre les caractères spéciaux
    $libellemarque = mysqli_real_escape_string($cn, $_REQUEST["libellemarque"]);

    $message = "";
    $valide = true;

    if ($libellemarque == "") {
        $message .= "<br>Le Titre n'est pas valide";
        $valide = false;
    }
        if ($id == 0) {

            // Insert les informations des marques dans la BDD

            $r = mysqli_query($cn, "insert into ". TMARQUE ." (". TMARQUELIBELLEM .") values ('$libellemarque');");
            $id = mysqli_insert_id($cn);

            echo "<br><br><h2>Informations prises en compte<br><br><a href=adminmarque.php>Cliquer ici pour être redirigé</a>";
        } else {
            
            // Modification des informations des marques dans la BDD

            $r = mysqli_query($cn, "update ". TMARQUE ." set ". TMARQUELIBELLEM ."='$libellemarque' where ". TMARQUEID ."='$id'");
            echo "<br><h2>Informations prises en compte<br><br><a href=adminmarque.php>Cliquer ici pour être redirigé</a><br>";
        }

        // Traitement en cas d'upload d'marquelogo
        if ($_FILES[TMARQUELOGO]["error"] == 0) {

            $det = explode(".", $_FILES[TMARQUELOGO]["name"]);

            // Selection des informations des images dans la BDD
            $r = mysqli_query($cn, "select ". TMARQUELOGO ." from ". TMARQUE ." where ". TMARQUEID ."='$id'");
            $d = mysqli_fetch_assoc($r);
            if (strlen($d[TMARQUELOGO]) > 0)
                unlink("../marquephoto/" . $d[TMARQUELOGO]);

            // $ext = strtoupper($det[count($det)-1]); // Majuscule
            $ext = strtolower($det[count($det) - 1]); // Minuscule


            if ($ext!="jpg" && $ext!="png" && $ext!="jpeg" && $ext!="bmp") {
                $valide = false; 
                $message .= "<br>Le format de l'image est non conforme"; 
            }
                $filename = "$id.$ext";
                copy($_FILES[TMARQUELOGO]["tmp_name"], "../marquephoto/" . $filename);

                // Modification des informations des images des marques dans la BDD
                $r = mysqli_query($cn, "update ". TMARQUE ." set ". TMARQUELOGO ."='$filename' where ". TMARQUE .".". TMARQUEID ."='$id'");
                exit;
            } else
                echo "<br><h3 class='fok'>Fichier invalide</h3>";
        }
    

        // Lecture de la BDD des marques
 if ($id > 0) {
    $r = mysqli_query($cn, "select ". TMARQUELIBELLEM .",". TMARQUELOGO ." from ". TMARQUE ." where ". TMARQUEID ."=$id");
    if (mysqli_num_rows($r) == 0) {
        echo "<h2>Identifiant Inconnu";
        exit;
    } else {

        $d = mysqli_fetch_assoc($r);
        $libellemarque = $d[TMARQUELIBELLEM];
        $logo = $d[TMARQUELOGO];
    }
} else {
    $id = 0;
    $libellemarque = "";
    $logo = "";
}


?>

<body>
    <fieldset>
        <form method="post" enctype="multipart/form-data">
            <label><img src="../images/identifiant.png" alt="" /> </label><input type="text" name=libellemarque placeholder="*Entrez votre libellemarque" value="<?php echo $libellemarque; ?>" /><br>
            <br><label></label><input type=file name=<?php echo TMARQUELOGO;?>><br>
            <label></label><img class="pho" src="<?php echo "../marquephoto/$logo"; ?>" alt="">
            <br><input class="va" type=submit name=ok value=Valider /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>