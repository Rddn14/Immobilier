<?php

namespace app\controllers;

class HabitationController {

    private $habitationModel;

    public function __construct($db) {
        // Crée une instance du modèle Habitation
        $this->habitationModel = new Habitation($db);
    }

    // Afficher la liste des habitations
    public function lister() {
        $habitations = $this->habitationModel->lister();
        // Afficher la vue pour lister les habitations
        Flight::render('habitations/lister', ['liste-habitations' => $habitations]);
    }

    // Afficher le formulaire pour ajouter une habitation
    public function ajouterForm() {
        Flight::render('habitations/ajouter');
    }

    // Ajouter une habitation
    public function ajouter() {
        // Récupérer les données envoyées via POST
        $data = [
            'type' => Flight::request()->data->type,
            'chambres' => Flight::request()->data->chambres,
            'loyer_journalier' => Flight::request()->data->loyer_journalier,
            'photos' => Flight::request()->data->photos,
            'emplacement' => Flight::request()->data->emplacement,
            'description' => Flight::request()->data->description
        ];

        // Ajouter l'habitation
        if ($this->habitationModel->ajouter($data)) {
            Flight::redirect('/admin/habitations'); // Rediriger vers la liste
        } else {
            Flight::render('habitations/ajouter', ['error' => 'Erreur lors de l\'ajout']);
        }
    }

    // Afficher le formulaire pour modifier une habitation
    public function modifierForm($id) {
        $habitation = $this->habitationModel->get($id);
        Flight::render('habitations/modifier', ['habitation' => $habitation]);
    }

    // Modifier une habitation
    public function modifier($id) {
        // Récupérer les données envoyées via POST
        $data = [
            'type' => Flight::request()->data->type,
            'chambres' => Flight::request()->data->chambres,
            'loyer_journalier' => Flight::request()->data->loyer_journalier,
            'photos' => Flight::request()->data->photos,
            'emplacement' => Flight::request()->data->emplacement,
            'description' => Flight::request()->data->description
        ];

        // Modifier l'habitation
        if ($this->habitationModel->modifier($id, $data)) {
            Flight::redirect('/admin/habitations'); // Rediriger vers la liste
        } else {
            Flight::render('habitations/modifier', ['error' => 'Erreur lors de la modification']);
        }
    }

    // Supprimer une habitation
    public function supprimer($id) {
        if ($this->habitationModel->supprimer($id)) {
            Flight::redirect('/admin/habitations'); // Rediriger vers la liste
        } else {
            Flight::render('habitations/lister', ['error' => 'Erreur lors de la suppression']);
        }
    }
}
?>
