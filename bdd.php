<?php

$cn = mysqli_connect("localhost", "root", "", "ecommerce2");
if ($cn == false) {
    echo "Problème de connexion à la base de donnée";
    exit;
}

mysqli_query($cn,"SET NAME UTF8");
mysqli_query($cn,"SET CHARACTER SET UTF8");

?>