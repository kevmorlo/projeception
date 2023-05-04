<?php
// Initialisation
require 'conn_bdd.php';
include 'base.php';

?>
<body>
	<div class="form-container">
			<form action="{{ url_for('traitement_register') }}" method="POST" class="form">
				<h1 class="register-h1">Créer un compte</h1>
				<input type="text" name="prenom" placeholder="Prénom" class="form-input" id="form-name" required>
				<input type="text" name="nom" placeholder="Nom" class="form-input" id="form-surname" required>
				<input type="tel" name="telephone" placeholder="Téléphone" class="form-input" required>
				<input type="email" name="email" placeholder="Adresse email" class="form-input" required>
				<input type="password" name="mot_de_passe" placeholder="Mot de passe" class="form-input" required>
				<input type="password" name="mdp_confirm" placeholder="Confirmation mot de passe" class="form-input" required>
				<label for="select" class="form-label">Situation :</label>
				<select name="categorie" placeholder="Situation" class="form-input" id="form-categorie" required>
					<option value="B1">B1(SN1)</option>
					<option value="B2">B2(SN2)</option>
					<option value="B3">B3(CDA/ASRBD/DevOps/IA)</option>
					<option value="B4">B4(I1)</option>
					<option value="B5">B5(I2)</option>
					<option value="Intervenant">Intervenant</option>
					<option value="Equipe pédagogique">Equipe pédagogique</option>
					<option value="Autre">Autre</option>
				</select>
				<button type="submit" class="form-button">Créer un compte</button>
				<a href="connexion.php" class="a-redirect" title="Se connecter" required>Se connecter</a>
			</form>
		</div>
</body>
</html>
<?php

// Code pour insérer les données dans la base de données
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Récupérer les données du formulaire
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$motdepasse = $_POST['motdepasse'];
	$confirmation = $_POST['confirmation'];

	// Vérifier que le mot de passe et la confirmation sont identiques
	if($motdepasse != $confirmation) {
		echo("<script>alert('Le mot de passe et la confirmation doivent être identiques')</script>");
	} else {
		// Hasher le mot de passe avec l'algorithme bcrypt
		$hash = password_hash($motdepasse, PASSWORD_DEFAULT);

		// Préparer la requête SQL pour insérer les données dans la base de données
		$sql = "INSERT INTO utilisateurs (nom, prenom, email, motdepasse) VALUES ('$nom', '$prenom', '$email', '$hash')";

		// Exécuter la requête SQL
		if (mysqli_query($conn, $sql)) {
			echo("<script>alert('Inscription réussie !')</script>");
		} else {
			echo("<script>alert('Inscription réussie !')</script>");
		}
	}
}
