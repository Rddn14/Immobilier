<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des habitations</title>
    <link rel="stylesheet" href="/assets/css/css.css">
</head>
<body>

    <h1>Liste des habitations</h1>
    <a href="/admin/ajouter-habitation" class="add-habitation-link">Clique ici pour AJOUTER UNE HABITATION</a>
    <div class="habitations-container">
        <!-- Example habitation cards (replace this loop with dynamic content) -->
        <?php foreach ($habit as $habitation): ?>
            <div class="habitation-card">
                <div class="habitation-image">
                    <?php if (!empty($habitation['photos'])): ?>
                        <img src="/assets/images/<?php echo basename($habitation['photos']); ?>" alt="Photo de l'habitation">
                    <?php else: ?>
                        <span>Aucune photo</span>
                    <?php endif; ?>
                </div>
                <div class="habitation-info">
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($habitation['type']); ?></p>
                    <p><strong>Chambres:</strong> <?php echo htmlspecialchars($habitation['chambres']); ?></p>
                    <p><strong>Loyer Journalier:</strong> <?php echo number_format($habitation['loyer_journalier'], 2, ',', ' '); ?> Ar</p>
                    <p><strong>Emplacement:</strong> <?php echo htmlspecialchars($habitation['emplacement']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($habitation['description']); ?></p>
                </div>
                <div class="habitation-actions">
                    <a href="/admin/modifier-habitation/<?php echo $habitation['id']; ?>">Modifier</a>
                    <a href="/admin/supprimer-habitation/<?php echo $habitation['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette habitation ?');">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Link to add habitation -->
    <a href="/admin/ajouter-habitation" class="add-habitation-link">Ajouter une habitation</a>

</body>
</html>
