<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Page d'accueil
    //////////////////////////////////

include_once "../mesvaleurs.php";
session_save_path(REPSESSION);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/index3.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <title>Mon site e-commerce</title>
</head>

<body>
<header>
    <?php
        // Navbar si la personne n'est pas connectée
        if (isset($_SESSION["id"]) == false) {
            echo "
                <ul>
                <li><a href='index3.php'>Accueil</a></li>
                <li><a href='shop.php'>Boutique</a></li>
                <li><a href=''>Contact</a></li>
                <li><a href=''>A propos</a></li>
                <li><a href=''>Promotions</a></li>
                <li><a target='iiframe' href='panier.php'><img src='../images/panier.png' width='20' /></a></li>
                <li><a href='connect.php'><img src='../images/connexion.png' width='20' /></a></li>
                <li><a href='inscription.php'><img src='../images/connexion.png' width='20' /></a></li>
                </ul>
            ";
        } else {
            // Navbar si la personne est connectée
            echo "
                <ul>
                <li><a href='index3.php'>Accueil</a></li>
                <li><a href='shop.php'>Boutique</a></li>
                <li><a href=''>Contact</a></li>
                <li><a href=''>A propos</a></li>
                <li><a href=''>Promotions</a></li>
                <li><a target='iiframe' href='panier.php'><img src='../images/panier.png' width='20' /></a></li>
                <li><a href='profil.php'><img src='../images/connexion.png' width='20' /></a></li>
                </ul>
            ";
        }
        ?>
</header>
<main>
    <div class='main'>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    <h2>Accueil de mon site e-commerce</h2>
    </div>
</main>
<footer>
        Tous droits réservés © E-Commerce, 2021 / 2022
</footer>
</body>

</html>