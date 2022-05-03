<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Gestion des articles du magasin
    // Ajouter / Supprimer / Modifier
    //////////////////////////////////

include_once "../mesvaleurs.php";
session_save_path(REPSESSION);
session_start();
$idsession = session_id();

// Connexion à la BDD via la function du Mesvaleurs.php
$bdd = ConnecterBDD();
?>
<style>
    body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        text-align: center;
        display: grid;
        justify-content: center;
        align-items: center;
        max-width: 1920px;
        margin:auto;
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

class adminarticle {
    public $id, $images, $titre, $description, $prix, $refmarque, $refcategorie, $refpromotion, $etat, $stock, $datemiseenvente, $datecreation, $libelle, $libellemarque;

    function __construct($id, $images, $titre, $description, $prix, $refmarque, $refcategorie, $refpromotion, $etat, $stock, $datemiseenvente, $datecreation, $libelle, $libellemarque)
    {

        $this->id = $id;
        $this->images = $images;
        $this->titre = $titre;
        $this->description = $description;
        $this->prix = $prix;
        $this->refmarque = $refmarque;
        $this->refcategorie = $refcategorie;
        $this->refpromotion = $refpromotion;
        $this->etat = $etat;
        $this->stock = $stock;
        $this->datemiseenvente = $datemiseenvente;
        $this->datecreation = $datecreation;
        $this->libelle = $libelle;
        $this->libellemarque = $libellemarque;
    }
}

class adminarticleM {
    public $titre, $marque, $article, $themes;
    public $bdd;

    // function __destruct()
    // {
    //     $r = mysqli_close($this->bdd);
    //     if ($r)
    //         echo "<br> ";
    //     else
    //         echo "<br> Fermeture déjà exécuté...";
    // }

// Construct de la class AdminArticleM

    function __construct($titre) {
        $this->bdd = ConnecterBDD();
        $this->titre = $titre;
        $this->article = array();
        $this->themes = array();
    }

    function addarticle($article) {
        $this->article[] = $article;
    }

    function getarticle() {
        return $this->article;
    }

    // Affichage final du script

    function Afficherarticle() {

        $st = "<form method='post'><table><caption>Liste des articles " . "<br>";
        $st .= "<tr> 
        <th>ID</th>
        <th>Images</th>";

        // Noms configurer pour le trie

        $champs = array(
            'a.titre' => 'libelle',
            'a.description' => 'description',
            'a.prix' => 'Prix',
            'c.libellemarque' => 'Marque',
            'b.libelle' => 'Categorie',
            'a.etat' => 'Etat',
            'a.stock' => 'Stock'
        );

        // Function pour trier

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
                $st .= "<a href='?champ=$ind&sens=asc'><div class='imgs'><img src='../Images/up.png' width='15'></div></a>";
            if ($courant && $affiche)
                $st .= "<a href='?champ=$ind&sens=desc'><div class='imgs'><img name='imgs' src='../Images/down.png' width='15'></div></a>";
            $st .= "</th>";
        }


        // Noms non configurable pour le trie 
        $st .= "
        <th>Promotion</th>
        <th>Mise En Ligne</th>
        <th>Création</th>
        <th colspan=2>Modifier Informations</th>
        </tr><br>
        ";

        // Affichage des informations dans le gestion article
        foreach ($this->article as $j => $adminarticle) {

            $st .= "<tr><td>" . $adminarticle->id . "</td>" .
                "<td><img src='../articlephoto/" . $adminarticle->images . "' width='60'/></td>" .
                "<td>" . $adminarticle->titre . "</td>" .
                "<td>" . substr($adminarticle->description, 0, 30) . "..." . "</td>" .
                "<td>" . $adminarticle->prix . " €" . "</td>" .
                "<td>" . $adminarticle->libellemarque . "</td>" .
                "<td>" . $adminarticle->libelle . "</td>" .
                "<td>" . $adminarticle->etat . "</td>" .
                "<td>" . $adminarticle->stock . "</td>" .
                "<td>" . $adminarticle->refpromotion . " %" . "</td>" .
                "<td>" . $adminarticle->datemiseenvente . "</td>" .
                "<td>" . $adminarticle->datecreation . "</td>" .
                "<td> <a href=adminarticleupdate.php?id=$adminarticle->id><img src=../images/update.png width=25></td>" .
                "<td> <a href=adminarticledelete.php?id=$adminarticle->id><img src=../images/cancel.png width=25></td>" .
                // "<td>" . $adminarticle->getDateadminarticle() . "</td><br>" .
                "</tr>";
        }
        $st .= "<tr>";
        $st .= "<th colspan=14><a href=adminarticleupdate.php?id=0><img src=../images/plus.png width=25>";
        $st .= "</tr>";
        $st .= "</table>";
        $st .= "</form><tr><a href='../PHP/administrateur.php'>Retour à la section Administrateur</a></tr>";



        return $st;
    }

    // Charger les données de la BDD
    function ChargerDonnee() {
        // echo "SELECT article.id,images,article.titre,description,prix,refmarque,refcategorie,refpromotion,etat,stock,datemiseenvente,datecreation FROM article,categorie where article.refcategorie = categorie.id";


        if (isset($_REQUEST["champ"])) {
            $sens = $_REQUEST["sens"];
            $champ = $_REQUEST["champ"];
            $r = $this->bdd->query("select ". TARTID .",". TARTIMG .",". TARTTIT .",".TCATLIBELLE .",". TMARQUELIBELLEM .",". TARTDESC .",". TARTPRIX .",". TARTREFM .",". TARTREFC .",". TARTREFP .",". TARTETAT .",". TARTSTOCK .",". TARTDMEEV .",". TARTDC ." from ". TART .",". TMARQUE .",". TCAT ." where ". TARTREFM ." = ". TCATID ." and ". TARTREFC ." = ". TMARQUEID ." order by $champ $sens");
        } else {   
            $r = $this->bdd->query("select ". TART .".". TARTID .",". TARTIMG .",". TARTTIT .",". TCATLIBELLE .",". TMARQUELIBELLEM .",". TARTDESC .",". TARTPRIX .",". TARTREFM .",". TARTREFC .",". TARTREFP .",". TARTETAT .",". TARTSTOCK .",". TARTDMEEV .",". TARTDC ." from ". TART .",". TMARQUE .",". TCAT ." where ". TARTREFM ." = ". TMARQUE .".". TCATID ." and ". TARTREFC ." = ". TCAT .".". TMARQUEID ."");
        }

        while ($d = $r->fetch_assoc()) {
            $this->addarticle(new adminarticle($d[TARTID], $d[TARTIMG], $d[TARTTIT], $d[TARTDESC], $d[TARTPRIX], $d[TARTREFM], $d[TARTREFC], $d[TARTETAT], $d[TARTSTOCK], $d[TARTREFP], $d[TARTDMEEV], $d[TARTDC], $d[TCATLIBELLE], $d[TMARQUELIBELLEM]));
        }

        // $this->addarticle($this);

    }
}



// Affichage de la class et de la function ChargerDonnee
$f = new adminarticleM("");
$f->ChargerDonnee();

echo $f->Afficherarticle();

?>