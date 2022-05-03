<?php
    /////////////////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    /////////////////////////////////////////////
    // Affichage de la factures après un paiement
    /////////////////////////////////////////////

include_once "../mesvaleurs.php";
  session_save_path(REPSESSION);
  session_start();

// Location de connexion si on est pas déjà connecter

  if (isset($_SESSION["id"])==false) {
    header("location:connect.php"); 
  }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Mon site E-Commerce</title>
</head>

<body>
    <form>
        <fieldset>
            <tr>
                <td><a href=../PHP/administrateur.php>Accès Administrateur</a></td><br> 
                <br><td><a href=Index.php>Accès Utilisateur</a></td> 
                    
            </tr> 
        </fieldset>
    </form> 
</body> 

<footer>
</footer>
</html>