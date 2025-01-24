<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/signup.css">
    <style>
        body {
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        h1 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .form-section {
            background-color: rgba(210, 190, 220);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        label {
            font-weight: bold;
        }

        input {
            margin-bottom: 15px;
        }

        .btn-custom {
            font-size: 1em;
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
    <div class="container-fluid">
        <div class="row">
            <!-- Section vide à gauche -->
            <div class="col-md-6"></div>
            <!-- Formulaire d'inscription -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="form-section">
                    <h1 class="mb-4 text-center">Inscription</h1>
                    <form action="/api/signup" method="post">
                        <div class="mb-3">
                            <label for="nom" class="form-label">
                                <span class="glyphicon glyphicon-user"></span> Nom :
                            </label>
                            <input type="text" id="nom" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <span class="glyphicon glyphicon-envelope"></span> Email :
                            </label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="numero_telephone" class="form-label">
                                <span class="glyphicon glyphicon-earphone"></span> Numéro de téléphone :
                            </label>
                            <input type="text" id="numero_telephone" name="numero_telephone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <span class="glyphicon glyphicon-lock"></span> Mot de passe :
                            </label>
                            <input type="password" id="password" name="mot_de_passe" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">
                                <span class="glyphicon glyphicon-lock"></span> Confirmer le mot de passe :
                            </label>
                            <input type="password" id="confirm_password" name="confirm_mot_de_passe" class="form-control" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom px-4">S'inscrire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Lien vers Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
