<?php
// Initialisation
require 'conn_bdd.php';
include 'base.php';

?>
<body>
	<div class="form-container">
			<form action="{{ url_for('traitement_register') }}" method="POST" class="form">
				<h1 class="register-h1">Créer un projet</h1>
				<input type="text" name="titre" placeholder="Titre" class="form-input" id="form-title" required>
				<input type="text" name="description" placeholder="Description" class="form-input" id="form-description" required>
				<button type="submit" class="form-button">Créer un projet</button>
				<a href="base.php" class="a-redirect" title="Annuler" required>Annuler</a>
			</form>
		</div>
</body>
</html>
<?php
	
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Récupérer l'ID de l'utilisateur connecté
	session_start();
	$utilisateur_id = $_SESSION['Utilisateur_id'];
	
	// Récupérer les données du formulaire
	$titre = $_POST['titre'];
	$description = $_POST['description'];
	
	// Préparer la requête SQL pour insérer les données dans la base de données
	$assertion = $conn_bdd->prepare("INSERT INTO projet (titre, description, Utilisateur_id) VALUES (:titre, :description, :utilisateur_id)");

	// Exécuter la requête
	$traitement = $assertion->execute(["titre" => $titre, "description" => $description, "utilisateur_id" => $utilisateur_id]);
	
	if(!$traitement){
		echo("Connexion échouée: " . print_r($assertion->errorInfo(), true));
	}
}
?>

?> 