<?php

    // $REPSESSION = "../utilisateurs";
    // $SERVEUR = "localhost";
    // $UID = "root";
    // $PWD = "";
    // $BDD = "ecommerce";

    define("REPSESSION", "../utilisateurs");
    define("SERVEUR", "localhost");
    define("UID", "root");
    define("PWD", "");
    define("BDD", "ecommerce");

    // Table Panier

    define("TPAN", "panier");
    define("TPANID", "id");
    define("TPANIDS", "idsession");
    define("TPANQTE", "qte");
    define("TPANREFA", "refarticle");
    define("TPANDH", "dateheure");

    // Table Article

    define("TART", "article");
    define("TARTID", "id");
    define("TARTTIT", "titre");
    define("TARTDESC", "description");
    define("TARTPRIX", "prix");
    define("TARTIMG", "images");
    define("TARTREFM", "refmarque");
    define("TARTREFC", "refcategorie");
    define("TARTREFP", "refpromotion");
    define("TARTETAT", "etat");
    define("TARTSTOCK", "stock");
    define("TARTDMEEV", "datemiseenvente");
    define("TARTDC", "datecreation");

    // Table Categorie

    define("TCAT", "categorie");
    define("TCATID", "id");
    define("TCATPHOTO", "photo");
    define("TCATLIBELLE", "libelle");

    // Table Marque

    define("TMARQUE", "marque");
    define("TMARQUEID", "id");
    define("TMARQUELOGO", "logo");
    define("TMARQUELIBELLEM", "libellemarque");

    // Table Facture 

    define("TFAC", "facture");
    define("TFACID", "id");
    define("TFACDATEF", "datefacture");
    define("TFACREFC", "refclient");
    define("TFACQTE", "qte");
    define("TFACREFA", "refarticle");
    define("TFACPRIX", "prix");
    define("TFACPRIXT", "prixtotal");
    define("TFACNOM", "nom");
    define("TFACPRENOM", "prenom");
    define("TFACGENRE", "genre");
    define("TFACADRESSEF", "adressefac");
    define("TFACPOSTALF", "postalfac");
    define("TFACVILLEF", "villefac");
    define("TFACEMAIL", "email");
    define("TFACTEL", "tel");
    define("TFACVILLELIV", "villeliv");
    define("TFACADRESSELIV", "adresseliv");
    define("TFACPOSTALLIV", "postalliv");

    // Table Detail Facture 

    define("TDETAILF", "detailfacture");
    define("TDETAILFID", "id");
    define("TDETAILFIMAGESA", "imagesart");
    define("TDETAILFREFA", "refarticle");
    define("TDETAILFREFF", "reffacture");
    define("TDETAILFPRIXV", "prixvente");
    define("TDETAILFQTE", "qte");
    define("TDETAILD", "datefacture");

    // Table Utilisateur 

    define("TUTIT", "utilisateur");
    define("TUTITID", "id");
    define("TUTITUID", "uid");
    define("TUTITNOM", "nom");
    define("TUTITPRENOM", "prenom");
    define("TUTITNAISSANCE", "naissance");
    define("TUTITCIVILITE", "civilite");
    define("TUTITEMAIL", "email");
    define("TUTITTEL", "telephone");
    define("TUTITVILLE", "ville");
    define("TUTITADRESSE", "adresse");
    define("TUTITADRESSEP", "adressepostal");
    define("TUTITPSW", "psw");
    define("TUTITTENTATIVE", "tentative");
    define("TUTITACCES", "acces");
    define("TUTITCONNEXION", "connexion");
    define("TUTITGRADE", "grade");
        
    function ConnecterBDD() {
        // global $SERVEUR,$UID,$PWD,$BDD;
        $cn = mysqli_connect(SERVEUR, UID, PWD, BDD);
        if ($cn == false) {
            echo "Problème de connexion à la base de donnée";
            exit;
        }
        mysqli_query($cn,"SET NAME UTF8");
        mysqli_query($cn,"SET CHARACTER SET UTF8");
        return $cn;
    }
    
?>