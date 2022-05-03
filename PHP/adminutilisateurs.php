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
<meta charset="UTF-8" />
<link rel="stylesheet" href="../style.css">
<?php

class utilisateur {
    public $id, $uid, $nom, $prenom, $naissance, $civilite, $email, $telephone, $tentative, $acces, $connexion, $grade;

    function __construct($id, $uid, $nom, $prenom, $naissance, $civilite, $email, $telephone, $tentative, $acces, $connexion, $grade)
    {

        $this->id = $id;
        $this->uid = $uid;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->naissance = $naissance;
        $this->civilite = $civilite;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->tentative = $tentative;
        $this->acces = $acces;
        $this->acces = $acces;
        $this->grade = $grade;
    }
}

class utilisateursall {
    public $nom, $marque, $utilisateur, $themes;
    public $bdd;

    // function __destruct()
    // {
    //     $r = mysqli_close($this->bdd);
    //     if ($r)
    //         echo "<br> ";
    //     else
    //         echo "<br> Fermeture déjà exécuté...";
    // }

// Construct de la class utilisateur

    function __construct($nom) {
        $this->bdd = ConnecterBDD();
        $this->nom = $nom;
        $this->utilisateur = array();
        $this->themes = array();
    }

    function addutilisateur($utilisateur) {
        $this->utilisateur[] = $utilisateur;
    }

    function getutilisateur() {
        return $this->utilisateur;
    }

    // Affichage final du script

    function Afficherutilisateur() {

        $st = "<form method='post'><table><caption>Liste des utilisateurs " . "<br>";
        $st .= "<br><tr> 
        <th>ID</th>";

        // Noms configurer pour le trie

        $champs = array(
            'a.pseudo' => 'Pseudo',
            'a.nom' => 'Nom',
            'a.prenom' => 'Prenom',
            'a.naissance' => 'Naissance',
            'a.civilite' => 'Sexe',
            'c.email' => 'Email',
            'a.telephone' => 'Telephone',
            'a.tentative' => 'Tentative',
            'a.acces' => 'Acces',
            'a.Connexion' => 'Connexion',
            'a.grade' => 'Grade'
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

        // Affichage des informations dans le gestion utilisateur
        foreach ($this->utilisateur as $j => $utilisateur) {

            $st .= "<tr><td>" . $utilisateur->id . "</td>" .
                "<td>" . $utilisateur->uid . "</td>" .
                "<td>" . $utilisateur->nom . "</td>" .
                "<td>" . $utilisateur->prenom . "</td>" .
                "<td>" . $utilisateur->naissance . "</td>" .
                "<td>" . $utilisateur->civilite . "</td>" .
                "<td>" . $utilisateur->email . "</td>" .
                "<td>" . $utilisateur->telephone . "</td>" .
                "<td>" . $utilisateur->tentative . "</td>" .
                "<td>" . $utilisateur->acces . "</td>" .
                "<td>" . $utilisateur->connexion . "</td>" .
                "<td>" . $utilisateur->grade . "</td>" .
                "<td> <a href=utilisateurupdate.php?id=$utilisateur->id><img src=../Images/update.png width=25></td>" .
                "<td> <a href=utilisateurdelete.php?id=$utilisateur->id><img src=../Images/cancel.png width=25></td>" .
                // "<td>" . $utilisateur->getDateutilisateur() . "</td><br>" .
                "</tr>";
        }
        $st .= "<tr>";
        $st .= "<th colspan=14><a href=utilisateurupdate.php?id=0><img src=../Images/plus.png width=25>";
        $st .= "</tr>";
        $st .= "</table>";
        $st .= "</form><tr><a href='../PHP/administrateur.php'>Retour à la section Administrateur</a></tr>";



        return $st;
    }

    // Charger les données de la BDD
    function ChargerDonnee() {
        // echo "SELECT utilisateur.id,uid,utilisateur.nom,prenom,civilite,email$email,grade,refpromotion,etat,stock,datemiseenvente,datecreation FROM utilisateur,categorie where utilisateur.grade = categorie.id";


        if (isset($_REQUEST["champ"])) {
            $sens = $_REQUEST["sens"];
            $champ = $_REQUEST["champ"];
            $r = $this->bdd->query("select ". TUTIT .".". TUTITID .",". TUTITUID .",".TUTITNOM .",". TUTITPRENOM .",". TUTITNAISSANCE .",". TUTITCIVILITE .",". TUTITEMAIL .",". TUTITTEL .",". TUTITTENTATIVE .",". TUTITACCES .",". TUTITCONNEXION .",". TUTITGRADE ." from ". TUTIT ." where ". TUTITGRADE ." = 0 order by $champ $sens");
        } else {               
            $r = $this->bdd->query("select ". TUTIT .".". TUTITID .",". TUTITUID .",". TUTITNOM .",". TUTITPRENOM .",".TUTITNAISSANCE .",". TUTITCIVILITE .",". TUTITEMAIL .",". TUTITTEL .",". TUTITTENTATIVE .",". TUTITACCES .",". TUTITCONNEXION .",". TUTITGRADE ." from ". TUTIT ." where ". TUTITGRADE ." = 0 ");            
            
        }

        while ($d = $r->fetch_assoc()) {
            $this->addutilisateur(new utilisateur($d[TUTITID], $d[TUTITUID], $d[TUTITNOM], $d[TUTITPRENOM], $d[TUTITNAISSANCE], $d[TUTITCIVILITE], $d[TUTITEMAIL], $d[TUTITTEL], $d[TUTITTENTATIVE], $d[TUTITACCES], $d[TUTITCONNEXION], $d[TUTITGRADE]));
        }

        // $this->addutilisateur($this);

    }
}



// Affichage de la class et de la function ChargerDonnee
$f = new utilisateursall("");
$f->ChargerDonnee();

echo $f->Afficherutilisateur();

?>