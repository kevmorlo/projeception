<?php

if(!isset($_SESSION)){
    session_start();// Démarrer une session pour l'utilisateur
}
require "conn_bdd.php"; // Connexion à la base de données
include "base.php";
?>

<body>
    <h1>Page de connexion</h1>
    <?php if (isset($error_message)): ?>
    <p><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="POST">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Se connecter">
</form>
</body>
</html>
<?php

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations de connexion soumises par l'utilisateur
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Préparer la requête pour vérifier si l'utilisateur existe dans la base de données
    $assertion = $conn_bdd->prepare("SELECT id, mot_de_passe FROM utilisateur WHERE nom LIKE :nom");

    // Exécuter la requête
    $traitement = $assertion->execute(['nom' => $username]);

    // Afficher le résultat de la requête
    if($traitement){
        $resultat = $assertion->fetch();
    }

    // Vérifier si l'utilisateur existe dans la base de données
    if ($resultat) {
        // Vérifier si le mot de passe est correct
        if (password_verify($password, $resultat['mot_de_passe'])) {

            // Enregistrer l'identifiant de l'utilisateur dans la session
            $_SESSION["utilisateur_id"] = $resultat["id"];

            // Rediriger l'utilisateur vers la page d'accueil
            header("Location: reussi.php");
            exit();
        } else {
            // Afficher un message d'erreur si le mot de passe est incorrect
            echo('<script>alert("Le mot de passe est incorrect.")</script>)');
        }
    } else {
        // Afficher un message d'erreur si l'utilisateur n'existe pas dans la base de données
        echo('<script>alert("Le nom d\'utilisateur n\'existe pas.")</script>)');
    }
}

?>