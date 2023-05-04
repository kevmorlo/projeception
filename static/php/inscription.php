<?php
// Initialisation
require 'conn_bdd.php';
include 'base.php';

// On attends que le formulaire sois rempli
if(isset($_POST['mail']) && isset($_POST['mot_de_passe'])) {
	// Code pour insérer les données dans la base de données
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Récupérer les données du formulaire
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$telephone = $_POST['telephone'];
		$mail = $_POST['mail'];
		$motdepasse = $_POST['mot_de_passe'];
		$confirmation = $_POST['mdp_confirm'];
		$categorie = $_POST['categorie'];
	
		// Vérifier que le mot de passe et la confirmation sont identiques
		if($motdepasse != $confirmation) {
			echo("<script>alert('Le mot de passe et la confirmation doivent être identiques')</script>");
		} else {
			// Hasher le mot de passe avec l'algorithme bcrypt
			$hash = password_hash($motdepasse, PASSWORD_DEFAULT);
	
			// Préparer la requête SQL pour insérer les données dans la base de données
			$assertion = $conn_bdd->prepare("INSERT INTO utilisateur (nom, prenom, telephone, mail, mot_de_passe) VALUES (:nom, :prenom, :telephone, :mail, :hash)");
	
			// Exécuter la requête
			$traitement = $assertion->execute(["nom" => $nom, "prenom" => $prenom, "telephone" => $telephone, "mail" => $mail, "hash" => $hash]);
			if(!$traitement){
				echo("Connexion échouée: " . print_r($assertion->errorInfo(), true));
			}
		}
	}
}
?>

<body>
	<div class="form-container">
			<form action="inscription.php" method="POST" class="form">
				<h1 class="register-h1">Créer un compte</h1>
				<input type="text" name="prenom" placeholder="Prénom" class="form-input" id="form-name" required>
				<input type="text" name="nom" placeholder="Nom" class="form-input" id="form-surname" required>
				<input type="tel" name="telephone" placeholder="Téléphone" class="form-input">
				<input type="mail" name="mail" placeholder="Adresse mail" class="form-input" required>
				<input type="password" name="mot_de_passe" placeholder="Mot de passe" class="form-input" required>
				<input type="password" name="mdp_confirm" placeholder="Confirmation mot de passe" class="form-input" required>
				<button type="submit" class="form-button">Créer un compte</button>
				<a href="connexion.php" class="a-redirect" title="Se connecter" required>Se connecter</a>
			</form>
		</div>
</body>
</html>