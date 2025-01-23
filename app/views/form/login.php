<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
</head>
<body>
    <h1>Connexion</h1>
    <form action="/api/login" method="post">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="mot_de_passe" required>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
