<?php
    /////////////////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    /////////////////////////////////////////////
    // Affichage de la factures après un paiement
    /////////////////////////////////////////////

include_once "../mesvaleurs.php";
session_save_path(REPSESSION);
session_start();
$idsession = session_id();

// Connexion à la BDD via la function du Mesvaleurs.php
$cn = ConnecterBDD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/facture.css">
    <title>Document</title>
</head>

<body>
<!-- <header>
    <!- <li><a href='panier.php'><img src='../imagesart/panier.png' width='20' /></a></li> -->
    <?php
        // if (isset($_SESSION["id"]) == false) {
        //     echo "
        //             <ul>
        //             <li><a href='index3.php'>Accueil</a></li>
        //             <li><a href='shop.php'>Boutique</a></li>
        //             <li><a href=''>Contact</a></li>
        //             <li><a href=''>A propos</a></li>
        //             <li><a href=''>Promotions</a></li>
        //             <li><a href='panier.php'><img src='../imagesart/panier.png' width='20' /></a></li>
        //             <li><a href='connect.php'><img src='../imagesart/connexion.png' width='20' /></a></li>
        //             <li><a href='inscription.php'><img src='../imagesart/connexion.png' width='20' /></a></li>
        //             </ul>
        //         ";
        // } else {
        //     echo "
        //             <ul>
        //             <li><a href='index3.php'>Accueil</a></li>
        //             <li><a href='shop.php'>Boutique</a></li>
        //             <li><a href=''>Contact</a></li>
        //             <li><a href=''>A propos</a></li>
        //             <li><a href=''>Promotions</a></li>
        //             <li><a href='panier.php'><img src='../imagesart/panier.png' width='20' /></a></li>
        //             </ul>
        //         ";
        // }
    ?>
<!-- </header> -->

<script>
    function majpanier(val, cle) {
        document.location = "?majpanier&cle=" + cle + "&valeur=" + val;
    }
</script>

<?php

if (isset($_REQUEST["id"]))
    $id = $_REQUEST["id"];
else
    $id=0;


    // Si le bouton supprimer est cliquer

if (isset($_REQUEST["corb"])) {
    $cn = ConnecterBDD();
    mysqli_query($cn, "delete from ". TPAN ." where ". TPANREFA ."='$id'");
}

// Si le bouton acheter est cliquer
if (isset($_REQUEST["achats"])) {
    echo "<script>window.history.go(-3);</script>";
}

if (isset($_REQUEST["commandss"])) {
   header("location:Index.php");
}

if (isset($_REQUEST["majpanier"])) {
    $cn = ConnecterBDD();
    $qte = $_REQUEST["valeur"];
    $cle = $_REQUEST["cle"];

    // Mettre à jour les informations dans la BDD
    mysqli_query($cn, "update ". TPAN ." set ". TPANQTE ."=$qte where ". TPANID ."=$cle");
}

class personne {
    public $imagesart, $refarticle, $reffacture, $qte, $prixvente, $datefacture;
    
    function __construct($imagesart, $refarticle, $reffacture, $qte, $prixvente, $datefacture)
    {
        $this->imagesart = $imagesart;
        $this->refarticle = $refarticle;
        $this->reffacture = $reffacture;
        $this->qte = $qte;
        $this->prixvente = $prixvente;
        $this->datefacture = $datefacture;
    }
}

class Formation
{
    public $titre, $panier, $article, $themes;
    public $cn;

    function __destruct()
    {
        $r = mysqli_close($this->cn);
        if ($r)
            echo "<br> ";
        else
            echo "<br> Fermeture déjà exécuté...";
    }


    function __construct($titre)
    {
        $this->cn = ConnecterBDD();
        $this->titre = $titre;
        $this->article = array();
        $this->themes = array();
        $this->panier = array();
    }
    function addpanier($panier)
    {
        $this->panier[] = $panier;
    }

    function getpanier()
    {
        return $this->panier;
    }

    function Afficherpanier() {
        global $reffacture;

        // TVA
        $ntva = 20;
        // Montant des articles
        $montant = 0;
        // Montant avec la TVA 
        $montanttva = 0;
        // Montant TTC 
        $montanttc = 0;
        // Frais de livraison
        $fdl = 0;

        $st = "<form method='post'><h2 class='p4h'>FACTURE</h2><br>";
        // $st .= "<div class='facenv'>";

        //     $st .= "<div class='fac'>";
        //     $st .= "<tr><tr><td>Envoyé à</td><tr><br>";
        //     $st .= "<tr><td> Nom : " . $nom2 . "</td><tr><br>";
        //     $st .= "<tr><td>Prénom : " . $prenom2 . "</td><tr><br>";
        //     $st .= "<tr><td>Code Postal : " . $adressepostal2 . "</td><tr><br>";
        //     $st .= "<tr><td>Ville : " . $ville2 . "</td><tr><br>";
        //     $st .= "<tr><td>Adresse : " . $adresse2 . "</td><tr>";
        //     $st .= "</div>";
        //     $st .= "<br>";
        //     $st .= "<div class='exp'>";
        //     $st .= "<tr><td>Expédié par</td><br>";
        //     $st .= "<tr><td> Nom de l'enseigne: " . $nome . "</td></tr><br>";
        //     $st .= "<tr><td>Code Postal : " . $adressepostale . "</td><tr><br>";
        //     $st .= "<tr><td>Ville : " . $villee . "</td><tr><br>";
        //     $st .= "<tr><td>Adresse : " . $adressee . "</td><tr><tr>";
        //     $st .= "</div>";
        //     $st .= "<br>";
        //     $st .= "<div class='env'>";
        //     $st .= "<tr><td>Facturé à</td><br>";
        //     $st .= "<tr><td> Nom : " . $nom . "</td></tr><br>";
        //     $st .= "<tr><td>Prénom : " . $prenom . "</td><tr><br>";
        //     $st .= "<tr><td>Code Postal : " . $adressepostal . "</td><tr><br>";
        //     $st .= "<tr><td>Ville : " . $ville . "</td><tr><br>";
        //     $st .= "<tr><td>Adresse : " . $adresse . "</td><tr><tr>";
        //     $st .= "</div>";
        // $st .= "</div>";
        $st .=
            "<div class='tit'>
                <th><h4>refarticle</h4></th>
                <th><h4>reffacture</h4></th>
                <th><h4>Quantité</h4></th>
                <th><h4>Prix vente</h4></th>
                <th><h4>Date facture</h4></th>
                </div><br>
                ";
        $st .= "<hr>";

        $idsession = session_id();

        // Selection des informations du panier dans la BDD
        $r2 = mysqli_query($this->cn, "select * from ". TPAN ." where ". TPANIDS ."='$idsession'");
        $pan = array();
        while ($d = mysqli_fetch_assoc($r2)) {
            $pan[] = $d;
        }

        // Selection des informations des articles dans la BDD
        $r3 = mysqli_query($this->cn, "select * from ". TART ."");
        $art = array();
        while ($d = mysqli_fetch_assoc($r3)) {
            $art[] = $d;
        }

        // Affichage de tout les articles
        for ($j = 0; $j < count($art); $j++) {
            for ($k = 0; $k < count($pan); $k++) {
                if (($pan[$k][TPANREFA]) == ($art[$j][TARTID])) {
                    $montant = $montant + ($art[$j][TARTPRIX] * ($pan[$k][TPANQTE]));
                    $montanttva = $ntva * $montant / 100;
                    $montanttc = ((1 + $ntva / 100) * $montant);
                    $fdl = 0;
                }
            }
        }

        // Affichage des informations des articles
        $idsession = session_id();   
        
        // Pour la syntaxe objets :
        // $idfacture = $this->connect->insert_id;
        
        $idfacture = $_REQUEST["idfacture"];
        
        $r = mysqli_query($this->cn, "select ". TDETAILFIMAGESA .",". TDETAILFREFA .",". TDETAILFREFF .",". TDETAILFQTE .",". TDETAILFPRIXV .", ". TDETAILD ." from ". TDETAILF ." where ". TDETAILFREFF ." = $idfacture");

        
        $facturef = array();
        while ($d = mysqli_fetch_assoc($r)) {
            $facturef[] = $d;
        }
        
        for ($j = 0; $j < count($facturef); $j++) {
        $this->cn = ConnecterBDD();
        
            $st .= "<tr><div class='facture'>".
            "<td><img src='../articlephoto/" . $facturef[$j][TDETAILFIMAGESA] . "' width='60'/></td>" .
            "<td><div class='desc'>" . " " . $facturef[$j][TDETAILFREFF] . "</div></td>" .
            "<td><h4>" . $facturef[$j][TDETAILFQTE] . "</h4></td>" .
            "<td>" . $facturef[$j][TDETAILFPRIXV] . " €" . "</td>" .
            "<td><h4>". $facturef[$j][TDETAILD] ."</h4></td>" .
            "</div></tr>";
            $st .= "<hr>";
        }
        $st .= "<div class='price'>";
        $st .= "<h3>Total HT : " . round($montant, 2) . " €" . "</h3>";
        $st .= "<h3>TVA : " . round($montanttva, 2) . " €" . "</h3>";
        $st .= "<h3>Frais de livraison : " . round($fdl, 2) . " €" . "</h3>";
        $st .= "<h3>Total TTC : " . round($montanttc, 2) . " €" . "</h3>";
        $st .= "<div class='ka' ><tr><input type='submit' class='commandss' name='commandss' value='Revenir à la boutique' /></tr>";
        $st .= "</tr>";
        $st .= "<br><br>";
        $st .= "</form>";
        
        return $st;
    }
}

$f = new Formation("");
echo $f->Afficherpanier();
?>
</body>

</html>