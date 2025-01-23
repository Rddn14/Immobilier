<?php
// Vérifier si l'utilisateur est bien admin
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['est_admin'] != 1) {
    Flight::redirect('/login');
    exit;
}

// Récupérer les détails de l'habitation à modifier (assumé que $habitation est passé par le contrôleur)
?>

<h1>Modifier l'habitation</h1>

<form action="/admin/modifier-habitation/<?php echo $habitation['id']; ?>" method="POST">
    <label for="type">Type</label>
    <input type="text" id="type" name="type" value="<?php echo $habitation['type']; ?>" required>

    <label for="chambres">Nombre de chambres</label>
    <input type="number" id="chambres" name="chambres" value="<?php echo $habitation['chambres']; ?>" required>

    <label for="loyer_par_jour">Loyer par jour</label>
    <input type="number" id="loyer_journalier" name="loyer_journalier" value="<?php echo $habitation['loyer_journalier']; ?>" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" required><?php echo $habitation['description']; ?></textarea>

    <label for="emplacement">emplacement</label>
    <input type="text" id="emplacement" name="emplacement" value="<?php echo $habitation['emplacement']; ?>" required>

    <button type="submit">Modifier</button>
</form>

<a href="/admin">Retour à la page admin</a>
