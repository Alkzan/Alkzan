<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Gestion des Addministrateurs
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

class admin {
    public $id, $uid, $nom, $prenom, $civilite, $naissance, $email, $grade;

    function __construct($id, $uid, $nom, $prenom, $civilite, $naissance, $email, $grade)
    {

        $this->id = $id;
        $this->uid = $uid;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->civilite = $civilite;
        $this->naissance = $naissance;
        $this->email = $email;
        $this->grade = $grade;
    }
}

class administrateur {
    public $nom, $marque, $admin, $themes;
    public $bdd;

    // function __destruct()
    // {
    //     $r = mysqli_close($this->bdd);
    //     if ($r)
    //         echo "<br> ";
    //     else
    //         echo "<br> Fermeture déjà exécuté...";
    // }

// Construct de la class AdminM

    function __construct($nom) {
        $this->bdd = ConnecterBDD();
        $this->nom = $nom;
        $this->admin = array();
        $this->themes = array();
    }

    function addadmin($admin) {
        $this->admin[] = $admin;
    }

    function getadmin() {
        return $this->admin;
    }

    // Affichage final du script

    function Afficheradmin() {

        $st = "<form method='post'><table><caption>Liste des admins " . "<br>";
        $st .= "<br><tr> 
        <th>ID</th>";

        // Noms configurer pour le trie

        $champs = array(
            'a.nom' => 'Pseudo',
            'a.prenom' => 'Nom',
            'a.civilite' => 'Prenom',
            'c.libellemarque' => 'Sexe',
            'a.naissance' => 'Date de naissance',
            'a.etat' => 'Email',
            'a.stock' => 'Grade'
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
        <th colspan=2>Modifier Informations</th>
        </tr><br>
        ";

        // Affichage des informations dans le gestion admin
        foreach ($this->admin as $j => $admin) {

            $st .= "<tr><td>" . $admin->id . "</td>" .
                "<td>" . $admin->uid . "</td>" .
                "<td>" . $admin->nom . "</td>" .
                "<td>" . $admin->prenom . "</td>" .
                "<td>" . $admin->civilite . "</td>" .
                "<td>" . $admin->naissance . "</td>" .
                "<td>" . $admin->email . "</td>" .
                "<td>" . $admin->grade . "</td>";
                if ($admin->id == 3) {
                    $st .= "<td colspan=2>Admin non modifiable.</td>";
                } else {
            $st .= "<td> <a href=adminupdate.php?id=$admin->id><img src=../Images/update.png width=25></td>" .
                "<td> <a href=admindelete.php?id=$admin->id><img src=../Images/cancel.png width=25></td>";
                }
                // "<td>" . $admin->getDateadmin() . "</td><br>" .
                "</tr>";
        }
        $st .= "<tr>";
        $st .= "<th colspan=14><a href=adminupdate.php?id=0><img src=../Images/plus.png width=25>";
        $st .= "</tr>";
        $st .= "</table>";
        $st .= "</form><tr><a href='../PHP/administrateur.php'>Retour à la section Administrateur</a></tr>";



        return $st;
    }

    // Charger les données de la BDD
    function ChargerDonnee() {
        // echo "SELECT admin.id,uid,admin.nom,prenom,civilite,email$email,grade,refpromotion,etat,stock,datemiseenvente,datecreation FROM admin,categorie where admin.grade = categorie.id";


        if (isset($_REQUEST["champ"])) {
            $sens = $_REQUEST["sens"];
            $champ = $_REQUEST["champ"];
            $r = $this->bdd->query("select ". TUTIT .".". TUTITID .",". TUTITUID .",".TUTITNOM .",". TUTITPRENOM .",". TUTITCIVILITE .",". TUTITNAISSANCE .",". TUTITEMAIL .",". TUTITGRADE ." from ". TUTIT ." where ". TUTITGRADE ." > 0 order by $champ $sens");
        } else {               
            $r = $this->bdd->query("select ". TUTIT .".". TUTITID .",". TUTITUID .",". TUTITNOM .",". TUTITPRENOM .",". TUTITCIVILITE .",". TUTITNAISSANCE .",". TUTITEMAIL .",". TUTITGRADE ." from ". TUTIT ." where ". TUTITGRADE ." > 0 ");            
            
        }

        while ($d = $r->fetch_assoc()) {
            $this->addadmin(new admin($d[TUTITID], $d[TUTITUID], $d[TUTITNOM], $d[TUTITPRENOM], $d[TUTITCIVILITE],  $d[TUTITNAISSANCE], $d[TUTITEMAIL], $d[TUTITGRADE]));
        }

        // $this->addadmin($this);

    }
}



// Affichage de la class et de la function ChargerDonnee
$f = new administrateur("");
$f->ChargerDonnee();

echo $f->Afficheradmin();

?>