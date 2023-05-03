
<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
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

// Connexion à la base de données
include "conn_bdd.php";

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations de connexion soumises par l'utilisateur
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Préparer la requête pour vérifier si l'utilisateur existe dans la base de données
    $assertion = $conn_bdd->prepare("SELECT nom FROM utilisateur WHERE nom IS LIKE :nom");

    // Exécuter la requête
    $traitement = $assertion->execute(['nom' => $nom]);

    // Obtenir le résultat de la requête
    $result = $assertion->get_result();

    // Vérifier si l'utilisateur existe dans la base de données
    if ($result->num_rows == 1) {
        // Obtenir les informations de l'utilisateur
        $row = $result->fetch_assoc();

        // Vérifier si le mot de passe est correct
        if ($password == $row["mot_de_passe"]) {

            // Démarrer une session pour l'utilisateur
            session_start();

            // Enregistrer l'identifiant de l'utilisateur dans la session
            $_SESSION["utilisateur_id"] = $row["id"];

            // Rediriger l'utilisateur vers la page d'accueil
            header("Location: reussi.php");
            exit();
        } else {
            // Afficher un message d'erreur si le mot de passe est incorrect
            $error_message = "Le mot de passe est incorrect.";
        }
    } else {
        // Afficher un message d'erreur si l'utilisateur n'existe pas dans la base de données
        $error_message = "Le nom d'utilisateur n'existe pas.";
    }
}

?>