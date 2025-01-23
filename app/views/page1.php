<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        p {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .btn-custom {
            font-size: 1.2em;
            font-weight: bold;
            border: 2px solid white;
            color: white;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-custom:hover {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-4">Bienvenue</h1>
        <p class="mb-4">Choisissez une option :</p>
        <div class="d-flex justify-content-center">
            <a href="/form/login" class="btn btn-custom mx-2 px-4 py-2">Se connecter</a>
            <a href="/form/signup" class="btn btn-custom mx-2 px-4 py-2">S'inscrire</a>
        </div>
    </div>
    <!-- Lien vers Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
