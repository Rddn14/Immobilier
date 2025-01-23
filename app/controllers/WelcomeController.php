<?php

namespace app\controllers;

use Flight;

class WelcomeController {

	public function __construct() {

	}


	public function welcome() {
        Flight::render('page1');
    }
}