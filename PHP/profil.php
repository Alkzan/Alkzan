<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////
    // Profil
    //////////////////////////////////

include_once "../mesvaleurs.php";
session_save_path(REPSESSION);
session_start();
$idsession = session_id();

// Connexion à la BDD via la function du Mesvaleurs.php
$cn = ConnecterBDD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <link rel="stylesheet" href="../CSS/Index3.css">
    <script src="https://kit.fontawesome.com/21149d0622.js" crossorigin="anonymous"></script>
    <script src="../index.js" defer></script>
    <title>Mon site e-commerce</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <h2>Accueil de mon site e-commerce</h2>
   
    <ul>

    <li><a href='administrateur.php'>Administration</a></li>
    <li><a href='logout.php'>Se déconnecter</a></li>

    </ul>

</body>

</html>