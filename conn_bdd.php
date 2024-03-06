<?php
use PDO;
use PDOException;
class ConnexionBdd {
    private $dbh;

    public function __construct() {
        // On initialise les dépendances
        require "./vendor/autoload.php";

        $dotenv = \Dotenv\Dotenv::createMutable(__DIR__);
        $dotenv->load();

        // On configure PDO
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        // On enregistre les identifiants dans des variables
        define('HOTE', $_ENV['DB_HOST']);
        define('BDD', $_ENV['DB_DATABASE']);
        define('UTILISATEUR', $_ENV['DB_USERNAME']);
        // On échappe les caractères spéciaux pour éviter les injections SQL
        define('MDP', htmlspecialchars($_ENV['DB_PASSWORD'], ENT_QUOTES, 'UTF-8')); 
        $dsn = "mysql:host=".HOTE.";dbname=".BDD;

        // On se connecte à la base de données avec les paramètres définis
        try {
            $this->dbh = new PDO($dsn, UTILISATEUR, MDP, $options);
        } catch (PDOException $erreur) {
            echo "Erreur de connexion : " . $erreur->getMessage();
        }
    }

    public function recupDbh() {
        return $this->dbh;
    }
}