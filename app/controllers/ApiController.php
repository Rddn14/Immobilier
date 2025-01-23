<?php

namespace app\controllers;

use Flight;
use app\models\User; // Utilisation du modèle User

class ApiController
{
    public function handleLogin()
    {
        // Récupérer et nettoyer les données du formulaire
        $email = $_POST['email'] ;
        $mot_de_passe = $_POST['mot_de_passe'];

        // Vérifier que les champs sont remplis
        if (!$email || !$mot_de_passe) {
            Flight::redirect('/api/login?error=missing_fields');
            return;
        }

        // Vérifier si l'utilisateur existe
        $utilisateur = User::findByEmail($email);

        // Comparer le mot de passe avec la version hachée
        if ($utilisateur && ($mot_de_passe == $utilisateur['mot_de_passe'])) {
            // Si les informations sont correctes, démarrer une session si elle n'est pas déjà active
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Stocker les informations de l'utilisateur en session
            $_SESSION['utilisateur_id'] = $utilisateur['id'];
            $_SESSION['nom'] = $utilisateur['nom'];
            $_SESSION['est_admin'] = $utilisateur['est_admin'];

            // Rediriger selon le type d'utilisateur
            if ($_SESSION['est_admin']) {
                Flight::redirect('/admin');
            } else {
                Flight::redirect('/pages/accueil');
            }
        } else {
            // En cas d'erreur, rediriger vers la page de connexion
            Flight::redirect('/api/login?error=invalid_credentials');
        }
    }

    public function handleSignup()
    {
        // Récupérer et nettoyer les données du formulaire
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $numero_telephone = $_POST['numero_telephone'];
        $mot_de_passe = $_POST['mot_de_passe'] ;
        $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'] ;

        // Vérifier que tous les champs sont remplis
        if (!$nom || !$email || !$numero_telephone || !$mot_de_passe || !$confirm_mot_de_passe) {
            Flight::redirect('/api/signup?error=missing_fields');
            return;
        }

        // Vérifier la correspondance des mots de passe
        if ($mot_de_passe !== $confirm_mot_de_passe) {
            Flight::redirect('/api/signup?error=password_mismatch');
            return;
        }


        // Insérer l'utilisateur dans la base de données
        try {
            $user = User::createUser($email , $mot_de_passe , $nom , $numero_telephone);

            // Rediriger après une inscription réussie
            Flight::redirect('/pages/accueil');
        } catch (Exception $e) {
            // Gestion des erreurs, par exemple : email déjà utilisé
            Flight::redirect('/api/signup?error=server_error');
        }
    }
}
