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
            <a href="/index.php" class="base_a">
                <img src="../media/img/mydil.webp" alt="Logo LJBAC" title="La Jolie Boîte à Code">
            </a>
        </div>
        <div class="menu">
        <?php
        // On vérifie si la page est différente de accueil.php pour afficher le bouton d'accueil
        if(basename($_SERVER['PHP_SELF']) != "accueil.php") {
            $iconeAccueil = "../media/img/icone_accueil.svg";
            $lienAccueil = "accueil.php";
            
            // Si la page est index.php, on ajuste les valeurs
            if(basename($_SERVER['PHP_SELF']) == "index.php") {
                $iconeAccueil = "static/media/img/icone_accueil.svg";
                $lienAccueil = "static/php/accueil.php";
            }
        ?>
            <a href="<?= $lienAccueil ?>" class="base_a">
                <img src="<?= $iconeAccueil ?>" alt="Accueil" title="Accueil" class="base_icon">
            </a>
        <?php
        }

        // On vérifie si l'utilisateur est connecté
        if(isset($id)) {
            $iconeDeconnexion = "../media/img/icone_decon.svg";
            $lienDeconnexion = "deconnexion.php";
        ?>
            <a href="<?= $lienDeconnexion ?>" class="base_a">
                <img src="<?= $iconeDeconnexion ?>" alt="Se déconnecter" title="Se déconnecter" class="base_icon">
            </a>
        <?php
        } else {
            $iconeConnexion = "../media/img/icone_con.svg";
            $lienConnexion = "connexion.php";
            
            // Si la page est index.php, on ajuste les valeurs
            if(basename($_SERVER['PHP_SELF']) == "index.php") {
                $iconeConnexion = "static/media/img/icone_con.svg";
                $lienConnexion = "static/php/connexion.php";
            }
        ?>
            <a href="<?= $lienConnexion ?>" class="base_a">
                <img src="<?= $iconeConnexion ?>" alt="Se connecter" title="Se connecter" class="base_icon">
            </a>
        <?php
        }
        ?>
        </div>
    </nav>
</body>
</html>