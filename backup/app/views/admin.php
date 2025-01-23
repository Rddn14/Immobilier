<?php
// Vérification si l'utilisateur est connecté et si c'est un administrateur
//session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    // Redirection vers la page de connexion si non connecté
    Flight::redirect('/login');
    exit;
}

if ($_SESSION['est_admin'] != 1) {
    // Redirection vers la page d'accueil si ce n'est pas un administrateur
    Flight::redirect('/acceuil');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            color: black;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            align-items: center;
            background-color: white;
            color: black;
            padding: 20px 30px;
            font-size: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header img {
            width: 80px; /* Logo agrandi */
            margin-right: 20px;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            background-color: white;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav a {
            text-decoration: none;
            color: blue;
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: block;
        }

        nav a:hover {
            background-color: #00A6D6; /* Bleu ciel au survol */
            color: white;
            transform: translateY(-5px); /* Légère élévation des liens */
        }

        section {
            text-align: center;
            margin: 40px 0;
            padding: 0 20px;
        }

        section h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        section p {
            font-size: 1.1rem;
            color: #666;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #00A6D6;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        /* Styles de l'image ajoutée */
        .accueil-image {
            display: block;
            margin: 40px auto 0;
            width: 80%;  /* Ou ajuster la taille selon le besoin */
            max-width: 600px;  /* Largeur maximale pour l'image */
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        <img src="assets/images/logo.png" alt="Logo">
        <center><h1 style="font-size: 1.8rem;">Bienvenue dans votre espace d'administration :
            Modifiez, ajoutez ou supprimez des habitations facilement!</h1> </center><!-- Ecriture "Bienvenue" diminuée -->
    </header>

    <nav>
        <ul>
            <li><a href="/admin/lister-habitations">Lister les habitations</a></li>
            <li><a href="/admin/ajouter-habitation">Ajouter une habitation</a></li>
        </ul>
    </nav>

    

    <!-- Ajout de l'image -->
    <img src="assets/images/acceuil.png" alt="Image d'accueil" class="accueil-image">
    <section>
        <p>Bienvenue, <?php echo $_SESSION['nom']; ?> !</p>
        <p>Vous êtes connecté en tant qu'administrateur.</p>
    </section>
    
</body>
</html>
