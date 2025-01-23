<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trano - S'inscrire</title>
    <link rel="stylesheet" href="assets/css/loginregister.css">
</head>
<body>
    
    <main>
        <div class="container">
            <h1>Créez un compte pour explorer le monde avec Trano</h1>

            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?php
                    if ($_GET['error'] === 'missing_fields') {
                        echo "Tous les champs doivent être remplis.";
                    } elseif ($_GET['error'] === 'duplicate_email') {
                        echo "L'email est déjà utilisé.";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <form action="/register" method="POST">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="numero_telephone">Numéro de téléphone</label>
                <input type="text" id="numero_telephone" name="numero_telephone">
                
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <button type="submit">S'inscrire</button>
            </form>

            <p>Déjà inscrit ? <a href="/login">Se connecter ici</a></p>
        </div>
    </main>
</body>
</html>
