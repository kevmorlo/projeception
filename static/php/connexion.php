<?php

if(!isset($_SESSION)){
    session_start();// Démarrer une session pour l'utilisateur
}
require "conn_bdd.php"; // Connexion à la base de données
include "base.php";

// Attendre que le formulaire sois soumis
if(isset($_POST['pseudonyme']) && isset($_POST['mot_de_passe'])) {
    // Vérifier si le formulaire de connexion a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire en les filtrant avec filter_input()
        $donnees = [
			"pseudonyme" => filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_EMAIL),
			"mot_de_passe" => $_POST["mot_de_passe"],
		];

        // Préparer la requête pour vérifier si l'utilisateur existe dans la base de données
        $assertion = $conn_bdd->prepare("SELECT id, mot_de_passe FROM utilisateur WHERE pseudonyme LIKE :pseudonyme");

        // Exécuter la requête
        $traitement = $assertion->execute(['pseudonyme' => $donnees["pseudonyme"]]);

        // Afficher le résultat de la requête
        if($traitement){
            $resultat = $assertion->fetch();
        }

        // Vérifier si l'utilisateur existe dans la base de données
        if ($resultat) {
            // Vérifier si le mot de passe est correct
            $mdp_hash = $resultat['mot_de_passe'];
            if (password_verify($donnees["mot_de_passe"], $mdp_hash)) {

                // Enregistrer l'identifiant de l'utilisateur dans la session
                $_SESSION["utilisateur_id"] = $resultat["id"];

                // Rediriger l'utilisateur vers la page d'accueil
                header("Location: reussi.php");
                exit();
            } else {
                // Afficher un message d'erreur si le mot de passe est incorrect
                echo('<script>alert("Le mot de passe est incorrect.")</script>');
            }
        } else {
            // Afficher un message d'erreur si l'utilisateur n'existe pas dans la base de données
            echo('<script>alert("Le nom d\'utilisateur n\'existe pas.")</script>');
        }
    }
}

?>

<body>
    <div class="form-super-container">
        <div class="form-container">
            <form method="POST" class="form">
                <h1>Se connecter</h1>
                <input type="text" id="pseudonyme" name="pseudonyme" class="form-input" placeholder="Nom d'utilisateur" required>
                <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-input" placeholder="Mot de passe" required>
                <input type="submit" value="Se connecter" class="form-button">
                <a href="inscription.php" class="a-redirect" title="Créer un compte" required>Créer un compte</a>
            </form>
        </div>
    </div>
</body>
</html>