<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Gestion suppression d'article
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
        border-style:revert;
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
        $id=0;

    if (isset($_REQUEST["cancel"])) {
            header("location:adminarticle.php");
    }
    

    // Lecture des données de la BDD
    if ($id > 0) {
        $r = mysqli_query($cn,"select ". TARTTIT .",". TARTDESC .",". TARTPRIX .",". TARTREFM .",". TARTREFC .",". TARTREFP .",". TARTETAT .",". TARTSTOCK .",". TARTIMG ." from ". TART ." where ". TARTID ."=$id");
        if (mysqli_num_rows($r)==0) {
        echo "<h2>Identifiant Inconnu";
        exit;
        }
        else {
            $d = mysqli_fetch_assoc($r);
            $titre = $d[TARTTIT];
            $description = $d[TARTDESC];
            $prix = $d[TARTPRIX];
            $refmarque = $d[TARTREFM];
            $refcategorie = $d[TARTREFC];
            $refpromotion = $d[TARTREFP];
            $etat = $d[TARTETAT];
            $stock = $d[TARTSTOCK];
            $images = $d[TARTIMG];

        }
    }

        // Supprimer des données de la BDD

        if (isset($_REQUEST["ok"])) {
            // $d = mysqli_fetch_assoc($r);
            $r = mysqli_query($cn, "delete from ". TART ." where ". TARTID ."='$id'");
            echo"<h2>L'article à bien était supprimé<br><br><a href=adminarticle.php>Cliquer ici pour être redirigé</a>";
            if (strlen($d[TARTIMG])>0) 
                unlink("../articlephoto/" .$d[TARTIMG]);
            exit;
        }



?>
<body>
    <fieldset>
        <h2>Supprimer un article de la bdd</h2>
        <form method="post">
        <label><img src="../images/titre.png" alt=""/> </label><input disabled=disabled value="<?php echo $titre; ?>" /><br>
        <label><img src="../images/description.png" alt=""/> </label><input disabled=disabled value="<?php echo $description; ?>" /><br>
        <label><img src="../images/prix.png" alt=""/> </label><input disabled=disabled value="<?php echo $prix; ?>" /><br>
        <label><img src="../images/marque.png" alt=""/> </label><input disabled=disabled value="<?php echo $refmarque; ?>" /><br>
        <label><img src="../images/categorie.png" alt=""/> </label><input disabled=disabled value="<?php echo $refcategorie; ?>" /><br>
        <label><img src="../images/promos.png" alt=""/> </label><input disabled=disabled value="<?php echo $refpromotion; ?>" /><br>
        <label><img src="../images/etat.png" alt=""/> </label><input disabled=disabled value="<?php echo $etat; ?>" /><br>
        <label><img src="../images/stock.jpg" alt=""/> </label><input disabled=disabled value="<?php echo $stock; ?>" /><br>
            <br><label></label><img name=<?php echo TARTIMG; ?> class=pho src="<?php echo "../articlephoto/$images"; ?>" alt=""><br>
            <br><input class="va" type=submit name=ok value=Supprimer /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>