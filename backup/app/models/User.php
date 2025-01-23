<?php
namespace app\models;

// Assure-toi d'importer correctement la classe Database avec la casse exacte
use app\config\Database; // Si ton fichier s'appelle database.php, mais avec un 'd' minuscule dans le nom

class User {
    // Méthode pour trouver un utilisateur par email
    public static function findByEmail($email) {
        $db = Database::getConnexion();  // Récupérer la connexion PDO

        $query = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Méthode pour créer un utilisateur (avec mot de passe en texte clair)
    public function createUser($email, $password, $nom, $numero_telephone) {
        $db = Database::getConnexion();  // Récupérer la connexion PDO

        // Insertion du mot de passe en texte clair (sans hachage)
        $query = "INSERT INTO utilisateurs (email, mot_de_passe, nom, numero_telephone) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$email, $password, $nom, $numero_telephone]);
    }
}
?>
