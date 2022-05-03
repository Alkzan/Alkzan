<?php
    ////////////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    ////////////////////////////////////////
    // Gestion Administrateur
    // Article / Categorie / Marque / Panier
    // Admin / Utilisateurs
    ////////////////////////////////////////

  include_once "../mesvaleurs.php";
  session_save_path("../utilisateurs");
  session_start();

  // Location de connexion si on est pas déjà connecter
  if (isset($_SESSION["id"])==false) {
    header("location:connect.php"); 
  }

$cn = ConnecterBDD();

  
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Mon site E-Commerce</title>
</head>
<style>
    body {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    a {
        text-decoration: none;
        color: black;
        font-style: italic;
    }
</style>

<body>
    <form>
        <fieldset>
            <legend>Administrateur</legend>
                <?php
                $uid = $_SESSION["uid"];
                $id = $_SESSION["id"];
                $grade = $_SESSION[TUTITGRADE];
                
                echo "Bonjour $uid <br>";
                ?>
            <h3>Modifier un produit</h3>

            <tr>
                <td>
                    <a href=adminmarque.php>Modifier Marque</a> | 
                    <a href=admincategorie.php>Modifier Categorie</a> | 
                    <a href=adminarticle.php>Modifier Article</a> |
                    <a href=adminpanier.php>Modifier Panier</a> | 
                    <a href=adminfacture.php>Modifier Facture</a><br>
                    <br>-------------------------------------------------------<br>
                    <?php
                    if ($grade == 2) {
                        echo " <br><a href=admin.php>Gestion des Administrateurs</a> |
                        <a href=adminutilisateurs.php>Gestion des Utilisateurs</a> ";
                    } else if ($grade == 1) {
                        echo "<a href=adminutilisateurs.php>Gestion des Utilisateurs</a> ";
                    } else if ($grade == 3){
                        echo "Vous n'avez pas l'autorisation pour cette modification.";
                    } else {
                        echo "Vous n'avez pas l'autorisation pour cette modification.";
                    }

                    ?> 
                </td>
            </tr> 
        </fieldset>
        <br><a href=index.php>Retour</a><br>
    </form> 
</body> 

<footer>
</footer>
</html>