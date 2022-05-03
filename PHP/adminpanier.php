<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 12/01/2022
    //////////////////////////////////
    // Gestion des paniers
    // Supprimer et afficher
    //////////////////////////////////

include_once "../mesvaleurs.php";
session_save_path(REPSESSION);
session_start();
$idsession = session_id();

// Connexion à la BDD via la function du Mesvaleurs.php
$cn = ConnecterBDD();

// Location de connexion si on est pas déjà connecter
if (isset($_SESSION["id"]) == false) {
    header("location:connect.php");
}
?>
<style>
    body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        text-align: center;
        display: grid;
        justify-content: center;
        align-items: center;

    }

    table,
    th,
    td {
        border-color: grey;
        border-style: solid;
        border-collapse: collapse;
        padding: 10px;
        text-align: center;
        font-style: italic;
    }

    th {
        width: 10%;
    }

    a {
        text-decoration: none;
        color: black;
        font-style: italic;
    }

    button {
        border: none;
        color: black;
        font-style: italic;
        background: none;
        font-size: 15px;
        font-weight: 600;
    }

    .imgs {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        float: right;
    }
</style>
<meta charset="UTF-8" />
<?php

// Supprimer tout panier d'un utilisateurs
if (isset($_REQUEST["sp"])) {
    $idsession = session_id();
    $cn = ConnecterBDD();
    mysqli_query($cn, "delete from " . TPAN . " where idsession='$idsession'");
}

class adminpanier
{
    public $idsession, $id, $prix, $qte, $date;

    function __construct($idsession, $id, $prix, $qte, $date)
    {

        $this->idsession = $idsession;
        $this->id = $id;
        $this->prix = $prix;
        $this->qte = $qte;
        $this->date = $date;
    }

}

class adminpanierM
{
    public $titre, $panier, $themes;
    public $cn;

    function __construct($titre)
    {
        $this->cn = ConnecterBDD();
        $this->titre = $titre;
        $this->panier = array();
        $this->themes = array();
    }
    function addpanier($panier)
    {
        $this->panier[] = $panier;
    }

    function getpanier()
    {
        return $this->panier;
    }

    function AfficherPanier(){
        
        // Lecture à la BDD
        $r = mysqli_query($this->cn, "select a.". TPANID .",". TPANIDS .", MAX(". TPANDH ."), SUM(". TPANQTE ."), SUM(".TPANQTE ." * ". TARTPRIX .") FROM ". TPAN ." a, ". TART ." b where a.". TPANREFA ." = b.". TARTID ." group by ". TPANIDS ."");

        $panierw = array();
        while ($d = mysqli_fetch_assoc($r)) {
            $panierw[] = $d;
        }

        $st = "<form method='post'><table><caption>Liste des paniers <br>" . "<br>";
        $st .= "<tr>";
        $st .= "<th colspan=14><a href=adminpaniera.php?idtodelete=1>Supprimer les anciens paniers</a>";
        $st .= "</tr>";

        

        // Affichage des titres
        $st .= "<tr> 
        <th>IDSession</th>
        <th>Prix Total</th>
        <th>Quantité</th>
        <th>Date panier</th>
        <th>Supprimer</th>
        </tr><br>
        ";

        // Afficher les infomations du panier
        for ($j = 0; $j < count($panierw); $j++) {
                $st .= "<tr><td>" . $panierw[$j][TPANIDS] . "</td>" .
                "<td>" . $panierw[$j]["SUM(". TPANQTE ." * ". TARTPRIX .")"] . " €" . "</td>" .
                "<td>" . $panierw[$j]["SUM(". TPANQTE .")"] . "</td>" .
                "<td>" . $panierw[$j]["MAX(". TPANDH .")"] . "</td>" .
                "<td> <a href=adminpanierdelete.php?idtodelete=".$panierw[$j][TPANIDS]."><img src=../images/cancel.png width=25></td>" .
                "</tr>";
        }   
            
            $st .= "</table>";
            $st .= "</form><tr><a href='../PHP/administrateur.php'>Retour à la section Administrateur</a></tr>";
            return $st;
    }
    
    function __destruct() {
        mysqli_close($this->cn);
    }
}

$f = new adminpanierM("");
echo $f->AfficherPanier();

?>