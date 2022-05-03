<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Gestion de categorie
    // Ajouter / Supprimer / Modifier
    //////////////////////////////////

include_once "../mesvaleurs.php";
session_save_path(REPSESSION);
session_start();
$idsession = session_id();

// Connexion à la BDD via la function du Mesvaleurs.php
$cn = ConnecterBDD();

// Location de connexion si on est pas déjà connecter
  if (isset($_SESSION["id"])==false) {
    header("location:connect.php"); 
  }
?>
<style>
    body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        text-align: center;
        display: grid;
        justify-content: center;
        align-items: baseline;
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

class admincategorie
{
    public $id, $photo, $libelle;

    function __construct($id, $photo,$a)
    {

        $this->id = $id;
        $this->photo = $photo;
        $this->libelle = $a;
    }

}

class Categorie
{
    public $titre, $categorie, $themes;
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
        $this->categorie = array();
        $this->themes = array();
    }

    function addcategorie($categorie) {
        $this->categorie[] = $categorie;
    }

    function getcategorie() {
        return $this->categorie;
    }

    // Affichage final de la categorie
    function Affichercategorie() {

        $st = "<table><caption>Liste des categorie " . "<br>";
        $st .= "<tr>
        <th>ID</th>
        <th>Logo</th>";

        // Afficher les noms triable
        $categoriec = array(
            'libelle' => 'libelle'
        );

        // Function du triage
        foreach ($categoriec as $ind => $val) {
            $st .= "<th nowrap>$val";
            $courant2 = false;
            $affiche2 = false;
            if (isset($_REQUEST["champ"]))
                if ($_REQUEST["champ"] == $ind && $_REQUEST["sens"] == 'asc'){
                    $courant2 = true;
                    $affiche2 = true;
                }

            if ($courant2 == false)
                $st .= "<a href='?champ=$ind&sens=asc'><div class='imgs'><img src='../Images/up.png' width='15'></div></a>";
            if ($courant2 && $affiche2)
                $st .= "<a href='?champ=$ind&sens=desc'><div class='imgs'><img name='imgs' src='../Images/down.png' width='15'></div></a>";
            $st .= "</th>";
        }
        $st .= "
        <th colspan=2>Modifier Informations</th>
        </tr><br>";

        // Affichage des informations des catégories
        foreach ($this->categorie as $j => $admincategorie) {

            $st .= "<tr><td>" . $admincategorie->id . "</td>" .
                "<td><img src='../CategoriePhoto/". $admincategorie->photo . "' width='40'/></td>" .
                "<td>" . $admincategorie->libelle . "</td>" .
                "<td> <a href=admincategorieupdate.php?id=$admincategorie->id><img src=../images/update.png width=25></td>" .
                "<td> <a href=admincategoriedelete.php?id=$admincategorie->id><img src=../images/cancel.png width=25></td>" .
                "</tr>";
        }
        $st .= "<tr>";
        $st .= "<th colspan=8><a href=admincategorieupdate.php?id=0><img src=../images/plus.png width=25>";
        $st .= "</tr>";
        $st .= "</table>";
        $st .= "<tr><a href='../PHP/administrateur.php'>Retour à la section Administrateur</a></tr>";   

        return $st;
    }

    // Charger les données de la BDD
    function ChargerDonnee() {
        if (isset($_REQUEST["champ"])) {
            $sens = $_REQUEST["sens"];
            $champ = $_REQUEST["champ"];
            $r = mysqli_query($this->cn, "select ". TCATID .",". TCATPHOTO .",". TCATLIBELLE ." from ". TCAT ." order by $champ $sens");
        } else {
            $r = mysqli_query($this->cn, "select ". TCATID .",". TCATPHOTO .",". TCATLIBELLE ." from ". TCAT ." ");
        }
        // $r = mysqli_query($this->cn, "SELECT id,photo,libelle FROM categorie");

        while ($d = mysqli_fetch_assoc($r)) {
            $this->addcategorie(new admincategorie($d[TCATID], $d[TCATPHOTO], $d[TCATLIBELLE]));
        }

        // $this->addcategorie($this);

    }

    
}

$f = new Categorie("Developpement Web / Web Mobile <br><br>");
$f->ChargerDonnee();

echo $f->Affichercategorie();

?>