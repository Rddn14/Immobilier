<?php 
// Vérifier si l'utilisateur est bien admin
if (!isset($_SESSION['utilisateur_id']) || $_SESSION['est_admin'] != 1) {
    Flight::redirect('/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une habitation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            margin: 40px 0;
            font-size: 2.5rem;
            color: #003366;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #003366;
            font-weight: bold;
            text-align: center;
            padding: 8px 15px;
            background-color: #f4f4f4;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #003366;
            color: white;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Ajouter une habitation</h1>

    <?php if (isset($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="/admin/ajouter-habitation" method="POST" enctype="multipart/form-data">
        <label for="type">Type</label>
        <input type="text" id="type" name="type" required>

        <label for="chambres">Nombre de chambres</label>
        <input type="number" id="chambres" name="chambres" required>

        <label for="loyer_journalier">Loyer par jour</label>
        <input type="number" id="loyer_journalier" name="loyer_journalier" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>

        <label for="emplacement">Emplacement</label>
        <input type="text" id="emplacement" name="emplacement" required>

        <button type="submit">Ajouter</button>
    </form>

    <a href="/admin">Retour à la page admin</a>
</body>
</html>
