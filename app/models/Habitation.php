<?php

namespace app\models;


class Habitation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lister toutes les habitations avec leurs photos
    public function getAll() {
        $query = "SELECT h.*, GROUP_CONCAT(p.chemin) as photos 
                  FROM habitations h 
                  LEFT JOIN photos p ON h.id = p.habitation_id 
                  GROUP BY h.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une habitation et ses photos
    public function insert($data) {
        try {
            $this->db->beginTransaction();

            // Insertion de l'habitation
            $query = "INSERT INTO habitations (type, chambres, loyer_journalier, emplacement, description) 
                      VALUES (:type, :chambres, :loyer_journalier, :emplacement, :description)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':type', $data['type']);
            $stmt->bindParam(':chambres', $data['chambres']);
            $stmt->bindParam(':loyer_journalier', $data['loyer_journalier']);
            $stmt->bindParam(':emplacement', $data['emplacement']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->execute();
            
            $habitation_id = $this->db->lastInsertId();

            // Insertion des photos
            if (isset($data['photos']) && is_array($data['photos'])) {
                $query = "INSERT INTO photos (habitation_id, chemin) VALUES (:habitation_id, :chemin)";
                $stmt = $this->db->prepare($query);
                
                foreach ($data['photos'] as $chemin) {
                    $stmt->bindParam(':habitation_id', $habitation_id);
                    $stmt->bindParam(':chemin', $chemin);
                    $stmt->execute();
                }
            }

            // Insertion de la disponibilité initiale
            if (isset($data['date_debut']) && isset($data['date_fin'])) {
                $query = "INSERT INTO disponibilite (habitation_id, date_debut, date_fin) 
                          VALUES (:habitation_id, :date_debut, :date_fin)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':habitation_id', $habitation_id);
                $stmt->bindParam(':date_debut', $data['date_debut']);
                $stmt->bindParam(':date_fin', $data['date_fin']);
                $stmt->execute();
            }

            $this->db->commit();
            return $habitation_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Modifier une habitation
    public function update($id, $data) {
        try {
            $this->db->beginTransaction();

            // Mise à jour des informations de l'habitation
            $query = "UPDATE habitations SET 
                      type = :type, 
                      chambres = :chambres, 
                      loyer_journalier = :loyer_journalier, 
                      emplacement = :emplacement, 
                      description = :description 
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':type', $data['type']);
            $stmt->bindParam(':chambres', $data['chambres']);
            $stmt->bindParam(':loyer_journalier', $data['loyer_journalier']);
            $stmt->bindParam(':emplacement', $data['emplacement']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->execute();

            // Mise à jour des photos si nécessaire
            if (isset($data['photos']) && is_array($data['photos'])) {
                // Supprimer les anciennes photos
                $query = "DELETE FROM photos WHERE habitation_id = :habitation_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':habitation_id', $id);
                $stmt->execute();

                // Ajouter les nouvelles photos
                $query = "INSERT INTO photos (habitation_id, chemin) VALUES (:habitation_id, :chemin)";
                $stmt = $this->db->prepare($query);
                
                foreach ($data['photos'] as $chemin) {
                    $stmt->bindParam(':habitation_id', $id);
                    $stmt->bindParam(':chemin', $chemin);
                    $stmt->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Supprimer une habitation et toutes ses données associées
    public function delete($id) {
        try {
            $this->db->beginTransaction();

            // Les photos et disponibilités seront supprimées automatiquement grâce aux contraintes ON DELETE CASCADE
            $query = "DELETE FROM habitations WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $result = $stmt->execute();

            $this->db->commit();
            return $result;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Obtenir une habitation spécifique avec ses photos
    public function getById($id) {
        $query = "SELECT h.*, GROUP_CONCAT(p.chemin) as photos,
                  d.date_debut, d.date_fin
                  FROM habitations h 
                  LEFT JOIN photos p ON h.id = p.habitation_id 
                  LEFT JOIN disponibilite d ON h.id = d.habitation_id
                  WHERE h.id = :id
                  GROUP BY h.id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier la disponibilité d'une habitation pour une période donnée
    public function checkDisponibilite($id, $date_debut, $date_fin) {
        $query = "SELECT COUNT(*) FROM reservations 
                  WHERE habitation_id = :id 
                  AND ((date_arrive BETWEEN :date_debut AND :date_fin) 
                  OR (date_depart BETWEEN :date_debut AND :date_fin)
                  OR (:date_debut BETWEEN date_arrive AND date_depart))";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':date_debut', $date_debut);
        $stmt->bindParam(':date_fin', $date_fin);
        $stmt->execute();
        
        return $stmt->fetchColumn() == 0;
    }

    // Rechercher une habitation par plusieurs criteres
    public function search($type = null, $chambres = 0, $loyer_journalier = 0, $emplacement = null, $description = null) {
        $query = "SELECT h.*, GROUP_CONCAT(p.chemin) as photos 
                  FROM habitations h 
                  LEFT JOIN photos p ON h.id = p.habitation_id 
                  WHERE 1=1";
        $params = [];

        // Ajout des conditions dynamiques
        if (!empty($type)) {
            $query .= " AND h.type LIKE :type";
            $params[':type'] = "%$type%";
        }
        if ($chambres > 0) {
            $query .= " AND h.chambres = :chambres";
            $params[':chambres'] = $chambres;
        }
        if ($loyer_journalier > 0) {
            $query .= " AND h.loyer_journalier BETWEEN :min_loyer AND :max_loyer";
            $params[':min_loyer'] = $loyer_journalier * 0.8;
            $params[':max_loyer'] = $loyer_journalier * 1.2;
        }
        if (!empty($emplacement)) {
            $query .= " AND h.emplacement LIKE :emplacement";
            $params[':emplacement'] = "%$emplacement%";
        }
        if (!empty($description)) {
            $mots = array_filter(explode(' ', strtolower(trim($description))), fn($mot) => strlen($mot) > 2);
            if (!empty($mots)) {
                $conditions = array_map(fn($mot) => "LOWER(h.description) LIKE ?", $mots);
                $query .= " AND (" . implode(" OR ", $conditions) . ")";
                foreach ($mots as $mot) {
                    $params[] = "%$mot%";
                }
            }
        }

        $query .= " GROUP BY h.id";

        // Préparation et exécution de la requête
        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue(is_int($key) ? $key + 1 : $key, $value);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les photos associées à une habitation
public function getPhotosByHabitationId($habitation_id, $photo_id = null) {
    $query = "SELECT id, chemin 
              FROM photos 
              WHERE habitation_id = :habitation_id";
    
    // Si un id spécifique de photo est fourni, on ajoute une condition
    if ($photo_id !== null) {
        $query .= " AND id = :photo_id";
    }

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':habitation_id', $habitation_id);

    if ($photo_id !== null) {
        $stmt->bindParam(':photo_id', $photo_id);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}

?>