<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    Flight::redirect('/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['nom']); ?> !</h1>
    
</body>
</html>
