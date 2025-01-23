<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        .logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .navbar {
            margin: 20px 0;
        }

        .main-content {
            padding: 20px;
        }

        .habitation-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            transition: transform 0.2s;
        }

        .habitation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .habitation-photo {
            position: relative;
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: red;
            cursor: pointer;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <button class="btn btn-primary">Ajouter mon logement</button>
    <div class="logo">MonSite</div>
    <i class="fas fa-user-circle fa-2x"></i>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <form class="d-flex w-100" method="GET" action="search.php">
            <input class="form-control me-2" type="text" name="type" placeholder="Type de logement" aria-label="Type">
            <input class="form-control me-2" type="number" name="chambres" placeholder="Nombre de chambres" aria-label="Chambres">
            <input class="form-control me-2" type="number" name="loyer" placeholder="Loyer maximal" aria-label="Loyer">
            <input class="form-control me-2" type="text" name="emplacement" placeholder="Emplacement" aria-label="Emplacement">
            <button class="btn btn-outline-success" type="submit">Rechercher</button>
        </form>
    </div>
</nav>

<main class="main-content container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($habitations as $habitation): ?>
            <div class="col">
                <div class="habitation-card">
                    <div class="habitation-photo">
                        <img src="<?php echo $habitation['photos'][0] ?? 'placeholder.jpg'; ?>" class="img-fluid rounded" alt="Habitation">
                        <i class="fas fa-heart favorite-icon"></i>
                    </div>
                    <div class="mt-2">
                        <h5 class="card-title"><?php echo $habitation['emplacement']; ?></h5>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-star text-warning me-1"></i>
                            <span><?php echo $habitation['note']; ?></span>
                        </div>
                        <p class="card-text text-primary fw-bold">Loyer: <?php echo $habitation['loyer_journalier']; ?> &euro; / jour</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>&copy; 2025 MonSite. Tous droits réservés.</p>
    <p><a href="#">À propos</a> | <a href="#">Contact</a> | <a href="#">Politique de confidentialité</a></p>
</footer>

</body>
</html>
