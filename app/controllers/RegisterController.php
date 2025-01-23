<?php

namespace app\controllers;

use Flight;
use app\models\User;  // Utilisation du modèle User

class RegisterController
{
    public function handleRegister()
    {
        // Récupérer les données du formulaire
        $nom = $_POST['nom'] ?? null;
        $email = $_POST['email'] ?? null;
        $numero_telephone = $_POST['numero_telephone'] ?? null;
        $mot_de_passe = $_POST['mot_de_passe'] ?? null;

        // Vérifier que les champs sont remplis
        if (!$nom || !$email || !$mot_de_passe) {
            Flight::redirect('/register?error=missing_fields');
            return;
        }

        // Vérifier si l'utilisateur existe déjà
        $utilisateurExist = User::findByEmail($email);
        if ($utilisateurExist) {
            Flight::redirect('/register?error=duplicate_email');
            return;
        }

        // Créer l'utilisateur (en texte clair, sans hachage)
        $userModel = new User();
        $userModel->createUser($email, $mot_de_passe, $nom, $numero_telephone);

        // Rediriger vers la page de connexion après inscription
        Flight::redirect('/login?success=true');
    }
}
?>
