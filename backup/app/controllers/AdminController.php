<?php 
namespace app\controllers;

use Flight;
use app\config\Database;

class AdminController {

    // Méthode pour lister toutes les habitations
    public function listerHabitations() {
        $db = Database::getConnexion();
        $query = $db->query('SELECT * FROM habitations');
        $habit = $query->fetchAll();
        Flight::render('admin/lister_habitations', ['habit' => $habit]);
    }

    // Méthode pour afficher le formulaire d'ajout d'une habitation
    public function ajouterHabitation() {
       Flight::render('admin/ajouter_habitation');
    }

    // Méthode pour traiter l'ajout d'une habitation
    public function ajouterHabitationPost() {
        // Vérifier si l'utilisateur est admin
     if (!isset($_SESSION['utilisateur_id']) || $_SESSION['est_admin'] != 1) {
           Flight::redirect('/login');
            exit;
        }

        // Récupérer les données du formulaire
        $type = Flight::request()->data->type;
        $chambres = Flight::request()->data->chambres;
        $loyer_journalier = Flight::request()->data->loyer_journalier;
        $description = Flight::request()->data->description;
        $emplacement = Flight::request()->data->emplacement;

        // Gérer le téléchargement des photos
        $photos = [];
        if (isset($_FILES['photos']) && $_FILES['photos']['error'][0] === UPLOAD_ERR_OK) {
            // Assurer que le répertoire existe et est accessible
            $uploadDir = __DIR__ . '/../public/assets/images/';
            
            if (!is_writable($uploadDir)) {
                die("Le dossier de téléchargement n'est pas accessible en écriture.");
            }

            // Parcourir les fichiers téléchargés
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                $photoTmpPath = $tmp_name;
                $photoName = time() . '_' . basename($_FILES['photos']['name'][$key]);
                $photoPath = $uploadDir . $photoName;

                // Déplacer le fichier téléchargé vers le dossier des images
                if (move_uploaded_file($photoTmpPath, $photoPath)) {
                    $photos[] = $photoName; // Ajouter le nom du fichier à la liste des photos
                } else {
                    echo "Erreur lors du téléchargement de l'image " . $photoName;
                }
            }
        }

        // Vérifier que toutes les données sont présentes
        if ($type && $chambres && $loyer_journalier && $description && $emplacement) {
            $db = Database::getConnexion();

            // Convertir le tableau des photos en une chaîne séparée par des virgules
            $photosStr = implode(',', $photos);

            // Insérer les données dans la base de données
            $query = 'INSERT INTO habitations (type, chambres, loyer_journalier, description, emplacement, photos) 
                      VALUES (?, ?, ?, ?, ?, ?)';
            $stmt = $db->prepare($query);
            $stmt->execute([$type, $chambres, $loyer_journalier, $description, $emplacement, $photosStr]);

            // Rediriger vers la page de lister les habitations
            Flight::redirect('/admin/lister-habitations');
        } else {
            // Afficher un message d'erreur si des données sont manquantes
            Flight::render('admin/ajouter_habitation', ['error' => 'Tous les champs sont obligatoires']);
        }
    }

    // Méthode pour afficher le formulaire de modification d'une habitation
    public function modifierHabitation($id) {
        $db = Database::getConnexion();
        $query = 'SELECT * FROM habitations WHERE id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $habitation = $stmt->fetch();
        Flight::render('admin/modifier_habitation', ['habitation' => $habitation]);
    }

    // Méthode pour traiter la modification d'une habitation
    public function modifierHabitationPost($id) {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['utilisateur_id']) || $_SESSION['est_admin'] != 1) {
            Flight::redirect('/login');
            exit;
        }

        $type = Flight::request()->data->type;
        $chambres = Flight::request()->data->chambres;
        $loyer_journalier = Flight::request()->data->loyer_journalier;
        $description = Flight::request()->data->description;
        $emplacement = Flight::request()->data->emplacement;

        $db = Database::getConnexion();

        // Mettre à jour l'habitation dans la base de données
        $query = 'UPDATE habitations SET type = ?, chambres = ?, loyer_journalier = ?, description = ?, emplacement = ? 
                  WHERE id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$type, $chambres, $loyer_journalier, $description, $emplacement, $id]);

        // Rediriger vers la page de lister les habitations
        Flight::redirect('/admin/lister-habitations');
    }

    // Méthode pour supprimer une habitation
    public function supprimerHabitation($id) {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['utilisateur_id']) || $_SESSION['est_admin'] != 1) {
            Flight::redirect('/login');
            exit;
        }

        $db = Database::getConnexion();
        $query = 'DELETE FROM habitations WHERE id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        // Rediriger vers la page de lister les habitations
        Flight::redirect('/admin/lister-habitations');
    }
}
