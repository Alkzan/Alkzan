<?php
include_once "../mesvaleurs.php";
session_save_path($REPSESSION);
session_start();
$idsession = session_id();
    // $_SESSION['nom'] = "Admin";
    // $_SESSION["prenom"] = "Adminn";

$cn = ConnecterBDD();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/paiement.css">
    <title>Paiement PHPTAR</title>
</head>

<body>

    <?php

    if (isset($_REQUEST["id"]))
        $id = $_REQUEST["id"];
        else
            $id = 0;

   
        class panier {
        public $nom, $prenom, $genre, $email, $tel, $villeliv, $adresseliv, $postalliv, $villefac, $adressefac, $postalfac;

        function __construct($nom, $prenom, $genre, $email, $tel, $villeliv, $adresseliv, $postalliv, $villefac, $adressefac, $postalfac) {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->genre = $genre;
            $this->email = $email;
            $this->tel = $tel;
            $this->villeliv = $villeliv;
            $this->adresseliv = $adresseliv;
            $this->postalliv = $postalliv;
            $this->villefac = $villefac;
            $this->adressefac = $adressefac;
            $this->postalfac = $postalfac;
        }
    }

    class paiementM {
        public $titre, $facture;
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
            $this->facture = array();
        }
        function addfacture($facture)
        {
            $this->facture[] = $facture;
        }

        function getfacture()
        {
            return $this->facture;
        }

        function Afficherpanier() {

            $st = "<form method='post'><table><caption>Liste des factures " . "<br>";
            $st .= "<tr> 
            <td>ID</td>
            <td>Images</td>
            <td>Titre</td>
            <td>Description</td>
            <td>Prix</td>
            <td>Marque</td>
            <td>Categorie</td>
            <td>Etat</td>
            <td>Stock</td>
            <td>Promotion</td>
            <td>Mise En Ligne</td>
            <td>Création</td>
            <td colspan=2>Modifier Informations</td>
            <></tr><br>
            ";
    
            foreach ($this->facture as $j=>$paiement) {
    
                $st .= "<td><label>Nom : </label><input class='in' type='text' name='nom' placeholder='Entrez votre nom' value=" . $paiement->nom . "></td><br>";
                $st .= "<td><label>Prénom : </label><input class='in' type='text' name='prenom' placeholder='Entrez votre prenom' value=" . $paiement->prenom . "></td><br>";
                $st .= "<td><label>Civilité : </label><input class='in' type='text' name='genre' placeholder='Entrez votre naissance' value=" . $paiement->genre . "></td><br>";
                $st .= "<td><label>Civilité : </label><input class='in' type='text' name='email' placeholder='Entrez votre email' value=" . $paiement->email . "></td><br>";
                $st .= "<td><label>Civilité : </label><input class='in' type='text' name='tel' placeholder='Entrez votre numéro de téléphone' value=" . $paiement->tel . "></td><br>";
                $st .= "<td><h3>Informations livraison</h3></td><br>";
                $st .= "<td><label>Ville : </label><input class='in' type='text' name='villeliv' placeholder='Entrez votre ville' value=" . $paiement->villeliv . "></td><br>";
                $st .= "<td><label>Code Postal : </label><input class='in' type='text' name='postalliv' placeholder='Entrez votre code postal' value=" . $paiement->postalliv . "></td><br>";
                $st .= "<td><label>Adresse : </label><input class='in' type='text' name='adresseliv' placeholder='Entrez votre adresse' value=" . $paiement->adresseliv . "></td><br>";
                $st .= "<td><h3>Informations Facturation</h3></td><br>";
                $st .= "<td><label>Ville : </label><input class='in' type='text' name='villefac' placeholder='Entrez votre ville' value=" . $paiement->villefac . "></td><br>";
                $st .= "<td><label>Code Postal : </label><input class='in' type='text' name='postalfac' placeholder='Entrez votre code postal' value=" . $paiement->postalfac . "></td><br>";
                $st .= "<td><label>Adresse : </label><input class='in' type='text' name='adressefac' placeholder='Entrez votre adresse' value=" . $paiement->adressefac . "></td><br>";
            }
            $st .= "<tr>";
            $st .= "<th colspan=14><a href=adminarticleupdate.php?id=0><img src=../images/plus.png width=25>";
            $st .= "</tr>";
            $st .= "</table>";
            $st .= "</form><tr><a href='Index.php'>Retour à la section Administrateur</a></tr>";
                    
                    if (isset($_REQUEST["commands"])) {
                
                        $this->cn = ConnecterBDD();
                        if (isset($_REQUEST["id"]))
                            $id = $_REQUEST["id"];
                        else
                            $id = 0;

                        $idsession = session_id();     
                        $valdate = Date("Y/m/j G:i");

                        mysqli_query($this->cn, "insert into facture (`datefacture`) VALUES ('$valdate')");
                        $idfacture  = mysqli_insert_id($this->cn);
                        $r = mysqli_query($this->cn,"select * from panier a,article b where a.refarticle=b.id and idsession='$idsession' and qte>0");
                        while($d = mysqli_fetch_assoc($r)) {
                            $refarticle = $d["refarticle"];
                            $prix = $d["prix"];
                            $qte = $d["qte"];
                            echo "insert into detailfacture (refarticle,reffacture,prixvente,qte) values ('$refarticle','$idfacture','$prix','$qte')";
                            // mysqli_query($this->cn,"insert into detailfacture (refarticle,reffacture,prixvente,qte) values ('$refarticle','$idfacture','$prix','$qte')");
                            echo "update article set stock=stock-'$qte' where id='$refarticle'";
                            // mysqli_query($this->cn,"update article set stock=stock-'$qte' where id='$refarticle'");
                        }
                        mysqli_query($this->cn,"delete from panier where idsession='$idsession'");
                        
                        // header("location:facture.php");
                    }
                return $st;
                 
        }


        function ChargerDonnee() {

            if (isset($_REQUEST["id"]))
                $id = $_REQUEST["id"];
            else
                $id = 0;
                
            $r = mysqli_query($this->cn, "select nom,prenom,genre,email,tel,villeliv,adresseliv,postalliv,villefac,adressefac,postalfac from facture where id='$id'");
            while ($d = mysqli_fetch_assoc($r)) {
                $this->addfacture(new panier($d["nom"], $d["prenom"], $d["genre"], $d["email"], $d["tel"], $d["villeliv"], $d["adresseliv"], $d["postalliv"], $d["villefac"], $d["adressefac"], $d["postalfac"]));
            }


        }
    }




    $f = new paiementM("");
    $f->ChargerDonnee();

    echo $f->Afficherpanier();


    ?>
</body>

</html>