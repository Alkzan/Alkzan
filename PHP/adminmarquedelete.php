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

    // Si le bouton retour est cliquer
    if (isset($_REQUEST["cancel"])) {
            header("location:administrateur.php");
    }
    

    // Lecture des données de la BDD
    if ($id > 0) {
        $r = mysqli_query($cn,"select ". TMARQUELIBELLEM .",". TMARQUELOGO ." from ". TMARQUE ." where ". TMARQUEID ."=$id");
        if (mysqli_num_rows($r)==0) {
        echo "<h2>Identifiant Inconnu";
        exit;
        }
        else {
            $d = mysqli_fetch_assoc($r);
            $libellemarque = $d["libellemarque"];
            $logo = $d["logo"];

        }
    }

        // Supprimer des données de la BDD

        if (isset($_REQUEST["ok"])) {
            // $d = mysqli_fetch_assoc($r);
            $r = mysqli_query($cn, "delete from ". TMARQUE ." where ". TMARQUEID ."='$id'");
            echo"<h2>La marque à bien était supprimé<br><br><a href=adminmarque.php>Cliquer ici pour être redirigé</a>";
            if (strlen($d["logo"])>0) 
                unlink("../marquephoto/" .$d["logo"]);
            exit;
        }



?>
<body>
    <fieldset>
        <h2>Supprimer une marque de la bdd</h2>
        <form method="post">
            <label><img src="../images/identifiant.png" alt=""/> </label><input disabled=disabled value="<?php echo $libellemarque; ?>" /><br>
            <br><label></label><img name=logo class=pho src="<?php echo "../marquelogo/$logo"; ?>" alt=""><br>
            <br><input class="va" type=submit name=ok value=Supprimer /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>