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
		$mot_de_passe = $_POST['mot_de_passe'];
		$confirmation = $_POST['mdp_confirm'];
		$categorie = $_POST['categorie'];
	
		// Vérifier que le mot de passe et la confirmation sont identiques
		if($mot_de_passe != $confirmation) {
			echo("<script>alert('Le mot de passe et la confirmation doivent être identiques')</script>");
		} else {
			// Hasher le mot de passe avec l'algorithme bcrypt
			$hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
	
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

<label for="select" class="form-label">Situation :</label>
    <select name="categorie" placeholder="Situation" class="form-input" id="form-categorie" required>
        <option value="1">B1(SN1)</option>
        <option value="2">B2(SN2)</option>
        <option value="3">B3(CDA/ASRBD/DevOps/IA)</option>
        <option value="4">B4(I1)</option>
        <option value="5">B5(I2)</option>
        <option value="8">Intervenant</option>
        <option value="9">Equipe pédagogique</option>
        <option value="10">Autre</option>
    </select>