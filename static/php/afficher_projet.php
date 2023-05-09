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

	// On affiche les infos de l'utilisateur
	$assertion = $conn_bdd->prepare("SELECT titre, description FROM projet ");
	$titre_bdd = $resultat["titre"];
	$description_bdd = $resultat["description"];
}

// On attends que le formulaire sois rempli
if(isset($_POST['mail']) && isset($_POST['mot_de_passe'])){
	// Code pour insérer les données dans la base de données
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Récupérer les données du formulaire
        $titre = $_POST['titre'];
		$description = $_POST['description'];
	
			// Préparer la requête SQL pour insérer les données dans la base de données
			$assertion = $conn_bdd->prepare("INSERT INTO projet (titre, description) VALUES (:titre, :description)");
	
			// Exécuter la requête
			$traitement = $assertion->execute(["titre" => $titre, "description" => $description]);
			if(!$traitement){
				echo("Connexion échouée: " . print_r($assertion->errorInfo(), true));
			}else{
				echo("<script>alert('Modifications effectuées.')</script>");
			}
		}
	}

?>
<body>
    <div class="form-container">
		<form action="profil.php" method="POST" class="form">
            <h1 class="register-h1">Mon Profil</h1>
            <input type="text" name="pseudonyme" value="<?=$titre_bdd?>" placeholder="Nom d'utilisateur" class="form-input" id="form-user" required>
            <input type="text" name="prenom" value="<?=$description_bdd?>" placeholder="Prénom" class="form-input" id="form-name" required>

         
		<button type="submit" class="form-button">Projet</button>
        </form>
    </div>
</body>