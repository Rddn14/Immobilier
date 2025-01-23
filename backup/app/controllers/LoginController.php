<?php

namespace app\controllers;

use Flight;
use app\models\User;  // Utilisation du modèle User

class LoginController
{
    public function handleLogin()
    {
        // Récupérer les données du formulaire
        $email = $_POST['email'] ?? null;
        $mot_de_passe = $_POST['mot_de_passe'] ?? null;

        // Vérifier que les champs sont remplis
        if (!$email || !$mot_de_passe) {
            Flight::redirect('/login?error=missing_fields');
            return;
        }

        // Vérifier si l'utilisateur existe
        $utilisateur = User::findByEmail($email);
        
        // Comparer le mot de passe en texte clair
        if ($utilisateur && $mot_de_passe === $utilisateur['mot_de_passe']) {
            // Si les informations sont correctes, démarrer une session si elle n'est pas déjà active
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['utilisateur_id'] = $utilisateur['id'];
            $_SESSION['nom'] = $utilisateur['nom'];
            $_SESSION['est_admin'] = $utilisateur['est_admin'];

            // Rediriger selon le type d'utilisateur
            if ($_SESSION['est_admin']) {
                Flight::redirect('/admin');
            } else {
                Flight::redirect('/habitations/lister');
            }
        } else {
            // En cas d'erreur, rediriger vers la page de connexion
            Flight::redirect('/login?error=invalid_credentials');
        }
    }
}
?>
