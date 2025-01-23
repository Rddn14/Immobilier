<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trano - Se connecter</title>
    <link rel="stylesheet" href="assets/css/loginregister.css">
</head>
<body>
    
    <main>
        <div class="container">
            <h1>Connectez-vous pour accéder à Trano</h1>

            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?php
                    if ($_GET['error'] === 'missing_fields') {
                        echo "Tous les champs doivent être remplis.";
                    } elseif ($_GET['error'] === 'invalid_credentials') {
                        echo "Email ou mot de passe incorrect.";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">Inscription réussie, vous pouvez maintenant vous connecter.</div>
            <?php endif; ?>

            <form action="/login" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <button type="submit">Se connecter</button>
            </form>

            <p>Pas encore inscrit ? <a href="/register">S'inscrire ici</a></p>
        </div>
    </main>
</body>
</html>
