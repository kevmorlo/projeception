<?php

if(!isset($_SESSION)){
    // Arrêter la session de l'utilisateur
    session_abort();

    // Envoyer l'utilisateur à la page de connexion
    header("Location: connexion.php");
}
require "conn_bdd.php"; // Connexion à la base de données
include "base.php";