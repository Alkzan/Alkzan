<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Gestion de mofication d'article
    //////////////////////////////////

    include "../mesvaleurs.php";
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
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <link rel="stylesheet" href="../CSS/articlemore3.css">
    <title>Mon site e-commerce</title>
</head>
<?php

// Si le bouton ajout au panier est cliquer

if (isset($_REQUEST["addpanier"])):
    $idsession = session_id();
    $id = $_REQUEST["id"];
    $qte = $_REQUEST["qte"];

    // Selection des informations dans la BDD

    echo "select * from " . TPAN . " where ". TPANREFA ."='$id' and ". TPANIDS ."='$idsession'";
    $r = mysqli_query($cn, "select * from " . TPAN . " where ". TPANREFA ."='$id' and ". TPANIDS ."='$idsession'");
    if (mysqli_num_rows($r) > 0) {
        $valdate = Date("Y/m/j G:i");

        // Modification des informations dans la BDD panier QTE / DATE / REFARTICLE / IDSESSION
        mysqli_query($cn, "update " . TPAN . " set ". TPANQTE ." = ". TPANQTE ."+'$qte',". TPANDATEH ."='$valdate'  where ". TPANREFA ."='$id' and ". TPANIDS ."='$idsession'");
    } else {
        
        // Insertion des informations dans la BDD Panier QTE / REFARTICLE / IDSESSION
        mysqli_query($cn, "insert into " . TPAN . " (". TPANREFA .",". TPANIDS .",". TPANQTE .") values ('$id','$idsession','$qte')");
    }
     header("location:panier.php");
endif;

if (isset($_REQUEST["backk"])):
    header("location:Index.php");
endif;


if (isset($_REQUEST["id"])):
    $id = $_REQUEST["id"];
else:
    $id = 0;
endif;

    // Selection de l'id des articles dans la BDD articles
if ($id > 0) :
    $r = mysqli_query($cn, "select * from ". TART ." where ". TARTID ."=$id");
    if (mysqli_num_rows($r) == 0):
        echo "<h2>Article Inconnu";
        exit;
    else:

        $d = mysqli_fetch_assoc($r);
        $titre = $d[TARTTIT];
        $description = $d[TARTDESC];
        $prix = $d[TARTPRIX];
        $refmarque = $d[TARTREFM];
        $refcategorie = $d[TARTREFC];
        $refpromotion = $d[TARTREFP];
        $stock = $d[TARTSTOCK];
        $images = $d[TARTIMG];
    endif;
else:
    $id = 0;
    $titre = "";
    $description = "";
    $prix = "";
    $refmarque = "";
    $refcategorie = "";
    $refpromotion = "";
    $stock = 0;
    $images = "";
endif;

?>

<body>

    <main>
        <form method=post>
            <?php
            if (isset($_SESSION["id"]) == false): ?>
                <div class=alls>
                    <div class=img>
                    <img src='../articlephoto/<?= $images ?>' width='500'/>
                    </div>
                    <div class='all'>
                    <div class='title'>
                        <h2 id='titre' name='titre'><?= $titre ?></h2>    
                    </div>
                    <h3 class='stock'>Stock : <?= $stock ?></h3>
                    <div class='desc'>
                        <h4 class=description><?= $description ?></h4>
                    </div>
                    <p class=prisx><label> Prix : </label><?= $prix ?> €</p>
                    <p class=qte> <label> Quantité : </label><input class='qtei' type=number name=qte min='0' max='$stock' value='1' /><br>
                    <br><input class=buttton type='submit' name=addpanier value='Ajouter au panier' />
                    <div class='acod'>
                    <br><a class='aco' href='boutique.php'>Retour à la boutique</a></button>
                    </div>
                    </div>
                </div>
            <?php else: ?>
                <div class=alls>
                    <div class=img>
                    <img src='../articlephoto/<?= $images ?>' width='500'/>
                    </div>
                    <div class='all'>
                    <div class='title'>
                        <h2 id='titre' name='titre'><?= $titre ?></h2>    
                    </div>
                    <h3 class='stock'>Stock : <?= $stock ?></h3>
                    <div class='desc'>
                        <h4 name=description><?= $description ?></h4>
                    </div>
                    <p class=prisx><label> Prix : </label> <?= $prix ?> €</p>
                    <p class=qte> <label> Quantité : </label><input class='qtei' name=qte type=number min='0' max='$stock' value='1' /><br>
                    <br><input class=buttton type='submit' name=addpanier value='Ajouter au panier' />
                    <div class='acod'>
                    <br><a class='aco' href='boutique.php'>Retour à la boutique</a></button>
                    </div>
                    </div>
                </div>
            <?php endif; ?>
        </form>



    </main>
</body>

</html>