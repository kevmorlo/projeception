
<?php
// Initialisation
require 'conn_bdd.php';
include 'base.php';
if(!isset($_SESSION)){
    session_start();// Démarrer une session pour l'utilisateur
}
?>
<body>
	<div class="form-container">
			<form action="creation_projet.php" method="POST" class="form">
				<h1 class="register-h1">Créer un projet</h1>
				<input type="text" name="titre" placeholder="Titre" class="form-input" id="form-user" required>
				<input type="text" name="description" placeholder="Description" class="form-input" id="form-name" required>
				<button type="submit" class="form-button">Créer un projet</button>
				<a href="afficher_projet.php" class="a-redirect" title="Retour" required>Retour</a>
			</form>
		</div>
</body>
</html>
	
<?php

// Attendre que le formulaire soit soumis
if (isset($_POST['titre']) && isset($_POST['description']) && isset($_SESSION["utilisateur_id"])) {
    // Récupérer les informations du projet soumises par l'utilisateur
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $utilisateur_id = $_SESSION["utilisateur_id"];

    // Préparer la requête pour créer un nouveau projet
    $requete_projet = $conn_bdd->prepare("INSERT INTO projet (titre, description) VALUES (:titre, :description)");

    // Exécuter la requête pour créer un nouveau projet
    $requete_projet->execute(array(
        'titre' => $titre,
        'description' => $description
    ));

    // Récupérer l'identifiant du projet qui vient d'être créé
    $projet_id = $conn_bdd->lastInsertId();

    // Préparer la requête pour ajouter l'association utilisateur-projet
    $requete_assoc = $conn_bdd->prepare("INSERT INTO utilisateurs_du_projet (Utilisateur_id, Projet_id) VALUES (:utilisateur_id, :projet_id)");

    // Exécuter la requête pour ajouter l'association utilisateur-projet
    $requete_assoc->execute(array(
        'utilisateur_id' => $utilisateur_id,
        'projet_id' => $projet_id
    ));

    // Rediriger l'utilisateur vers la page d'accueil
    header("Location: index.php");
    exit();
}



?>