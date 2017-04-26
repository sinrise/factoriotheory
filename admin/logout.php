<?php require_once("../config/config.php"); ?>
<?php	
    $session->logout();
    redirect_to("index.php");
?>