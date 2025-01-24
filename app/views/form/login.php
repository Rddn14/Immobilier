<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/login.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Section vide à gauche -->
            <div class="col-md-6"></div>
            <!-- Formulaire de connexion -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="form-section">
                    <h1 class="mb-4 text-center">Connexion</h1>
                    <form action="/api/login" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <span class="glyphicon glyphicon-envelope"></span> Email :
                            </label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <span class="glyphicon glyphicon-lock"></span> Mot de passe :
                            </label>
                            <input type="password" id="password" name="mot_de_passe" class="form-control" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-custom px-4">Se connecter</button>
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
