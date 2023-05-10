<?php
// Initialisation
require 'conn_bdd.php';
include 'base.php';
if(!isset($_SESSION)){
    session_start();// Démarrer une session pour l'utilisateur
}
	// On prends les données de la bdd si l'utilisateur est connecté sinon on l'envoi vers la page de connexion
	if(isset($_SESSION["utilisateur_id"])){
		$id = $_SESSION["utilisateur_id"];

		// On stocke les infos de l'utilisateur dans le tableau donnees_bdd
		$assertion = $conn_bdd->prepare("SELECT titre, description");
		$assertion->execute(["id" => $id]);
		$donnees_utilisateur = $assertion->fetch();
		$assertion = $conn_bdd->prepare("SELECT categorie.id, categorie.description FROM categorie JOIN utilisateur ON Categorie_id = categorie.id WHERE utilisateur.id = :id;");
		$donnees_categorie = $assertion->fetch();

		// Code pour insérer les données dans la base de données
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Récupérer les données du formulaire en les filtrant avec filter_input()
		$donnees = [
			'id' => $id,
			'titre' => filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_EMAIL),
			'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_EMAIL),];


		// Exécuter la requête
		$traitement = $assertion->execute($donnees);
		if(!$traitement){
			echo("Erreur: " . print_r($assertion->errorInfo(), true));
		}else{
			echo("<script>alert('Modifications effectuées.')</script>");
		}
	}
}else{
	header("Location: connexion.php");
}
?>
<body>
    <div class="form-container">
		<form action="profil.php" method="POST" class="form">
            <h1 class="register-h1">Les projets</h1>
            <input type="text" name="titre" value="<?=$donnees_projet["titre"]?>" placeholder="description d'utilisateur" class="form-input" id="form-user" required>
            <input type="text" name="description" value="<?=$donnees_projet["description"]?>" placeholder="description" class="form-input" id="form-surname" required>
			<textarea type="text" name="description" placeholder="Ecrivez votre bio ici" class="form-input comment-textarea"><?=$donnees_utilisateur["description"]?></textarea>
		<button type="submit" class="form-button">Retour</button>
        </form>
    </div>
</body>