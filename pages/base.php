<?php
/**
 * Fichier contenant les composants présents sur toutes les pages.
 */
use Bdd\ConnexionBdd;

// On inclut le fichier de connexion à la base de données
require_once $_SERVER["DOCUMENT_ROOT"] . "/conn_bdd.php";

// On instancie la classe
$bdd = new ConnexionBdd();
$dbh = $bdd->recupDbh();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/static/media/img/icone.ico" type="image/x-icon">
    <link rel="stylesheet" href="/static/css/style.css">
</head>
<body>
    <header>
        <nav class="header_nav">
            <a href="" class="nav_logo">
                <img src="../static/media/img/mydil.webp" alt="MYDil" class="logo_img">
            </a>
            <ul class="nav_liste">
                <?php
                // Si la page n'est pas accueil.php pour afficher le bouton d'accueil
                if(basename($_SERVER['PHP_SELF']) != "accueil.php") { ?>
                <li>
                    <a href="./accueil.php" class="nav_a" id="b_accueil">A propos</a>
                </li>
                <?php }
                //Si l'utilisateur est connecté
                if(isset($_SESSION['utilisateur_id'])) { ?>
                <li>
                    <a href="./connexion.php" class="nav_a" id="b_connexion">Se connecter</a>
                </li>
                <?php } else { ?>
                <li>
                    <a href="./projets" class="nav_a" id="b_projets">Projets</a>
                </li>
                <li>
                    <a href="./utilisateurs" class="nav_a" id="b_utilisateurs">Utilisateurs</a>
                </li>
                <li>
                    <a href="./deconnexion" class="nav_a" id="b_deconnexion">Se déconnecter</a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </header>
</body>
</html>

<?php
// Gestion de la session
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Récupérer l'ID de l'utilisateur connecté
if (isset($_SESSION["utilisateur_id"])) {
    $id = $_SESSION["utilisateur_id"];
} else {
    $id = null;
}