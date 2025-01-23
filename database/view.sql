CREATE VIEW habitations_reservees AS
SELECT DISTINCT
    h.id AS habitation_id,
    h.type,
    h.chambres,
    h.loyer_journalier,
    h.emplacement,
    h.description,
    r.date_arrive,
    r.date_depart,
    u.nom AS locataire,
    u.email AS email_locataire,
    u.numero_telephone AS telephone_locataire
FROM 
    habitations h
    INNER JOIN reservations r ON h.id = r.habitation_id
    INNER JOIN utilisateurs u ON r.utilisateur_id = u.id
GROUP BY 
    h.id,
    h.type,
    h.chambres,
    h.emplacement,
    h.description,
    r.date_arrive,
    r.date_depart,
    u.nom,
    u.email,
    u.numero_telephone
ORDER BY 
    r.date_arrive DESC;