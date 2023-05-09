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
	$assertion = $conn_bdd->prepare("SELECT pseudonyme, nom, prenom, telephone, mail FROM utilisateur WHERE id = :id");
	$assertion->execute(["id" => $id]);
	$resultat = $assertion->fetch();
	$pseudo_bdd = $resultat["pseudonyme"];
	$nom_bdd = $resultat["nom"];
	$prenom_bdd = $resultat["prenom"];
	$tel_bdd = $resultat["telephone"];
	$mail_bdd = $resultat["mail"];
}

// On attends que le formulaire sois rempli
if(isset($_POST['mail']) && isset($_POST['mot_de_passe'])){
	// Code pour insérer les données dans la base de données
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Récupérer les données du formulaire
        $pseudonyme = $_POST['pseudonyme'];
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$telephone = $_POST['telephone'];
		$mail = $_POST['mail'];
		$mot_de_passe = $_POST['mot_de_passe'];
		$confirmation = $_POST['mdp_confirm'];
		$categorie = $_POST['categorie'];
	
		// Vérifier que le mot de passe et la confirmation sont identiques
		if($mot_de_passe != $confirmation){
			echo("<script>alert('Les mots de passe doivent être identiques')</script>");
		}else{
			// Hasher le mot de passe avec l'algorithme bcrypt
			$hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
	
			// Préparer la requête SQL pour insérer les données dans la base de données
			$assertion = $conn_bdd->prepare("INSERT INTO utilisateur (pseudonyme, nom, prenom, telephone, mail, mot_de_passe) VALUES (:pseudonyme, :nom, :prenom, :telephone, :mail, :hash)");
	
			// Exécuter la requête
			$traitement = $assertion->execute(["pseudonyme" => $pseudonyme, "nom" => $nom, "prenom" => $prenom, "telephone" => $telephone, "mail" => $mail, "hash" => $hash]);
			if(!$traitement){
				echo("Connexion échouée: " . print_r($assertion->errorInfo(), true));
			}else{
				echo("<script>alert('Modifications effectuées.')</script>");
			}
		}
	}
}
?>
<body>
    <div class="form-container">
		<form action="profil.php" method="POST" class="form">
            <h1 class="register-h1">Mon Profil</h1>
            <input type="text" name="pseudonyme" value="<?=$pseudo_bdd?>" placeholder="Nom d'utilisateur" class="form-input" id="form-user" required>
            <input type="text" name="prenom" value="<?=$prenom_bdd?>" placeholder="Prénom" class="form-input" id="form-name" required>
            <input type="text" name="nom" value="<?=$nom_bdd?>" placeholder="Nom" class="form-input" id="form-surname" required>
            <input type="tel" name="telephone" value="<?=$tel_bdd?>" placeholder="Téléphone" class="form-input">
            <input type="mail" name="mail" value="<?=$mail_bdd?>" placeholder="Adresse mail" class="form-input" required>
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
		<button type="submit" class="form-button">Créer un compte</button>
        </form>
    </div>
</body>