<?php
// Initialisation
require 'conn_bdd.php';
include 'base.php';
if (!isset($_SESSION)) {
    session_start(); // Démarrer une session pour l'utilisateur
}

// On attends que le formulaire sois rempli
if(isset($_POST['mail']) && isset($_POST['mot_de_passe'])) {
	// Code pour insérer les données dans la base de données
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Récupérer les données du formulaire en les filtrant avec filter_input()
		$donnees = [
			"pseudonyme" => filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_EMAIL),
			"nom" => filter_input(INPUT_POST, "nom", FILTER_UNSAFE_RAW),
			"prenom" => filter_input(INPUT_POST, "prenom", FILTER_UNSAFE_RAW),
			"telephone" => filter_input(INPUT_POST, "telephone", FILTER_UNSAFE_RAW),
			"mail" => filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL),
			"mot_de_passe" => filter_input(INPUT_POST, "mot_de_passe", FILTER_SANITIZE_EMAIL),
			"confirmation" => filter_input(INPUT_POST, "confirmation", FILTER_SANITIZE_EMAIL),
		];
	
		// Vérifier que le mot de passe et la confirmation sont identiques
		if($donnees["mot_de_passe"] != $confirmation) {
			echo("<script>alert('Les mots de passe doivent être identiques')</script>");
		} else {
			// Hasher le mot de passe avec l'algorithme bcrypt
			$hash = password_hash($donnees["mot_de_passe"], PASSWORD_DEFAULT);
	
			// Préparer la requête SQL pour insérer les données dans la base de données
			$assertion = $conn_bdd->prepare("INSERT INTO utilisateur (pseudonyme, nom, prenom, telephone, mail, mot_de_passe) VALUES (:pseudonyme, :nom, :prenom, :telephone, :mail, :hash)");
	
			// Exécuter la requête
			$traitement = $assertion->execute(["pseudonyme" => $donnees["pseudonyme"], "nom" => $donnees["nom"], "prenom" => $donnees["prenom"], "telephone" => $donnees["telephone"], "mail" => $donnees["mail"], "hash" => $hash]);
			if(!$traitement){
				echo("Connexion échouée: " . print_r($assertion->errorInfo(), true));
			}
			else{
				echo("<script>alert('Inscription effectuée, cliquez sur se connecter pour vous connecter.')</script>");
			}
		}
	}
}
?>


<body>
	<div class="form-container">
			<form action="inscription.php" method="POST" class="form">
				<h1 class="register-h1">Créer un compte</h1>
				<input type="hidden" name="token" value="<?= $token; ?>"> <!-- On stocke le jeton CSRF dans le formulaire en caché -->
				<input type="text" name="pseudonyme" placeholder="Nom d'utilisateur" class="form-input" id="form-user" required>
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