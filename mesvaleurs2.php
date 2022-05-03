<?php
    //////////////////////////////////
    // Realiser par Tony Parizot
    // Dernière modification 6/01/2022
    //////////////////////////////////

    // $REPSESSION = "../utilisateurs";
    // $SERVEUR = "localhost";
    // $UID = "root";
    // $PWD = "";
    // $BDD = "ecommerce";

    define("REPSESSION", "../utilisateurs");
    define("SERVEUR", "localhost");
    define("UID", "root");
    define("PWD", "");
    define("BDD", "ecommerce2");

    // Table Panier

    define("TPAN", "paniers");
    define("TPANID", "ids");
    define("TPANIDS", "idsessions");
    define("TPANREFA", "refarticles");
    define("TPANQTE", "qtes");
    define("TPANDATEH", "dateheures");

    // Table Article

    define("TART", "articles");
    define("TARTID", "ids");
    define("TARTTIT", "titres");
    define("TARTDESC", "descriptions");
    define("TARTPRIX", "prixs");
    define("TARTPRIXT", "prixtotals");
    define("TARTIMG", "imagess");
    define("TARTREFM", "refmarques");
    define("TARTREFC", "refcategories");
    define("TARTREFP", "refpromotions");
    define("TARTETAT", "etats");
    define("TARTSTOCK", "stocks");
    define("TARTDMEEV", "datemiseenventes");
    define("TARTDC", "datecreations");

    // Table Categorie

    define("TCAT", "categories");
    define("TCATID", "ids");
    define("TCATPHOTO", "photos");
    define("TCATLIBELLE", "libelles");

    // Table Marque

    define("TMARQUE", "marques");
    define("TMARQUEID", "ids");
    define("TMARQUELOGO", "logos");
    define("TMARQUELIBELLEM", "libellemarques");

    // Table Facture 

    define("TFAC", "factures");
    define("TFACID", "ids");
    define("TFACDATEF", "datefactures");
    define("TFACREFC", "refclients");
    define("TFACQTE", "qtes");
    define("TFACREFA", "refarticles");
    define("TFACPRIX", "prixs");
    define("TFACPRIXT", "prixtotals");
    define("TFACNOM", "noms");
    define("TFACPRENOM", "prenoms");
    define("TFACGENRE", "genres");
    define("TFACADRESSEF", "adressefacs");
    define("TFACPOSTALF", "postalfacs");
    define("TFACVILLEF", "villefacs");
    define("TFACEMAIL", "emails");
    define("TFACTEL", "tels");
    define("TFACVILLELIV", "villelivs");
    define("TFACADRESSELIV", "adresselivs");
    define("TFACPOSTALLIV", "postallivs");

    // Table Detail Facture 

    define("TDETAILF", "detailfactures");
    define("TDETAILFID", "ids");
    define("TDETAILFIMAGESA", "imagesarts");
    define("TDETAILFREFA", "refarticles");
    define("TDETAILFREFF", "reffactures");
    define("TDETAILFPRIXV", "prixventes");
    define("TDETAILFQTE", "qtes");

    // Table Utilisateur 

    define("TUTIT", "utilisateurs");
    define("TUTITID", "ids");
    define("TUTITUID", "uids");
    define("TUTITNOM", "noms");
    define("TUTITPRENOM", "prenoms");
    define("TUTITNAISSANCE", "naissances");
    define("TUTITCIVILITE", "civilites");
    define("TUTITEMAIL", "emails");
    define("TUTITTEL", "telephones");
    define("TUTITVILLE", "villes");
    define("TUTITADRESSE", "adresses");
    define("TUTITADRESSEP", "adressepostals");
    define("TUTITPSW", "psws");
    define("TUTITTENTATIVE", "tentatives");
    define("TUTITACCES", "access");
    define("TUTITCONNEXION", "connexions");
    define("TUTITGRADE", "grade");
        
    // Connexion à la BDD
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