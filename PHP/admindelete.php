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
            header("location:admin.php");
    }
    

    // Lecture des données de la BDD
    if ($id > 0) {
        $r = mysqli_query($cn,"select ". TUTITUID ." from ". TUTIT ." where ". TUTITID ."=$id");
        if (mysqli_num_rows($r)==0) {
        echo "<h2>Identifiant Inconnu";
        exit;
        }
        else {
            $d = mysqli_fetch_assoc($r);
            $uid = $d[TUTITUID];
        }
    }

        // Supprimer des données de la BDD

        if (isset($_REQUEST["ok"])) {
            // $d = mysqli_fetch_assoc($r);
            $r = mysqli_query($cn, "update ". TUTITGRADE ." = 0 where ". TUTIT .".". TUTITID ."='$id'");
            echo "update ". TUTITGRADE ." = 0 where ". TUTIT .".". TUTITID ."='$id'";
            echo"<h2>Le grade admin à bien était retiré<br><br><a href=admin.php>Cliquer ici pour être redirigé</a>";
            exit;
        }



?>
<body>
    <?php 
    if ($id == 3) {
        header("location:admin.php");
    } else {
    ?>
    <fieldset>
        <form method="post">
        <h2>Voulez vous vraiment supprimer le grade de l'admin <br>
        <?php echo $uid; ?> ?</h2>
        <br><input class="va" type=submit name=ok value=Supprimer /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>
    <?php
    }
    ?>  