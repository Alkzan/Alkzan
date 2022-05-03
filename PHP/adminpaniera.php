<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 12/01/2022
    //////////////////////////////////
    // Gestion des anciens panier
    // Tout supprimer
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



class adminpaniera
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

class adminancienpanier
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
        if (isset($_REQUEST["idtodelete"])) {

            $date = date("Y-m-d");
            $r = mysqli_query($this->cn, "select a.". TPANID .",". TPANIDS .", MAX(". TPANDH ."), SUM(". TPANQTE ."), SUM(".TPANQTE ." * ". TARTPRIX .") FROM ". TPAN ." a, ". TART ." b where a.". TPANREFA ." = b.". TARTID ."  and ". TPANDH ." < '$date' group by ". TPANIDS ."");

            if ($_REQUEST["idtodelete"] == "all") {
                while ($d = mysqli_fetch_assoc($r)) {
                    mysqli_query($this->cn, "delete from ". TPAN ." where ". TPANIDS ." = '".$d[TPANIDS]."'");
                }
                // exit;
                header("location:adminpanier.php");
                
                // echo "delete * from ". TPAN ." where ". TPANIDS ." in (select a.". TPANID .",". TPANIDS .", MAX(". TPANDH ."), SUM(". TPANQTE ."), SUM(".TPANQTE ." * ". TARTPRIX .") FROM ". TPAN ." a, ". TART ." b where a.". TPANREFA ." = b.". TARTID ."  and ". TPANDH ." < '$date' group by ". TPANIDS ."";
                
                // $r = mysqli_query($this->cn, "delete * from ". TPAN ." where ". TPANIDS ." in (select a.". TPANID .",". TPANIDS .", MAX(". TPANDH ."), SUM(". TPANQTE ."), SUM(".TPANQTE ." * ". TARTPRIX .") FROM ". TPAN ." a, ". TART ." b where a.". TPANREFA ." = b.". TARTID ."  and ". TPANDH ." < '$date' group by ". TPANIDS ."");
            }
            if ($_REQUEST["idtodelete"] == "1") {

                $panierw = array();
                while ($d = mysqli_fetch_assoc($r)) {
                   $panierw[] = $d;
                }
            }
        }

        $st = "<form method='post'><table><caption>Liste des anciens paniers <br>" . "<br>";
        $st .= "<tr>";
        $st .= "<th colspan=14><a href=?idtodelete=all>Tout supprimer</a>";
        

        
        $st .= "</tr>";

        // Affichage des titres
        $st .= "<tr> 
        <th>IDSession</th>
        <th>Prix Total</th>
        <th>Quantité</th>
        <th>Date panier</th>
        </tr><br>
        ";

        // Afficher les infomations du panier
        for ($j = 0; $j < count($panierw); $j++) {
            $st .= "<tr><td>" . $panierw[$j][TPANIDS] . "</td>" .
                "<td>" . $panierw[$j]["SUM(". TPANQTE ." * ". TARTPRIX .")"] . " €" . "</td>" .
                "<td>" . $panierw[$j]["SUM(". TPANQTE .")"] . "</td>" .
                "<td>" . $panierw[$j]["MAX(". TPANDH .")"] . "</td>" .
                "</tr>";
        }

        $st .= "</table>";
        $st .= "</form><tr><a href='../PHP/adminpanier.php'>Retour à la gestion des paniers</a></tr>";



        return $st;
    }
   
    function __destruct() {
        mysqli_close($this->cn);
    }
}

$f = new adminancienpanier("");
// $f->ChargerDonnee();

echo $f->AfficherPanier();

?>