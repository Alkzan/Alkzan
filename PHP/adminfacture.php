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

class adminfacture
{
    public $idsession, $id, $prix, $qte, $datef;

    function __construct($idsession, $id, $prix, $qte, $datef)
    {

        $this->idsession = $idsession;
        $this->id = $id;
        $this->prix = $prix;
        $this->qte = $qte;
        $this->datef = $datef;
    }

}

class adminfactureA
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
        $r = mysqli_query($this->cn, "select ". TDETAILFREFF .",". TDETAILFPRIXV .",". TDETAILD ." from ". TDETAILF ." group by ". TDETAILFREFF ."");

        $panierw = array();
        while ($d = mysqli_fetch_assoc($r)) {
            $panierw[] = $d;
        }

        $st = "<form method='post'><table><caption>Liste des factures <br>" . "<br>";

        // Affichage des titres
        $st .= "<tr> 
        <th>Référence de la facture</th>
        <th>Prix Total</th>
        <th>Date de la facture</th>
        <th>Consulter</th>
        </tr><br>
        ";

        // Afficher les infomations du panier
        for ($j = 0; $j < count($panierw); $j++) {
            $fac = $panierw[$j][TDETAILFREFF];
            $st .= "<tr><td>" . $panierw[$j][TDETAILFREFF] . "</td>" .
                "<td>" . $panierw[$j][TDETAILFPRIXV] . " €" . "</td>" .
                "<td>" . $panierw[$j][TDETAILD] . "</td>" .
                "<td> <a href='consultf.php?fac=$fac'><img src=../images/consult.png width=25></td>" .
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

$f = new adminfactureA("");
echo $f->AfficherPanier();

?>