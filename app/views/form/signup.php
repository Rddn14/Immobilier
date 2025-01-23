<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
</head>
<body>
    <h1>Inscription</h1>
    <form action="/api/signup" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
        <br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="numero_telephone">Numéro de téléphone :</label>
        <input type="text" id="numero_telephone" name="numero_telephone">
        <br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="mot_de_passe" required>
        <br><br>
        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_mot_de_passe" required>
        <br><br>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>