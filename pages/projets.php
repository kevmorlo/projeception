<?php
// Récupérer les données depuis la base de données
$assertion = $conn_bdd->prepare("SELECT id, titre, `description` FROM projet");
$assertion->execute();
$resultats = $assertion->fetchAll();
?>

<head>
    <title>Projets - MyProjeception</title>
</head>
<body>
    <h1>Projets</h1>
    <a href="creation_projet.php"></a>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($resultats as $ligne) { ?>
            <tr>
                <a href="afficher_projet.php?id_p=<?=$ligne['id']?>">
                    <td><?php echo $ligne['titre']; ?></td>
                    <td><?php echo $ligne['description']; ?></td>
                </a>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Titre</th>
                <th>Description</th>
            </tr>
        </tfoot>
    </table>
</body>