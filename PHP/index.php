<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
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
    <script src="https://kit.fontawesome.com/21149d0622.js" crossorigin="anonymous"></script>
    <script src="../index.js" defer></script>
    <!-- <link rel="stylesheet" href="../CSS/shop.css"> -->
    <title>Mon site e-commerce</title>
</head>
<?php

    // Connexion et affichage des categorie à la BDD pour le filtrage
    $r = mysqli_query($cn, "select * from ". TCAT ." order by ". TCATLIBELLE ." ");
    $selected = array();
    while ($d = mysqli_fetch_assoc($r)) {
        $selected[] = $d;
    }

?>

<body class="shop">
    <?php include 'header.php'; ?>

    <main>
    <form method='post'>
        <div class="filtre">
            <div class='cat'>
                <h3>Filtrer la recherche</h3>
                <h4>CATEGORIE</h4>

                <!-- Filtrer par la categorie avec un select -->
                <Select name=refcategorie>
                    <?php
                    foreach ($selected as $a => $b) {
                        $v = "";
                        if ($selected[TCATID] == $refcategorie) {
                            $v = "selected";
                        }
                        echo "<option value='" . $b[TCATID] . "' $v>" . $b[TCATLIBELLE] . "</option>";
                    }
                    ?>
                </select><br><br>
                <br>

                <?php
                // Filtrer par la categorie avec un checkbox
                $selection = "";

                if (isset($_REQUEST["bt"])) {
                    $check = $_REQUEST["checkk"];
                } else {
                    $check = "";
                }

                for ($j = 0; $j < count($selected); $j++) {
                    $v = "";
                    if ($check == $selected[$j][TCATID]) {
                        $v = "checked";
                        $selection = $selected[$j][TCATLIBELLE];
                    }
                    echo "<label>".$selected[$j][TCATLIBELLE]."</label><input type='checkbox' name='checkk' value='" . $selected[$j][TARTID] . "' $v/><br><br>";
                }

                // Connexion du filtrage a la BDD avec un ligne SQL
                if (isset($_REQUEST["bt"])) {
                    if ($selection != null) {
                        $r4 = mysqli_query($cn,"select * from ". TCAT ." where ". TCATLIBELLE ."='$selection'");
                        echo "select * from ". TCAT ." where ". TCATLIBELLE ."='$selection'";
                    }
                }

                ?>
                

            </div>
            <div>
                <h4>PRIX</h4>
                <input type="range" min="1" max="200" value="13" class="slider" id="myRange">
                <div class='pr'>
                    <input type="text" class='inppr' placeholder="Min (€)" min="0" max="200" value="">
                    <input type="text" class='inppr' placeholder="Max (€)" min="0" max="200" value="">
                </div>
            </div>
            <br>
            <input type="submit" name="bt" value="Filtrer">
        </div>
    </form>
        <iframe style='overflow-y:hidden;' class='frame' name='iiframe' src='boutique.php' width="100%" height="909"></iframe>
    </main>
    <footer>
        <div class="textfooter">
            Tous droits réservés © E-Commerce, 2021 / 2022
        </div>
    </footer>
</body>

</html>