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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/panier.css">
    <script src="https://kit.fontawesome.com/21149d0622.js" crossorigin="anonymous"></script>
    <script src="../index.js" defer></script>
    <title>Document</title>
</head>

<body>

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
        header("location:boutique.php");
    }

    // Si vous le bouton majpanier est cliquer
    if (isset($_REQUEST["majpanier"])) {
        $cn = ConnecterBDD();
        $qte = $_REQUEST["valeur"];
        $cle = $_REQUEST["cle"];

        // Mise à jour de la BDD panier 
        mysqli_query($cn, "update ". TPAN ." set ". TPANQTE ."=$qte where ". TPANID ."=$cle");
}

class panierC
{
    public $images, $titre, $qte, $prix, $id, $idsession, $stock, $total, $cle;

    function __construct($images, $titre, $qte, $prix, $id, $idsession, $stock, $total, $cle)
    {

        $this->images = $images;
        $this->titre = $titre;
        $this->qte = $qte;
        $this->prix = $prix;
        $this->id = $id;
        $this->idsession = $idsession;
        $this->stock = $stock;
        $this->total = $total;
        $this->cle = $cle;
    }
}

class panierM
{
    public $titre, $panier, $article, $themes;
    public $cn;

    // function __destruct()
    // {
    //     $r = mysqli_close($this->cn);
    //     if ($r)
    //         echo "<br> ";
    //     else
    //         echo "<br> Fermeture déjà exécuté...";
    // }


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

    function Afficherpanier()
    {

        $ntva = 20;
        $montant = 0;
        $montanttva = 0;
        $montanttc = 0;
        $fdl = 0;

        $idsession = session_id();

        $r2 = mysqli_query($this->cn, "select * from ". TPAN ." where ". TPANIDS ."='$idsession'");
        $pan = array();
        while ($d = mysqli_fetch_assoc($r2)) {
            $pan[] = $d;
        }
        $r3 = mysqli_query($this->cn, "select * from ". TART ."");
        $art = array();
        while ($d = mysqli_fetch_assoc($r3)) {
            $art[] = $d;
        }

        $st = "<form method='post'><h2 class='p4h'>Votre panier</h2><br>";
        $st .=
            "<div class='tit'>
                <th><h4>Images</h4>
                <h4>Titre</h4>
                <h4>Quantité</h4>
                <h4>Prix</h4>
                </div><br>
                ";
        $st .= "<hr>";

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

        if ($pan == null) {
            echo "<br><tr><div class='pa'><td> Votre panier est vide. </td></div></tr>";
        } else 
        foreach ($this->panier as $j => $panierC) {
            $st .= "<tr><div class='pa'><td><img src='../articlephoto/" . $panierC->images . "' width='60'/></td>" .
                "<td>" . $panierC->titre . "</td>" .
                "<td><input class=num type=number min=0 max=" . $panierC->stock . " onChange='majpanier(this.value,$panierC->cle)' value=" . $panierC->qte . " /></td>" .
                "<td>" . $panierC->total . " €" . "</td>" .
                "<td><a href='?corb&id=". $panierC->id ."'><img class='bc' src='../Images/corbeille.png' width='15'/></a></td>" .
                "</div></tr>";
            $st .= "<hr>";
        }
        $st .= "<div class='price'>";
        $st .= "<h3>Total HT : " . round($montant, 2) . " €" . "</h3>";
        $st .= "<h3>TVA : " . round($montanttva, 2) . " €" . "</h3>";
        $st .= "<h3>Frais de livraison : " . round($fdl, 2) . " €" . "</h3>";
        $st .= "<h3>Total TTC : " . round($montanttc, 2) . " €" . "</h3>";
        $st .= "</div>";
        if ($pan == null) {
            $st .= "<div class='ca' ><tr><input type='submit' class='achats' name='achats' value='Continuer mes achats' /></div></tr>";
        } else {
            $st .= "<div class='ca' ><tr><input type='submit' class='achats' name='achats' value='Continuer mes achats' /></tr>";
            $st .= "<tr><input type='submit' class='commands' name='commands' value='Passer la commande' /></div></tr>";
        }
        $st .= "<br><tr>";
        $st .= "<h2 class='pm'>Paiement 100 % sécurisé.</h2>";
        $st .= "<div class='paiement'>";
        $st .= "<br><img src='../Images/paypal.png' width='25' />";
        $st .= "<img src='../Images/cb.jpg' width='25' />";
        $st .= "<img src='../Images/visa.png' width='25' />";
        $st .= "<img src='../Images/Mc.png' width='25' />";
        $st .= "</div>";
        $st .= "</tr>";
        $st .= "<br><br>";
        $st .= "</form>";
        
        return $st;
    }

    function ChargerDonnee()
    {
        $idsession = session_id();
        
        $r = mysqli_query($this->cn, "select *,". TPANQTE ."*". TARTPRIX ." as total , ". TPAN .".". TPANID ." as cle from ". TPAN .",". TART ."
        where ". TPANREFA ." = ".TART .".". TARTID ." and ". TPANIDS ." = '$idsession'");

        while ($d = mysqli_fetch_assoc($r)) {
            $this->addpanier(new panierC($d[TARTIMG], $d[TARTTIT], $d[TPANQTE], $d[TARTPRIX], $d[TPANREFA], $d[TPANIDS], $d[TARTSTOCK], $d["total"], $d["cle"]));
        }

        echo $d;

        if (isset($_REQUEST["commands"])) {
            $this->cn = ConnecterBDD();
            $id = $_REQUEST["id"];
            $r = mysqli_query($this->cn, "select ". TUTITID .",". TUTITNOM .",". TUTITPRENOM ." from ". TUTIT ."");
            header("location:paiement.php");
        }

        // $this->addarticle($this);

    }

    function __destruct() {
        mysqli_close($this->cn);
    }
}




$f = new panierM("");
$f->ChargerDonnee();

echo $f->Afficherpanier();

?>
</body>

</html>