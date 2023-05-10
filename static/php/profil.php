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
		$assertion = $conn_bdd->prepare("SELECT pseudonyme, nom, prenom, telephone, mail, Categorie_id, description FROM utilisateur WHERE id = :id");
		$assertion->execute(["id" => $id]);
		$donnees_utilisateur = $assertion->fetch();
		$assertion = $conn_bdd->prepare("SELECT categorie.id, categorie.nom FROM categorie JOIN utilisateur ON Categorie_id = categorie.id WHERE utilisateur.id = :id;");
		$assertion->execute(["id" => $id]);
		$donnees_categorie = $assertion->fetch();

		// Code pour insérer les données dans la base de données
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Récupérer les données du formulaire en les filtrant avec filter_input()
		$donnees = [
			'id' => $id,
			'pseudonyme' => filter_input(INPUT_POST, 'pseudonyme', FILTER_SANITIZE_EMAIL),
			'nom' => filter_input(INPUT_POST, 'nom', FILTER_UNSAFE_RAW),
			'prenom' => filter_input(INPUT_POST, 'prenom', FILTER_UNSAFE_RAW),
			'telephone' => filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_EMAIL),
			'mail' => filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL),
			'categorie' => $_POST['categorie'],
			'description' => filter_input(INPUT_POST, 'description', FILTER_UNSAFE_RAW),
		];

		// Préparer la requête SQL pour insérer les données dans la base de données
		$assertion = $conn_bdd->prepare("UPDATE utilisateur SET pseudonyme = :pseudonyme, nom = :nom, prenom = :prenom, telephone = :telephone, mail = :mail, Categorie_id = :categorie, description = :description WHERE id = :id");
		$assertion->bindParam(':id', $id);

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
            <h1 class="register-h1">Mon Profil</h1>
            <input type="text" name="pseudonyme" value="<?=$donnees_utilisateur["pseudonyme"]?>" placeholder="Nom d'utilisateur" class="form-input" id="form-user" required>
            <input type="text" name="prenom" value="<?=$donnees_utilisateur["prenom"]?>" placeholder="Prénom" class="form-input" id="form-name" required>
            <input type="text" name="nom" value="<?=$donnees_utilisateur["nom"]?>" placeholder="Nom" class="form-input" id="form-surname" required>
            <input type="tel" name="telephone" value="<?=$donnees_utilisateur["telephone"]?>" placeholder="Téléphone" class="form-input">
            <input type="mail" name="mail" value="<?=$donnees_utilisateur["mail"]?>" placeholder="Adresse mail" class="form-input" required>
            <label for="select" class="form-label">Situation :</label>
            <select name="categorie" placeholder="Situation" class="form-input" id="form-categorie" required>
                <option value="1">B1(SN1)</option>
                <option value="2">B2(SN2)</option>
                <option value="3">B3(CDA/ASRBD/DevOps/IA)</option>
                <option value="4">B4(I1)</option>
                <option value="5">B5(I2)</option>
                <option value="6">Intervenant</option>
                <option value="7">Equipe pédagogique</option>
                <option value="8">Autre</option>
				<?php
				if(isset($donnees_categorie) && !empty($donnees_categorie)) {
					// Accéder aux indices du tableau $donnees_categorie?>
				<option value="<?=$donnees_utilisateur["Categorie_id"]?>" selected><?=$donnees_categorie["nom"]?></option><?php
				}?>
            </select>
			<textarea type="text" name="description" placeholder="Ecrivez votre bio ici" class="form-input comment-textarea"><?=$donnees_utilisateur["description"]?></textarea>
		<button type="submit" class="form-button">Modifier</button>
        </form>
    </div>
</body>