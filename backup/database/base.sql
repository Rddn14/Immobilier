CREATE DATABASE immobilier;
USE immobilier;

-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    numero_telephone VARCHAR(20),
    est_admin BOOLEAN DEFAULT FALSE,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Insérer des utilisateurs avec un mot de passe simple et un numéro de téléphone spécifique
INSERT INTO utilisateurs (nom, email, mot_de_passe, numero_telephone, est_admin) VALUES 
('Tiana', 'tiana@example.com', '1', '0328061651', FALSE),
('Miora', 'miora@example.com', '2', '0328061652', FALSE),
('Ravo', 'ravo@example.com', '3', '0328061653', FALSE),
('Nirina', 'nirina@example.com', '4', '0328061654', TRUE);

-- Table des habitations
CREATE TABLE habitations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    chambres INT NOT NULL DEFAULT 1,
    loyer_journalier DECIMAL(10, 2) NOT NULL,
    emplacement VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tables des photos
CREATE TABLE photos(
    id INT AUTO_INCREMENT,
    habitation_id INT NOT NULL,
    chemin VARCHAR(255) UNIQUE NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY habitation_id REFERENCES habitations(id)
)

CREATE TABLE disponibilite(
    id INT AUTO_INCREMENT ,
    habitation_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (habitation_id) REFERENCES habitations(id) ON DELETE CASCADE
);

-- Table des réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT ,
    utilisateur_id INT NOT NULL,
    habitation_id INT NOT NULL,
    date_arrive DATE NOT NULL,
    date_depart DATE NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (habitation_id) REFERENCES habitations(id) ON DELETE CASCADE
);

-- Insertion des habitations
INSERT INTO habitations (type, chambres, loyer_journalier, emplacement, description) VALUES
('Villa', 4, 250000.00, 'Ivandry', 'Belle villa moderne avec piscine et jardin'),
('Appartement', 2, 150000.00, 'Ankorondrano', 'Appartement lumineux avec vue sur la ville'),
('Maison', 3, 200000.00, 'Ankadimbahoaka', 'Maison familiale avec garage'),
('Studio', 1, 80000.00, 'Analakely', 'Studio meublé en centre-ville'),
('Villa', 5, 300000.00, 'Ambatobe', 'Grande villa avec vue panoramique'),
('Appartement', 3, 180000.00, 'Andraharo', 'Appartement rénové avec balcon'),
('Maison', 4, 220000.00, 'Ambanidia', 'Maison traditionnelle avec grand jardin'),
('Studio', 1, 75000.00, 'Antanimena', 'Studio moderne proche commodités'),
('Villa', 6, 350000.00, 'Ambatoroka', 'Villa luxueuse avec piscine intérieure'),
('Appartement', 2, 160000.00, 'Mahamasina', 'Appartement neuf avec parking'),
('Maison', 3, 190000.00, 'Andoharanofotsy', 'Maison avec terrasse'),
('Studio', 1, 70000.00, 'Behoririka', 'Studio équipé en centre-ville'),
('Villa', 4, 280000.00, 'Ankadindramamy', 'Villa moderne style contemporain'),
('Appartement', 3, 170000.00, 'Ampasanimalo', 'Appartement spacieux et lumineux'),
('Maison', 4, 230000.00, 'Ambohimanarina', 'Grande maison familiale'),
('Studio', 1, 85000.00, 'Ambohijatovo', 'Studio rénové avec vue'),
('Villa', 5, 320000.00, 'Androhibe', 'Villa avec jardin tropical'),
('Appartement', 2, 155000.00, 'Ampefiloha', 'Appartement moderne équipé'),
('Maison', 3, 210000.00, 'Ankatso', 'Maison avec véranda'),
('Studio', 1, 78000.00, 'Tsaralalana', 'Studio confortable en centre-ville');

-- Insertion des photos (3 photos par habitation)
INSERT INTO photos (habitation_id, chemin) VALUES
-- Photos pour habitation 1
(1, '/images/villa-ivandry-1.jpg'),
(1, '/images/villa-ivandry-2.jpg'),
(1, '/images/villa-ivandry-3.jpg'),
-- Photos pour habitation 2
(2, '/images/appart-ankorondrano-1.jpg'),
(2, '/images/appart-ankorondrano-2.jpg'),
(2, '/images/appart-ankorondrano-3.jpg'),
-- Photos pour habitation 3
(3, '/images/maison-ankadimbahoaka-1.jpg'),
(3, '/images/maison-ankadimbahoaka-2.jpg'),
(3, '/images/maison-ankadimbahoaka-3.jpg'),
-- Photos pour habitation 4
(4, '/images/studio-analakely-1.jpg'),
(4, '/images/studio-analakely-2.jpg'),
(4, '/images/studio-analakely-3.jpg'),
-- Photos pour habitation 5
(5, '/images/villa-ambatobe-1.jpg'),
(5, '/images/villa-ambatobe-2.jpg'),
(5, '/images/villa-ambatobe-3.jpg'),
-- Photos pour habitation 6
(6, '/images/appart-andraharo-1.jpg'),
(6, '/images/appart-andraharo-2.jpg'),
(6, '/images/appart-andraharo-3.jpg'),
-- Photos pour habitation 7
(7, '/images/maison-ambanidia-1.jpg'),
(7, '/images/maison-ambanidia-2.jpg'),
(7, '/images/maison-ambanidia-3.jpg'),
-- Photos pour habitation 8
(8, '/images/studio-antanimena-1.jpg'),
(8, '/images/studio-antanimena-2.jpg'),
(8, '/images/studio-antanimena-3.jpg'),
-- Photos pour habitation 9
(9, '/images/villa-ambatoroka-1.jpg'),
(9, '/images/villa-ambatoroka-2.jpg'),
(9, '/images/villa-ambatoroka-3.jpg'),
-- Photos pour habitation 10
(10, '/images/appart-mahamasina-1.jpg'),
(10, '/images/appart-mahamasina-2.jpg'),
(10, '/images/appart-mahamasina-3.jpg'),
-- Photos pour habitation 11
(11, '/images/maison-andoharanofotsy-1.jpg'),
(11, '/images/maison-andoharanofotsy-2.jpg'),
(11, '/images/maison-andoharanofotsy-3.jpg'),
-- Photos pour habitation 12
(12, '/images/studio-behoririka-1.jpg'),
(12, '/images/studio-behoririka-2.jpg'),
(12, '/images/studio-behoririka-3.jpg'),
-- Photos pour habitation 13
(13, '/images/villa-ankadindramamy-1.jpg'),
(13, '/images/villa-ankadindramamy-2.jpg'),
(13, '/images/villa-ankadindramamy-3.jpg'),
-- Photos pour habitation 14
(14, '/images/appart-ampasanimalo-1.jpg'),
(14, '/images/appart-ampasanimalo-2.jpg'),
(14, '/images/appart-ampasanimalo-3.jpg'),
-- Photos pour habitation 15
(15, '/images/maison-ambohimanarina-1.jpg'),
(15, '/images/maison-ambohimanarina-2.jpg'),
(15, '/images/maison-ambohimanarina-3.jpg'),
-- Photos pour habitation 16
(16, '/images/studio-ambohijatovo-1.jpg'),
(16, '/images/studio-ambohijatovo-2.jpg'),
(16, '/images/studio-ambohijatovo-3.jpg'),
-- Photos pour habitation 17
(17, '/images/villa-androhibe-1.jpg'),
(17, '/images/villa-androhibe-2.jpg'),
(17, '/images/villa-androhibe-3.jpg'),
-- Photos pour habitation 18
(18, '/images/appart-ampefiloha-1.jpg'),
(18, '/images/appart-ampefiloha-2.jpg'),
(18, '/images/appart-ampefiloha-3.jpg'),
-- Photos pour habitation 19
(19, '/images/maison-ankatso-1.jpg'),
(19, '/images/maison-ankatso-2.jpg'),
(19, '/images/maison-ankatso-3.jpg'),
-- Photos pour habitation 20
(20, '/images/studio-tsaralalana-1.jpg'),
(20, '/images/studio-tsaralalana-2.jpg'),
(20, '/images/studio-tsaralalana-3.jpg');

-- Insertion des disponibilités pour les 6 prochains mois
INSERT INTO disponibilite (habitation_id, date_debut, date_fin)
SELECT 
    h.id,
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 6 MONTH)
FROM habitations h;


-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 2, 50000.00, 'public/assets/images/1.jpg', 'Antananarivo', 'Bel appartement au centre-ville avec une vue sur les collines.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 4, 150000.00, 'public/assets/images/2.jpg', 'Nosy Be', 'Villa luxueuse avec piscine et jardin tropical.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 25000.00, 'public/assets/images/3.jpg', 'Mahajanga', 'Studio moderne et bien équipé, idéal pour un séjour court.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 3, 80000.00, 'public/assets/images/4.jpg', 'Toamasina', 'Maison spacieuse proche de la mer, idéale pour une famille.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 1, 30000.00, 'public/assets/images/5.jpg', 'Diego-Suarez', 'Bungalow typique en bord de mer avec une vue exceptionnelle.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 3, 60000.00, 'public/assets/images/6.jpg', 'Fianarantsoa', 'Appartement calme et spacieux, proche des commerces.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 5, 200000.00, 'public/assets/images/7.jpg', 'Antsirabe', 'Villa avec un grand jardin et jacuzzi, parfaite pour se détendre.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 22000.00, 'public/assets/images/8.jpg', 'Tuléar', 'Petit studio cosy, à deux pas du centre-ville.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 4, 95000.00, 'public/assets/images/9.jpg', 'Morondava', 'Maison avec une terrasse donnant sur la mer.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 2, 40000.00, 'public/assets/images/10.jpg', 'Sainte-Marie', 'Bungalow familial avec accès direct à la plage.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 1, 45000.00, 'public/assets/images/11.jpg', 'Antananarivo', 'Appartement moderne et lumineux dans un quartier résidentiel.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 6, 300000.00, 'public/assets/images/12.jpg', 'Nosy Be', 'Grande villa avec piscine et salle de sport, idéale pour les groupes.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 20000.00, 'public/assets/images/13.jpg', 'Mahajanga', 'Studio abordable et pratique pour les voyageurs en solo.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 3, 100000.00, 'public/assets/images/14.jpg', 'Toamasina', 'Maison entièrement meublée avec un jardin spacieux.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 1, 35000.00, 'public/assets/images/15.jpg', 'Diego-Suarez', 'Bungalow en bois avec vue panoramique sur la mer.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 2, 48000.00, 'public/assets/images/16.jpg', 'Fianarantsoa', 'Appartement charmant avec une cuisine équipée.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 4, 180000.00, 'public/assets/images/17.jpg', 'Antsirabe', 'Villa élégante avec une cheminée et un grand salon.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 30000.00, 'public/assets/images/18.jpg', 'Tuléar', 'Studio au centre-ville, idéal pour un voyage d’affaires.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 5, 120000.00, 'public/assets/images/19.jpg', 'Morondava', 'Grande maison avec plusieurs chambres, parfaite pour une grande famille.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 2, 45000.00, 'public/assets/images/20.jpg', 'Sainte-Marie', 'Bungalow spacieux avec un grand balcon face à la mer.');






-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 3, 70000.00, 'public/assets/images/16.jpg', 'Antananarivo', 'Appartement spacieux avec une belle vue sur la ville.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 4, 120000.00, 'public/assets/images/17.jpg', 'Nosy Be', 'Villa avec plage privée et terrasse ensoleillée.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 28000.00, 'public/assets/images/18.jpg', 'Mahajanga', 'Studio moderne, parfait pour les étudiants ou les voyageurs seuls.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 5, 85000.00, 'public/assets/images/19.jpg', 'Toamasina', 'Maison spacieuse avec jardin et terrasse à proximité de la plage.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 2, 45000.00, 'public/assets/images/20.jpg', 'Diego-Suarez', 'Bungalow charmant, situé dans un cadre naturel exceptionnel.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 2, 60000.00, 'public/assets/images/21.jpg', 'Antananarivo', 'Appartement confortable au cœur du quartier d’affaires.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 3, 130000.00, 'public/assets/images/22.jpg', 'Nosy Be', 'Villa moderne avec piscine à débordement et vue mer.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 35000.00, 'public/assets/images/23.jpg', 'Tuléar', 'Studio lumineux avec cuisine équipée, idéal pour les séjours courts.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 4, 90000.00, 'public/assets/images/24.jpg', 'Morondava', 'Maison proche des attractions touristiques avec un grand jardin.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 3, 50000.00, 'public/assets/images/25.jpg', 'Sainte-Marie', 'Bungalow familial avec jardin et accès à la plage.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 2, 53000.00, 'public/assets/images/26.jpg', 'Antananarivo', 'Appartement agréable avec un balcon et vue dégagée.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 6, 250000.00, 'public/assets/images/27.jpg', 'Nosy Be', 'Villa avec grand jardin, piscine privée et espace pour les événements.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 22000.00, 'public/assets/images/28.jpg', 'Mahajanga', 'Studio bien situé, proche des restaurants et des commerces.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 5, 110000.00, 'public/assets/images/29.jpg', 'Toamasina', 'Maison avec 5 chambres et un grand salon, idéale pour une grande famille.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 1, 40000.00, 'public/assets/images/30.jpg', 'Diego-Suarez', 'Bungalow rustique en bord de mer, parfait pour les amoureux de la nature.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 3, 75000.00, 'public/assets/images/31.jpg', 'Antananarivo', 'Appartement chic avec trois chambres et une vue panoramique.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Villa', 4, 160000.00, 'public/assets/images/32.jpg', 'Nosy Be', 'Villa avec accès direct à la plage et à la piscine.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Studio', 1, 24000.00, 'public/assets/images/33.jpg', 'Tuléar', 'Studio tranquille et bien équipé pour un séjour détendu.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Maison', 3, 95000.00, 'public/assets/images/34.jpg', 'Morondava', 'Maison avec véranda et belle vue sur la mer et les plages.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Bungalow', 2, 42000.00, 'public/assets/images/35.jpg', 'Sainte-Marie', 'Bungalow avec deux chambres et accès facile à la mer.');

-- INSERT INTO habitations (type, chambres, loyer_journalier, photos, emplacement, description)
-- VALUES ('Appartement', 1, 50000.00, 'public/assets/images/36.jpg', 'Antananarivo', 'Appartement confortable avec une chambre et un grand salon.');








