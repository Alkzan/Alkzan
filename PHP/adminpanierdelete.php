<?php
    /////////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 12/01/2022
    /////////////////////////////////////
    // Gestion de suppression des paniers
    /////////////////////////////////////

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

    // Si le bouton supprimer est cliquer
    if (isset($_REQUEST["idtodelete"]))
        $idtodelete = $_REQUEST["idtodelete"];
    else
        $idtodelete = "";

    // Si le bouton retour est cliquer
    if (isset($_REQUEST["cancel"])) {
            header("location:adminpanier.php");
    }
    

    // Lecture des données de la BDD        
    
    $r = mysqli_query($cn,"select a.". TARTID .",". TPANIDS .", SUM(".TPANQTE ." * ". TARTPRIX ."),". TPANREFA .", SUM(". TPANQTE .") from ". TART ." a,". TPAN ." b where ". TPANREFA ." = a.". TPANID ." and b.". TPANIDS ." = '$idtodelete' group by b.".TPANIDS ."");
        if (mysqli_num_rows($r)==0) {
        echo "<h2>Identifiant Inconnu";
        exit;
        }
        else {
            $d = mysqli_fetch_assoc($r);
            $idsession = $d[TPANIDS];
            $prix = $d["SUM(".TPANQTE ." * ". TARTPRIX .")"];
            $qte = $d["SUM(". TPANQTE .")"];

        }
    

        // Supprimer des données de la BDD

        if (isset($_REQUEST["ok"])) {
            // $d = mysqli_fetch_assoc($r);
            $r = mysqli_query($cn, "delete from ". TPAN ." where ". TPAN .".". TPANIDS ."='$idtodelete'");
            echo"<h2>Le panier à bien était supprimé<br><br><a href=adminpanier.php>Cliquer ici pour être redirigé</a>";
            exit;
        }



?>
<body>
    <fieldset>
        <h2>Supprimer un article de la bdd</h2>
        <form method="post">
        <label><img src="../images/idsession.png" alt=""/> </label><input disabled=disabled value="<?php echo $idsession; ?>" /><br>
        <label><img src="../images/marque.png" alt=""/> </label><input disabled=disabled value="<?php echo $prix; ?>" /><br>
        <label><img src="../images/qte.jpg" alt=""/> </label><input disabled=disabled value="<?php echo $qte; ?>" /><br>
            <br><input class="va" type=submit name=ok value=Supprimer /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>