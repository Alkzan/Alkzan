<?php

    include_once "../mesvaleurs.php";
    session_save_path(REPSESSION);
    session_start();
    $idsession = session_id();

?>

<?php 

    session_unset();
    header("location:Index.php");

?>