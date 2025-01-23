<?php
namespace app\config; // Namespace doit correspondre à l'endroit où il est situé

use PDO;

class Database {

    private static $instance = null;
    private static $connection = null;

    // Méthode pour récupérer la connexion à la base de données
    public static function getConnexion() {
        if (self::$connection === null) {
            try {
                // Remplace les informations suivantes par celles de ta base de données
                self::$connection = new PDO(
                    'mysql:host=localhost;dbname=immobilier;charset=utf8',
                    'root',
                    ''
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>
