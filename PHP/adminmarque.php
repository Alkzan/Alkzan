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

class adminmarque
{
    public $id, $logo, $libellemarque;

    function __construct($id, $logo, $libellemarque)
    {

        $this->id = $id;
        $this->logo = $logo;
        $this->libellemarque = $libellemarque;
    }
}

class Marque
{
    public $libellemarque, $marque, $article, $themes;
    public $cn;

    // function __destruct()
    // {
    //     $r = mysqli_close($this->cn);
    //     if ($r)
    //         echo "<br> ";
    //     else
    //         echo "<br> Fermeture déjà exécuté...";
    // }


    function __construct($libellemarque)
    {
        $this->cn = ConnecterBDD();
        $this->libellemarque = $libellemarque;
        $this->article = array();
        $this->themes = array();
    }
    function addarticle($article)
    {
        $this->article[] = $article;
    }

    function getarticle()
    {
        return $this->article;
    }

    function Afficherarticle()
    {

        $st = "<form method='post'><table><caption>Liste des marques " . "<br>";
        $st .= "<tr> 
        <th>ID</th>
        <th>logo</th>";

        // Noms triable
        $champs = array(
            'libellemarque' => 'libelle'
        );

        // Function trier
        foreach ($champs as $ind => $val) {
            $st .= "<th nowrap>$val";
            $courant = false;
            $affiche = false;
            if (isset($_REQUEST["champ"]))
                if ($_REQUEST["champ"] == $ind && $_REQUEST["sens"] == 'asc'){
                    $courant = true;
                    $affiche = true;
                }

            if ($courant == false)
                $st .= "<a href='?champ=$ind&sens=asc'><div class='imgs'><img src='../logo/up.png' width='15'></div></a>";
            if ($courant && $affiche)
                $st .= "<a href='?champ=$ind&sens=desc'><div class='imgs'><img name='imgs' src='../logo/down.png' width='15'></div></a>";
            $st .= "</th>";
        }



        $st .= "
        <th colspan=2>Modifier Innformations</th>
        </tr><br>
        ";

        // Affichage informations des marques
        foreach ($this->article as $j => $adminmarque) {

            $st .= "<tr><td>" . $adminmarque->id . "</td>" .
                "<td><img src='../marquephoto/" . $adminmarque->logo . "' width='60'/></td>" .
                "<td>" . $adminmarque->libellemarque . "</td>" .
                "<td> <a href=adminmarqueupdate.php?id=$adminmarque->id><img src=../images/update.png width=25></td>" .
                "<td> <a href=adminmarquedelete.php?id=$adminmarque->id><img src=../images/cancel.png width=25></td>" .
                "</tr>";
        }
        $st .= "<tr>";
        $st .= "<th colspan=14><a href=adminmarqueupdate.php?id=0><img src=../images/plus.png width=25>";
        $st .= "</tr>";
        $st .= "</table>";
        $st .= "</form><tr><a href='../PHP/administrateur.php'>Retour à la section Administrateur</a></tr>";



        return $st;
    }

    function ChargerDonnee()
    {
        // Select des infomations à la BDD

        if (isset($_REQUEST["champ"])) {
            $sens = $_REQUEST["sens"];
            $champ = $_REQUEST["champ"];
            
            $r = mysqli_query($this->cn, "select ". TMARQUEID .",". TMARQUELOGO .",". TMARQUELIBELLEM ." from ". TMARQUE ." order by $champ $sens");
        } else {
           $r = mysqli_query($this->cn, "select ". TMARQUEID .",". TMARQUELOGO .",". TMARQUELIBELLEM ." from ". TMARQUE ."");
        }
        // $r = mysqli_query($this->cn, "SELECT article.id,logo,article.libellemarque,categorie.libelle,description,prix,refmarque,refcategorie,refpromotion,etat,stock,datemiseenvente,datecreation FROM article,categorie where article.refcategorie = categorie.id");

        while ($d = mysqli_fetch_assoc($r)) {
            $this->addarticle(new adminmarque($d[TMARQUEID], $d[TMARQUELOGO], $d[TMARQUELIBELLEM]));
        }

        // $this->addarticle($this);

    }

}


$f = new Marque("");
$f->ChargerDonnee();

echo $f->Afficherarticle();

?>