<?php
// Ce programme permet de se connecter à la base de données.
// Ne pas toucher
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'", "PDO::ERRMODE_EXCEPTION"
  ];
// Remplacer au besoin
$nom_de_domaine = "localhost";
$base_de_donnees = "villes_francaises";
$utilisateur = "root";
$mot_de_passe = "";
// Ne pas toucher
$dsn = "mysql:host=$nom_de_domaine;dbname=$base_de_donnees";
$conn_bdd = new PDO($dsn, $utilisateur, $mot_de_passe, $options);
if (!$conn_bdd) { // En cas d'échec connexion à la BDD, on affiche une erreur
  die("Connexion échouée: " . print_r($conn_bdd->errorInfo(), true));
}