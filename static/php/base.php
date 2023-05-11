<?php
// On définit les valeurs par défaut du favicon et du css
$favicon = "/static/media/img/icone.ico";
$css = "/static/css/style.css";

// On vérifie si la page est différente de index.php pour mettre les valeurs correspondantes
if(basename($_SERVER['PHP_SELF']) != "index.php") {
    $favicon = "../media/img/icone.ico";
    $css = "../css/style.css";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= $favicon ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= $css ?>">
    <title>MyProjeception</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="/index.php">
                <div class="base-button">
                    <img src="../media/img/mydil.webp" alt="Logo MyDIL" title="MyDIL"></img>
                </div>
            </a>
        </div>
        <div class="menu">
        <?php
        // On vérifie si la page est différente de accueil.php pour afficher le bouton d'accueil
        if(basename($_SERVER['PHP_SELF']) != "accueil.php") {
            $icone_accueil = "../media/img/icone_accueil.svg";
            $lien_accueil = "accueil.php";
            
            // Si la page est index.php, on ajuste les valeurs
            if(basename($_SERVER['PHP_SELF']) == "index.php") {
                $icone_accueil = "static/media/img/icone_accueil.svg";
                $lien_accueil = "static/php/accueil.php";
            }
        ?>
            <a href="<?= $lien_accueil ?>">
                <div class="base-button">
                    <img src="<?= $icone_accueil ?>" alt="Accueil" title="Accueil" class="base_icon"></img>
                </div>
            </a>
        <?php
        }

        // On vérifie si l'utilisateur est connecté
        if(isset($_SESSION['utilisateur_id'])) {
            $icone_deconnexion = "../media/img/icone_decon.svg";
            $lien_deconnexion = "deconnexion.php";
        ?>
            <a href="<?= $lien_deconnexion ?>" class="base-button">
                <div class="base-button">
                    <img src="<?= $icone_deconnexion ?>" alt="Se déconnecter" title="Se déconnecter" class="base_icon"></img>
                </div>
            </a>
        <?php
        } else {
            $icone_connexion = "../media/img/icone_con.svg";
            $lien_connexion = "connexion.php";
            
            // Si la page est index.php, on ajuste les valeurs
            if(basename($_SERVER['PHP_SELF']) == "index.php") {
                $icone_connexion = "static/media/img/icone_con.svg";
                $lien_connexion = "static/php/connexion.php";
            }
        ?>
            <a href="<?= $lien_connexion ?>">
                <div class="base-button">
                    <img src="<?= $icone_connexion ?>" alt="Se connecter" title="Se connecter" class="base_icon"></img>
                </div>
            </a>
        <?php
        }
        ?>
        </div>
    </nav>
</body>
</html>