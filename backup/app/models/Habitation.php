<?php
class Habitation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lister toutes les habitations avec leurs photos
    public function lister() {
        $query = "SELECT h.*, GROUP_CONCAT(p.chemin) as photos 
                  FROM habitations h 
                  LEFT JOIN photos p ON h.id = p.habitation_id 
                  GROUP BY h.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une habitation et ses photos
    public function ajouter($data) {
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
    public function modifier($id, $data) {
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
    public function supprimer($id) {
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
    public function verifierDisponibilite($id, $date_debut, $date_fin) {
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
    public function rechercher($type = null, $chambres = 0, $loyer_journalier = 0, $emplacement = null, $description = null) {
        $connection = null;
        $statement = null;
        $resultSet = null;
        $items = array();
        $query = new StringBuilder("SELECT h.*, GROUP_CONCAT(p.chemin) as photos 
                                  FROM habitations h 
                                  LEFT JOIN photos p ON h.id = p.habitation_id 
                                  WHERE 1=1");
    
        try {
            // Construction de la requête avec les conditions dynamiques
            if (!empty($type)) {
                $query->append(" AND h.type LIKE ?");
            }
            if ($chambres > 0) {
                $query->append(" AND h.chambres = ?");
            }
            if ($loyer_journalier > 0) {
                $query->append(" AND h.loyer_journalier BETWEEN ? AND ?");
            }
            if (!empty($emplacement)) {
                $query->append(" AND h.emplacement LIKE ?");
            }
            if (!empty($description)) {
                $mots = explode(' ', strtolower(trim($description)));
                $conditions_desc = array();
                foreach ($mots as $mot) {
                    if (strlen($mot) > 2) {
                        $conditions_desc[] = "LOWER(h.description) LIKE ?";
                    }
                }
                if (!empty($conditions_desc)) {
                    $query->append(" AND (" . implode(" OR ", $conditions_desc) . ")");
                }
            }
            
            $query->append(" GROUP BY h.id");
    
            // Ajout du tri par pertinence si description fournie
            if (!empty($description)) {
                $query->append(" ORDER BY CASE");
                foreach ($mots as $mot) {
                    if (strlen($mot) > 2) {
                        $query->append(" WHEN LOWER(h.description) LIKE ? THEN " . count($mots));
                    }
                }
                $query->append(" ELSE 0 END DESC");
            }
    
            // Préparation de la requête
            $connection = $this->db;
            $statement = $connection->prepare($query->toString());
    
            // Définition des paramètres dans la requête
            $paramIndex = 1;
            
            if (!empty($type)) {
                $statement->bindValue($paramIndex++, "%$type%");
            }
            if ($chambres > 0) {
                $statement->bindValue($paramIndex++, $chambres);
            }
            if ($loyer_journalier > 0) {
                $min = $loyer_journalier * 0.8;
                $max = $loyer_journalier * 1.2;
                $statement->bindValue($paramIndex++, $min);
                $statement->bindValue($paramIndex++, $max);
            }
            if (!empty($emplacement)) {
                $statement->bindValue($paramIndex++, "%$emplacement%");
            }
            if (!empty($description)) {
                foreach ($mots as $mot) {
                    if (strlen($mot) > 2) {
                        $statement->bindValue($paramIndex++, "%$mot%");
                    }
                }
                // Paramètres pour le ORDER BY
                foreach ($mots as $mot) {
                    if (strlen($mot) > 2) {
                        $statement->bindValue($paramIndex++, "%$mot%");
                    }
                }
            }
    
            // Exécution de la requête
            $resultSet = $statement->execute();
            
            // Traitement des résultats
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $habitation = new Habitation($this->db);
                $habitation->id = $row['id'];
                $habitation->type = $row['type'];
                $habitation->chambres = $row['chambres'];
                $habitation->loyer_journalier = $row['loyer_journalier'];
                $habitation->emplacement = $row['emplacement'];
                $habitation->description = $row['description'];
                $habitation->photos = explode(',', $row['photos']);
                
                $items[] = $habitation;
            }
    
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la recherche des habitations : " . $e->getMessage());
        } finally {
            // En PHP avec PDO, pas besoin de fermer explicitement les ressources
            // PDO le fait automatiquement
            $statement = null;
            $resultSet = null;
        }
    
        return $items;
    }
}

?>