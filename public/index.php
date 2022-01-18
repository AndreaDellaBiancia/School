<?php

// POINT D'ENTRÉE UNIQUE : 
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

//! NOUVELLE NOTION : Session
//* On vient ouvrir notre session au début du script 
//* Pour en profiter sur toutes nos pages / fichiers
session_start();

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va 
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
}
// sinon
else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// ================================================================
// CONNECTION
// ================================================================
$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/signin',   // l'url à laquelle cette route réagit
    [
        'method' => 'connection', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\SecurityController' // nom du controller contenant la méthode
    ],
   'login' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'POST', // la méthode HTTP qui est autorisée
    '/signin',   // l'url à laquelle cette route réagit
    [
        'method' => 'connectionSend', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\SecurityController' // nom du controller contenant la méthode
    ],
    'login-form' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/logout',   // l'url à laquelle cette route réagit
    [
        'method' => 'logout', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\SecurityController' // nom du controller contenant la méthode
    ],
    'logout' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

// ================================================================
// HOME
// ================================================================
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);

// ================================================================
// TEACHERS
// ================================================================
$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/teachers',   // l'url à laquelle cette route réagit
    [
        'method' => 'list', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\TeacherController' // nom du controller contenant la méthode
    ],
    'teacher-list' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/teachers/add',   // l'url à laquelle cette route réagit
    [
        'method' => 'add', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\TeacherController' // nom du controller contenant la méthode
    ],
    'teacher-add' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'POST', // la méthode HTTP qui est autorisée
    '/teachers/add',   // l'url à laquelle cette route réagit
    [
        'method' => 'addSave', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\TeacherController' // nom du controller contenant la méthode
    ],
    'teacher-addSave' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/teachers/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'update', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\TeacherController' // nom du controller contenant la méthode
    ],
    'teacher-update' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'POST', // la méthode HTTP qui est autorisée
    '/teachers/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'updateSave', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\TeacherController' // nom du controller contenant la méthode
    ],
    'teacher-updateSave' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/teachers/delete/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'delete', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\TeacherController' // nom du controller contenant la méthode
    ],
    'teacher-delete' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

// ================================================================
// STUDENTS
// ================================================================
$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/students',   // l'url à laquelle cette route réagit
    [
        'method' => 'list', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\StudentController' // nom du controller contenant la méthode
    ],
    'student-list' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/students/add',   // l'url à laquelle cette route réagit
    [
        'method' => 'add', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\StudentController' // nom du controller contenant la méthode
    ],
    'student-add' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'POST', // la méthode HTTP qui est autorisée
    '/students/add',   // l'url à laquelle cette route réagit
    [
        'method' => 'addSave', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\StudentController' // nom du controller contenant la méthode
    ],
    'student-addSave' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/students/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'update', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\StudentController' // nom du controller contenant la méthode
    ],
    'student-update' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'POST', // la méthode HTTP qui est autorisée
    '/students/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'updateSave', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\StudentController' // nom du controller contenant la méthode
    ],
    'student-updateSave' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/students/delete/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'delete', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\StudentController' // nom du controller contenant la méthode
    ],
    'student-delete' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);



// ================================================================
// USERS
// ================================================================
$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/appusers',   // l'url à laquelle cette route réagit
    [
        'method' => 'list', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\AppUserController' // nom du controller contenant la méthode
    ],
    'user-list' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/appusers/add',   // l'url à laquelle cette route réagit
    [
        'method' => 'add', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\AppUserController' // nom du controller contenant la méthode
    ],
    'user-add' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);
$router->map(
    'POST', // la méthode HTTP qui est autorisée
    '/appusers/add',   // l'url à laquelle cette route réagit
    [
        'method' => 'addSave', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\AppUserController' // nom du controller contenant la méthode
    ],
    'user-addSave' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'POST', // la méthode HTTP qui est autorisée
    '/appusers/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'updateSave', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\AppUserController' // nom du controller contenant la méthode
    ],
    'user-updateSave' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/appusers/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'update', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\AppUserController' // nom du controller contenant la méthode
    ],
    'user-update' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);

$router->map(
    'GET', // la méthode HTTP qui est autorisée
    '/appusers/delete/[i:id]',   // l'url à laquelle cette route réagit
    [
        'method' => 'delete', // méthode à utiliser pour répondre à cette route
        'controller' => '\App\Controllers\AppUserController' // nom du controller contenant la méthode
    ],
    'user-delete' // nom de la route, convention "NomDuController-NomDeLaMéthode"
);






/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();