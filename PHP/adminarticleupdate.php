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

// Connexion et affichage des categorie à la BDD pour le filtrage

$r = mysqli_query ($cn,"select * from ". TMARQUE ." order by ". TMARQUELIBELLEM ."");
$mar = array();
while ($w = mysqli_fetch_assoc($r)) {
    $mar[] = $w;
}

// Connexion et affichage des articles à la BDD

$r = mysqli_query ($cn,"select * from ". TCAT ." order by ". TCATLIBELLE ." ");
$cat = array();
while ($d = mysqli_fetch_assoc($r)) {
    $cat[] = $d;
}



if (isset($_REQUEST["id"]))
    $id = $_REQUEST["id"];

else
    $id = 0;

if (isset($_REQUEST["cancel"])) {
    header("location:adminarticle.php");
}

// Modifier des données de la BDD

if (isset($_REQUEST["ok"])) {

    // Protection contre les caractères spéciaux

    $titre = mysqli_real_escape_string($cn, $_REQUEST["titre"]);
    $description = mysqli_real_escape_string($cn, $_REQUEST["description"]);
    $prix = mysqli_real_escape_string($cn, $_REQUEST["prix"]);
    $refmarque = mysqli_real_escape_string($cn, $_REQUEST["refmarque"]);
    $refcategorie = mysqli_real_escape_string($cn, $_REQUEST["refcategorie"]);
    $refpromotion = mysqli_real_escape_string($cn, $_REQUEST["refpromotion"]);
    $stock = mysqli_real_escape_string($cn, $_REQUEST["stock"]);

    // Création de l'article dans la BDD 

    if ($id == 0) {
        // echo "insert into article (titre,pretitre,email,telephone,formation,sexe) values ('$titre','$pretitre','$email','$telephone','$formation','$sexe')";
        $r = mysqli_query($cn, "insert into ". TART ." (". TARTTIT .",". TARTDESC .",". TARTPRIX .",". TARTREFM .",". TARTREFC .",". TARTREFP .",".TARTSTOCK .") values ('$titre','$description','$prix','$refmarque','$refcategorie','$refpromotion','$stock');");
        $id = mysqli_insert_id($cn);

        echo "<br><br><h2>Informations prises en compte<br><br><a href=adminarticle.php>Cliquer ici pour être redirigé</a>";
    } else {
        // echo "updatemiseenvente article set  titre='$titre',pretitre='$pretitre',email='$email',telephone='$telephone',formation='$formation',sexe='$sexe' where id='$id'";

        // Update de l'article dans la BDD

        $r = mysqli_query($cn, "update ". TART ." set ". TARTTIT ."='$titre',". TARTDESC ."='$description',". TARTPRIX ."='$prix',". TARTREFM ."='$refmarque',". TARTREFC ."='$refcategorie',". TARTREFP ."='$refpromotion',". TARTSTOCK ."='$stock' where ". TARTID ."='$id'");
        echo "<br><h2>Informations prises en compte<br><br><a href=adminarticle.php>Cliquer ici pour être redirigé</a><br>";
    }

    // Traitement en cas d'upload d'articlePhoto
    if ($_FILES["images"]["error"] == 0) {

        $det = explode(".", $_FILES["images"]["name"]);

        $r = mysqli_query($cn, "select ". TARTIMG ." from ". TART ." where ". TARTID ."='$id'");
        $d = mysqli_fetch_assoc($r);
        if (strlen($d[TARTIMG]) > 0)
            unlink("../articlephoto/" . $d[TARTIMG]);

        // $ext = strtoupper($det[count($det)-1]); // Majuscule
        $ext = strtolower($det[count($det) - 1]);

        // Erreur dû au mauvais format d'image
        if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "bmp") {
            $valide = false;
            $message .= "<br>Le format de l'images est non conforme";
        }

        // Connexion à la bdd pour l'update d'image

        $filename = "$id.$ext";
        copy($_FILES["images"]["tmp_name"], "../articlephoto/" . $filename);
        $r = mysqli_query($cn, "update ". TART ." set ". TARTIMG ."='$filename' where ". TARTID ."='$id'");
        exit;
    } else 
        echo "<br>Image non saisie";
        exit;
}


    
if ($id > 0) {   
    // Informations prises dans la BDD

    $r = mysqli_query($cn, "select ". TARTTIT .",". TARTDESC .",". TARTPRIX .",". TARTIMG .",". TARTREFM .",". TARTREFC .",". TARTREFP .",". TARTSTOCK ." from ". TART ." where ". TARTID ."=$id");
    if (mysqli_num_rows($r) == 0) {
        echo "<h2>Identifiant Inconnu";
        exit;
    } else {

        $d = mysqli_fetch_assoc($r);
        $titre = $d[TARTTIT];
        $description = $d[TARTDESC];
        $prix = $d[TARTPRIX];
        $refmarque = $d[TARTREFM];
        $refcategorie = $d[TARTREFC];
        $refpromotion = $d[TARTREFP];
        $stock = $d[TARTSTOCK];
        $images = $d[TARTIMG];
    }
} else {
    $id = 0;
    $titre = "";
    $description = "";
    $prix = "";
    $refmarque = "";
    $refcategorie = "";
    $refpromotion = "";
    $stock = "";
    $images = "";
}


?>

<body>
    <fieldset>
        <form method="post" enctype="multipart/form-data">
            <label><img src="../images/titre.png" alt="" /> </label><input type="text" name=titre placeholder="*Entrez votre titre" value="<?php echo $titre; ?>" /><br>
            <label><img src="../images/description.png" alt="" /> </label> <textarea type="text" name=description placeholder="*Entrez votre description" value="<?php echo $description; ?>" ><?php echo $description; ?></textarea><br>
            <label><img src="../images/prix.png" alt="" /> </label> <input type="number" step=0.01 name=prix placeholder="*Entrez votre prix" value="<?php echo $prix; ?>" /><br>
            
            <label><img src="../images/marque.png" alt="" /> </label> <Select name=refmarque>

            <?php
            // Affichage des marques dans la création et modication d'article
            
                                                                        foreach ($mar as $a=>$b) {
                                                                            $v = "";
                                                                            if ($b[TMARQUEID] == $refmarque) {
                                                                                $v = "selected";
                                                                            }
                                                                            echo "<option value='".$b[TMARQUEID]."'$v>".$b[TMARQUELIBELLEM]."</option>";

                                                                        }
            ?>
                                                                          
                                                                         </select><br>

            <label><img src="../images/categorie.png" alt="" /> </label> <Select name=refcategorie>
                                                                             <?php
            // Affichage des categories dans la création et modication de catégories

                                                                        foreach ($cat as $a=>$b) {
                                                                            $v = "";
                                                                            if ($b[TCATID] == $refcategorie) {
                                                                                $v = "selected";
                                                                            }
                                                                            echo "<option value='".$b[TCATID]."' $v>".$b[TCATLIBELLE]."</option>";

                                                                        }
                                                                          ?>
                                                                         </select><br>

            <label><img src="../images/promos.png" alt="" /> </label> <input type="text" name=refpromotion placeholder="*Entrez votre refpromotion" value="<?php echo $refpromotion; ?>" /><br>
            <label><img src="../images/stock.jpg" alt="" /> </label> <input type="number" min="0" name=stock placeholder="*Entrez votre stock" value="<?php echo $stock; ?>" /><br>
            <br><label></label> <input type=file name=<?php echo TARTIMG; ?>><br>
            <label></label><img class="pho" src="<?php echo "../articlephoto/$images"; ?>" alt=""><br>
            <br><input class="va" step=0.01 type=submit name=ok value=Valider /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>