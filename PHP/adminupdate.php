<?php
    ////////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    ////////////////////////////////////
    // Gestion de mofication des admins
    ////////////////////////////////////

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

if (isset($_REQUEST["id"]))
    $id = $_REQUEST["id"];

else
    $id = 0;

if (isset($_REQUEST["cancel"])) {
    header("location:admin.php");
}

// Modifier des données de la BDD

if (isset($_REQUEST["ok"])) {

    // Protection contre les caractères spéciaux

    $uid = mysqli_real_escape_string($cn, $_REQUEST["uid"]);
    $nom = mysqli_real_escape_string($cn, $_REQUEST["nom"]);
    $prenom = mysqli_real_escape_string($cn, $_REQUEST["prenom"]);
    $civilite = mysqli_real_escape_string($cn, $_REQUEST["civilite"]);
    $naissance = mysqli_real_escape_string($cn, $_REQUEST["naissance"]);
    $email = mysqli_real_escape_string($cn, $_REQUEST["email"]);
    $grade = mysqli_real_escape_string($cn, $_REQUEST["grade"]);

    // Création de l'article dans la BDD 

    if ($id == 0) {
        // echo "insert into article (uid,preuid,email,telephone,formation,sexe) values ('$uid','$preuid','$email','$telephone','$formation','$sexe')";
        $r = mysqli_query($cn, "insert into ". TUTIT ." (". TUTITUID .",". TUTITNOM .",". TUTITPRENOM .",". TUTITCIVILITE .",". TUTITNAISSANCE .",". TUTITEMAIL .",".TUTITGRADE .") values ('$uid','$nom','$prenom','$civilite','$naissance','$email','$grade');");
        $id = mysqli_insert_id($cn);

        echo "<br><br><h2>Informations prises en compte<br><br><a href=admin.php>Cliquer ici pour être redirigé</a>";
    } else {
        // echo "updatemiseenvente article set  uid='$uid',preuid='$preuid',email='$email',telephone='$telephone',formation='$formation',sexe='$sexe' where id='$id'";

        // Update de l'article dans la BDD

        $r = mysqli_query($cn, "update ". TUTIT ." set ". TUTITUID ."='$uid',". TUTITNOM ."='$nom',". TUTITPRENOM ."='$prenom',". TUTITCIVILITE ."='$civilite',". TUTITNAISSANCE ."='$naissance',". TUTITEMAIL ."='$email',". TUTITGRADE ."='$grade' where ". TUTITID ."='$id'");
        echo "<br><h2>Informations prises en compte<br><br><a href=admin.php>Cliquer ici pour être redirigé</a><br>";
    }
}


    
if ($id > 0) {   
    // Informations prises dans la BDD

    $r = mysqli_query($cn, "select ". TUTITUID .",". TUTITNOM .",". TUTITPRENOM .",". TUTITCIVILITE .",". TUTITNAISSANCE .",". TUTITEMAIL .",". TUTITGRADE ." from ". TUTIT ." where ". TUTITID ."=$id");
    if (mysqli_num_rows($r) == 0) {
        echo "<h2>Identifiant Inconnu";
        exit;
    } else {

        $d = mysqli_fetch_assoc($r);
        $uid = $d[TUTITUID];
        $nom = $d[TUTITNOM];
        $prenom = $d[TUTITPRENOM];
        $civilite = $d[TUTITCIVILITE];
        $naissance = $d[TUTITNAISSANCE];
        $email = $d[TUTITEMAIL];
        $grade = $d[TUTITGRADE];
    }
} else {
    $id = 0;
    $uid = "";
    $nom = "";
    $prenom = "";
    $civilite = "";
    $naissance = "";
    $email = "";
    $grade = "";
}

$genre = array("Homme", "Femme");

?>

<body>
    <?php 
    if ($id == 3) {
        header("location:admin.php");
    } else {
    ?>
    <fieldset>
    <h2>Modifier un admin de la bdd</h2>
        <form method="post" enctype="multipart/form-data">
            <label><img src="../Images/prenom.jpg" alt="" /> </label><input type="text" name=uid placeholder="*Entrez votre uid" value="<?php echo $uid; ?>" /><br>
            <label><img src="../Images/prenom.jpg" alt="" /> </label> <textarea type="text" name=nom placeholder="*Entrez votre nom" value="<?php echo $nom; ?>" ><?php echo $nom; ?></textarea><br>
            <label><img src="../Images/prenom.jpg" alt="" /> </label> <input type="text" name=prenom placeholder="*Entrez votre prenom" value="<?php echo $prenom; ?>" /><br>
            <label><img src="../Images/corbeille.png" alt="" /> </label> <input type="date" name=naissance value="<?php echo $naissance; ?>" /><br>
            <label><img src="../Images/email.png" alt="" /> </label> <input type="email" name=email placeholder="*Entrez votre email" value="<?php echo $email; ?>" /><br>
            <label><img src="../Images/stock.jpg" alt="" /> </label> <input type="number" min="0" max="2" name=grade placeholder="*Entrez votre grade" value="<?php echo $grade; ?>" /><br>
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
            <br><input class="va" step=0.01 type=submit name=ok value=Valider /> <input class="va" type=submit name=cancel value=Annuler />
        </form>
    </fieldset>
    <?php
        }
    ?>