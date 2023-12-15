<?php
include "base.php";
session_start(); // Start the session

if(isset($_SESSION['utilisateur_id'])){
    // Remove the content of $_SESSION['utilisateur_id']
    unset($_SESSION['utilisateur_id']);
}

// Redirect the user to the login page
header("Location: connexion.php");
exit();