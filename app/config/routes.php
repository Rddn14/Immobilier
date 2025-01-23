<?php 


use app\controllers\WelcomeController;
use app\controllers\RegisterController;
use app\controllers\AdminController; 
use app\controllers\ApiController;
// use app\controllers\ApiExampleController;
// use app\controllers\HabitationController;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// Route pour la page d'accueil
$Welcome_Controller = new WelcomeController();
$router->get('/', [ $Welcome_Controller, 'welcome' ]);

$router->group('/form', function() use ($router,$app) {
    $router->get('/login', function() use ($app) {
        $app->render('form/login');  // Utilise Flight pour rendre la vue form/login.php
    });
    $router->get('/signup', function() use ($app) {
        $app->render('form/signup');  // Utilise Flight pour rendre la vue form/register.php
    });
});

// Route pour la page de connexion (afficher le formulaire de connexion)
$router->group('/api', function() use ($router,$app) {
    $Api_Controller = new ApiController();
    $router->post('/login',[$Api_Controller,'handleLogin']);
    $router->post('/signup',[$Api_Controller,'handleSignup']);
});

$router->group('/pages',function() use ($router,$app) {
    $router->get('/accueil',function() use ($app){
        $app->render('/pages/accueil');
    });
 });

// Route pour la page d'inscription (afficher le formulaire d'inscription)
$router->get('/register', function() use ($app) {
    $app->render('register');  // Utilise Flight pour rendre la vue register.php
});

// Route pour le traitement de l'inscription (POST)
$router->post('/register', [ new RegisterController(), 'handleRegister' ]); 

// Route pour la page admin
$router->get('/admin', function() use ($app) {
    $app->render('admin');  // Utilise Flight pour rendre la vue admin.php
});

// Routes pour gérer les habitations (admin)
$router->get('/admin/lister-habitations', [ new \app\controllers\AdminController(), 'listerHabitations' ]); // Liste les habitations
$router->get('/admin/ajouter-habitation', function() use ($app) {
    $app->render('admin/ajouter_habitation'); // Page d'ajout d'une habitation
});
$router->post('/admin/ajouter-habitation', [ new \app\controllers\AdminController(), 'ajouterHabitationPost' ]); // Traitement de l'ajout
$router->get('/admin/modifier-habitation/@id', [ new \app\controllers\AdminController(), 'modifierHabitation' ]); // Page de modification
$router->post('/admin/modifier-habitation/@id', [ new \app\controllers\AdminController(), 'modifierHabitationPost' ]); // Traitement de la modification
$router->get('/admin/supprimer-habitation/@id', [ new \app\controllers\AdminController(), 'supprimerHabitation' ]); // Supprimer une habitation

// Route pour la page d'accueil
$router->get('/acceuil', function() use ($app) {
    $app->render('acceuil');  // Utilise Flight pour rendre la vue acceuil.php
});

//Flight::route('/habitations', ['AcceuilController', 'listeHabitations']);

// $router->get('/habitations', new \app\controllers\HabitationController(), 'listeHabitations');


// // Exemple d'API (reste inchangé)
// $router->group('/api', function() use ($router, $app) {
//     $Api_Example_Controller = new ApiExampleController($app);
//     $router->get('/users', [ $Api_Example_Controller, 'getUsers' ]);
//     $router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);
//     $router->post('/users/@id:[0-9]', [ $Api_Example_Controller, 'updateUser' ]);
// });