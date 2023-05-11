<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/static/media/img/icone.ico" type="image/x-icon">
    <link rel="stylesheet" href="/static/css/style.css">
    <title>MyProjeception</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="/index.php">
                <div class="base-button">
                    <img src="/static/media/img/mydil.webp" alt="Logo MyDIL" title="MyDIL"></img>
                </div>
            </a>
        </div>
        <div class="menu">
        <?php
        // On vérifie si la page est différente de accueil.php pour afficher le bouton d'accueil
        if(basename($_SERVER['PHP_SELF']) != "accueil.php") {
        ?>
            <a href="/static/php/accueil.php">
                <div class="base-button">
                    <img src="/static/media/img/icone_accueil.svg" alt="Accueil" title="Accueil" class="base_icon"></img>
                </div>
            </a>
        <?php
        }

        // On vérifie si l'utilisateur est connecté
        if(isset($_SESSION['utilisateur_id'])) {
        ?>
            <a href="/static/php/deconnexion.php" class="base-button">
                <div class="base-button">
                    <img src="/static/media/img/icone_decon.svg" alt="Se déconnecter" title="Se déconnecter" class="base_icon"></img>
                </div>
            </a>
        <?php
        } else {
        ?>
            <a href="/static/php/connexion.php">
                <div class="base-button">
                    <img src="/static/media/img/icone_con.svg" alt="Se connecter" title="Se connecter" class="base_icon"></img>
                </div>
            </a>
        <?php
        }
        ?>
        </div>
    </nav>
</body>
</html>