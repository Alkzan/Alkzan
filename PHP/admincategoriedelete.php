<?php
    //////////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////////
    // Gestion de suppression de categorie
    //////////////////////////////////////

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
            header("location:admincategorie.php");
    }
    

    // Lecture des données de la BDD
    if ($id > 0) {
        $r = mysqli_query($cn,"select ". TCATLIBELLE .",". TCATPHOTO ." from ". TCAT ." where ". TCATID ."=$id");
        if (mysqli_num_rows($r)==0) {
        echo "<h2>Identifiant Inconnu";
        exit;
        }
        else {
            $d = mysqli_fetch_assoc($r);
            $libelle = $d[TCATLIBELLE];
            $photo = $d[TCATPHOTO];

        }
    }

        // Supprimer des données de la BDD
        // Si le bouton OK est cliquer

        if (isset($_REQUEST["ok"])) {
            // $d = mysqli_fetch_assoc($r);
            $r = mysqli_query($cn, "delete from ". TCAT ." where ". TCATID ."='$id'");
            echo"<h2>La categorie à bien était supprimé<br><br><a href=admincategorie.php>Cliquer ici pour être redirigé</a>";
            if (strlen($d[TCATPHOTO])>0) 
                unlink("../categoriephoto/" .$d[TCATPHOTO]);
            exit;
        }



?>
<body>
    <fieldset>
        <h2>Supprimer une categorie de la bdd</h2>
        <form method="post">
            <label><img src="../images/identifiant.png" alt=""/> </label><input disabled=disabled value="<?php echo $libelle; ?>" /><br>
            <br><label></label><img name=<?php echo TCATPHOTO; ?>  class=pho src="<?php echo "../categoriephoto/$photo"; ?>" alt=""><br>
            <br><input class="va" type=submit name=ok value=Supprimer /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>