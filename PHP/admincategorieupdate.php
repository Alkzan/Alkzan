<?php

    /////////////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    /////////////////////////////////////////
    // Gestion de modification des categories
    /////////////////////////////////////////

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

    // Si le bouton retour est cliquer
if (isset($_REQUEST["cancel"])) {
    header("location:admincategorie.php");
}

// Si le bouton OK est cliquer
if (isset($_REQUEST["ok"])) {

    $libelle = mysqli_real_escape_string($cn, $_REQUEST["libelle"]);

    $message = "";
    $valide = true;

    if ($libelle == "") {
        $message .= "<br>Le Titre n'est pas valide";
        $valide = false;
    }
        if ($id == 0) {
        // Ajout des données dand la BDD

            $r = mysqli_query($cn, "insert into ". TCAT ." (". TCATLIBELLE .") values ('$libelle');");
            $id = mysqli_insert_id($cn);

            echo "<br><br><h2>Informations prises en compte<br><br><a href=admincategorie.php>Cliquer ici pour être redirigé</a>";
        } else {
        // Modifier des données de la BDD

            $r = mysqli_query($cn, "update ". TCAT ." set ". TCATLIBELLE ."='$libelle' where ". TCATID ."='$id'");
            echo "<br><h2>Informations prises en compte<br><br><a href=admincategorie.php>Cliquer ici pour être redirigé</a><br>";
        }

        // Traitement en cas d'upload d'categoriephoto
        if ($_FILES[TCATPHOTO]["error"] == 0) {

            $det = explode(".", $_FILES[TCATPHOTO]["name"]);

            // Selection de l'image dans la BDD
            $r = mysqli_query($cn, "select ". TCATPHOTO ." from ". TCAT ." where ". TCATID ."='$id'");
            $d = mysqli_fetch_assoc($r);
            if (strlen($d[TCATPHOTO]) > 0)
                unlink("../categoriephoto/" . $d[TCATPHOTO]);

            // $ext = strtoupper($det[count($det)-1]); // Majuscule
            $ext = strtolower($det[count($det) - 1]); // Minuscule


            // Erreur d'image selon l'extension
            if ($ext!="jpg" && $ext!="png" && $ext!="jpeg" && $ext!="bmp") {
                $valide = false; 
                $message .= "<br>Le format de l'image est non conforme"; 
            }
                $filename = "$id.$ext";
                copy($_FILES["photo"]["tmp_name"], "../categoriephoto/" . $filename);

                // Modifications des informations d'images dans la BDD
                $r = mysqli_query($cn, "update ". TCAT ." set ". TCATPHOTO ."='$filename' where ". TCATID ."='$id'");
                exit;
            } else
                echo "<br><h3 class='fok'>Fichier invalide</h3>";
        }
    
// Selection des informations dans la BDD
 if ($id > 0) {
    $r = mysqli_query($cn, "select ". TCATLIBELLE .",". TCATPHOTO ." from ". TCAT ." where ". TCATID ."=$id");
    if (mysqli_num_rows($r) == 0) {
        echo "<h2>Identifiant Inconnu";
        exit;
    } else {

        $d = mysqli_fetch_assoc($r);
        $libelle = $d[TCATLIBELLE];
        $photo = $d[TCATPHOTO];
    }
} else {
    $id = 0;
    $libelle = "";
    $photo = "";
}


?>

<body>
    <fieldset>
        <form method="post" enctype="multipart/form-data">
            <label><img src="../images/identifiant.png" alt="" /> </label><input type="text" name=libelle placeholder="*Entrez votre libelle" value="<?php echo $libelle; ?>" /><br>
            <br><label></label><input type=file name=<?php echo TCATPHOTO; ?>><br>
            <label></label><img class="pho" src="<?php echo "../categoriephoto/$photo"; ?>" alt="">
            <br><input class="va" type=submit name=ok value=Valider /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>