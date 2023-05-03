
<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
</head>
<body>
	<h2>Inscription</h2>
	<form action="inscription.php" method="post">
		<label for="nom">Nom :</label>
		<input type="text" id="nom" name="nom"><br>

		<label for="prenom">Prénom :</label>
		<input type="text" id="prenom" name="prenom"><br>

		<label for="email">Email :</label>
		<input type="email" id="email" name="email"><br>

		<label for="motdepasse">Mot de passe :</label>
		<input type="password" id="motdepasse" name="motdepasse"><br>
    
		<label for="confirmation">Confirmation du mot de passe :</label>
		<input type="password" id="confirmation" name="confirmation"><br>

		<input type="submit" value="S'inscrire">
	</form>
</body>
</html>
<?php
// Vérifier si le formulaire a été soumis
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Récupérer les données du formulaire
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$motdepasse = $_POST['motdepasse'];
}
// Connexion à la base de données
include "conn_bdd.php";

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
		echo "Le mot de passe et la confirmation doivent être identiques";
	} else {
		// Hasher le mot de passe avec l'algorithme bcrypt
		$hash = password_hash($motdepasse, PASSWORD_DEFAULT);

		// Préparer la requête SQL pour insérer les données dans la base de données
		$sql = "INSERT INTO utilisateurs (nom, prenom, email, motdepasse) VALUES ('$nom', '$prenom', '$email', '$hash')";

		// Exécuter la requête SQL
		if (mysqli_query($conn, $sql)) {
			echo "Inscription réussie !";
		} else {
			echo "Erreur : " . mysqli_error($conn);
		}
	}
}

// Fermer la connexion
mysqli_close($conn);
