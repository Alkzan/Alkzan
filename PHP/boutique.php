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
    <link rel="stylesheet" href="../CSS/shop.css">
    <title>Mon site e-commerce</title>
</head>

<?php

    // Ajouter au panier est cliquer
    if (isset($_REQUEST["addpanier"])):
        $idsession = session_id();
        $id = $_REQUEST["id"];
        $qte = $_REQUEST["qte"];

        // Select Panier dans la BDD
        $r = mysqli_query($cn, "select * from ". TPAN ." where ". TPANREFA ."='$id' and ". TPANIDS ."='$idsession'");
        if (mysqli_num_rows($r) > 0):
            // $valdate = Date("Y/m/j G:i");

            // Mettre a jour le panier dans la BDD
            mysqli_query($cn, "update ". TPAN .",". TART ." set ". TPANQTE ." = ". TPANQTE ."+1  where ". TPANREFA ." = ". TART .".$id and ". TPANIDS ." = ". TPAN .".$idsession");
        else:

            // Inseré dans le panier dans la BDD
            mysqli_query($cn, "insert into ". TPAN .",". TART ." (". TPANREFA .",". TPANIDS .",". TPANQTE .") values ('". TPANREFA ." = ". TART .".$id','". TPAN .".$idsession','". TPAN .".$qte')");
        endif;
        header("location:panier.php");
    endif;

    // Selectioner la catégorie dans la BDD

    $r = mysqli_query($cn, "select * from ". TCAT ." order by ". TCATLIBELLE ."");
    $selected = array();
    while ($d = mysqli_fetch_assoc($r)):
        $selected[] = $d;
    endwhile;

    // Selectioner l'article dans la BDD

    $maliste = array();
    $r = mysqli_query($cn, "select * from ". TART ."");
    while ($d = mysqli_fetch_assoc($r)):
        $maliste[] = $d;
    endwhile;
        
    $r = mysqli_query($cn, "select * from ". TART ."");

    $d = mysqli_fetch_assoc($r);
    $id = $d[TARTID];
    $titre = $d[TARTTIT];
    $prix = $d[TARTPRIX];
    $description = $d[TARTDESC];
    $images = $d[TARTIMG];
    $stock = $d[TARTSTOCK]; 
?>

<?php
function Recherche() {
    $cn = ConnecterBDD();
    $searchbar = array();
    $recherche = str_replace(">", "", $_REQUEST["search"]);
    $recherche = str_replace("<", "", $recherche);
    $recherche = str_replace("/", "", $recherche);
    $recherche = str_replace("\"", "", $recherche);
    $recherche = str_replace("?", "", $recherche);
    $recherche = str_replace("!", "", $recherche);
    $recherche = str_replace("*", "", $recherche);
    // $recherche = str_replace("\", "", $recherche);
    $recherche = mysqli_real_escape_string($cn, $recherche);


    // echo "SELECT * FROM " . TART . "," . TCAT . " WHERE " . TARTREFC . " = ". TCAT ."." . TCATID . " AND (" . TART . "." . TARTTIT ." LIKE \"%" . $_REQUEST["search"] . "%\" OR " . TCAT . "." . TCATLIBELLE . " LIKE \"%" . $_REQUEST["search"] . "%\")";

    // echo "SELECT * FROM " . TART . " a,". TCAT . " b WHERE a.". TARTREFC . " = b." . TCATID . " AND (a." . TARTTIT ." LIKE \"%" . $_REQUEST["search"] . "%\" OR b." . TCATLIBELLE . " LIKE \"%" . $_REQUEST["search"] . "%\")";

    $r = mysqli_query($cn, "SELECT * FROM " . TART . " a,". TCAT . " b WHERE a.". TARTREFC . " = b." . TCATID . " AND (a." . TARTTIT ." LIKE \"%" . $recherche . "%\" OR b." . TCATLIBELLE . " LIKE \"%" . $recherche . "%\")");
    
     while ($d = mysqli_fetch_assoc($r)):
         $searchbar[] = $d;
     endwhile;

    if(count($searchbar) == 0):
        echo "Aucun article trouvé pour $recherche";
    else:

        $r = mysqli_query($cn, "select * from ". TART ."");
        $maliste = array();
        while ($d = mysqli_fetch_assoc($r)):
            $maliste[] = $d;
        endwhile;

        for ($k = 0; $k < count($maliste); $k++):
            for ($y = 0; $y < count($searchbar); $y++):
                if ($searchbar[$y][TARTTIT] == $maliste[$k]["titre"]): ?>
        
                    <article value='<?= $maliste[$k][TARTTIT] ?>'>
                        <div class='plusimg'>
                        <input type='submit' class=plus name='addpanier' value='+' />
                        <a href='articlemore.php?id=<?= $maliste[$k][TARTID] ?>'><img src='../articlephoto/<?= $maliste[$k][TARTIMG] ?>' width='300'/></a>
                        </div>
                            <h2 id='titre' name='titre'><a href='articlemore.php?id=<?= $maliste[$k][TARTID] ?>'><?= $maliste[$k][TARTTIT] ?></a></h2>    
                        <div class='nameprix'>
                            <h3 name=stock>Quantités : <?= $maliste[$k][TARTSTOCK] ?></h3>
                            <p name='prix'><?= $maliste[$k][TARTPRIX] ?></p>
                        </div>
                        <div class='desc'>
                            <h4 name=description><?= substr($maliste[$k][TARTDESC], 0,  29) . "..." ?></h4>
                        </div>
                    </article>

                <?php endif; ?>
            <?php endfor; ?>
        <?php endfor; ?>
    <?php endif; ?>
<?php } ?>

<body>

    <main>

         <div class="articless">
            <form method=post>
            <?php
            if (isset($_REQUEST["search"])):
                Recherche();
            else:

                foreach ($maliste as $ind => $val):
                    $id = $val[TARTID];
                    $images = $val[TARTIMG];
                    $titre = $val[TARTTIT];
                    $description = $val[TARTDESC];
                    $prix = $val[TARTPRIX];
                    $stock = $val[TARTSTOCK]; ?>

                    <article value='<?= $titre ?>'>
                        <div class='plusimg'>
                        <input type='submit' class=plus name='addpanier' value='+' />
                        <a href='articlemore.php?id=<?= $id ?>'><img src='../articlephoto/<?= $images ?>' width='300'/></a>
                        </div>
                            <h2 id='titre' name='titre'><a href='articlemore.php?id=<?= $id ?>'><?= $titre ?></a></h2>    
                        <div class='nameprix'>
                            <h3 name=stock>Quantités : <?= $stock ?></h3>
                            <p name=prix><?= $prix ?> € </p>
                        </div>
                        <div class='desc'>
                            <h4 name=description><?= substr($description, 0, 29) . "..." ?></h4>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
            </form>
        </div> 
    </main>
</body>

</html>