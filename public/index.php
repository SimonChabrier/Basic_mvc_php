<?php

use App\Controllers\ErrorController;
use App\Utils\Acl;

// .htaccess mis en place à la racine redirige toutes les URLs vers index.php

// ---------------------------------------------------------
require __DIR__ . '/../vendor/autoload.php';

// ---------------------------------------------------------
// Inclusion des classes
// ---------------------------------------------------------

require __DIR__ . '/../app/Controllers/CoreController.php';
require __DIR__ . '/../app/Controllers/CourseController.php';
require __DIR__ . '/../app/Controllers/UserController.php';

// ---------------------------------------------------------
// PDO Database connection
require __DIR__ . '/../app/Utils/Database.php';
//

// ---------------------------------------------------------
// Start the session on loading the app
// ---------------------------------------------------------

session_start();

// ---------------------------------------------------------
// Routage https://altorouter.com/usage/mapping-routes.html
// ---------------------------------------------------------

$router = new AltoRouter();

//$router->setBasePath($_SERVER['BASE_URI']);

$router->addRoutes(
    [
        ['GET', '/', 'App\Controllers\CourseController::showCourses', 'main-home'],
        ['GET', '/cours/[i:id]', 'App\Controllers\CourseController::showCourse', 'course-id'],
        ['GET', '/cours/update/[i:id]', 'App\Controllers\CourseController::courseUpdate', 'update-course'],
        ['POST', '/cours/update/[i:id]', 'App\Controllers\CourseController::courseUpdate', 'post-course'],
        ['GET', '/cours/delete/[i:id]', 'App\Controllers\CourseController::courseDelete', 'delete-course'],
        ['GET', '/form', 'App\Controllers\CourseController::courseCreate', 'course-form'],
        ['POST', '/form', 'App\Controllers\CourseController::courseCreate', 'create-course'],
        ['GET', '/register', 'App\Controllers\UserController::register', 'user-register'],
        ['POST', '/register', 'App\Controllers\UserController::registration', 'user-registeration'],
        ['GET', '/login', 'App\Controllers\UserController::logIn', 'user-login'],
        ['POST', '/login', 'App\Controllers\UserController::logIn', 'user-authenticate'],
        ['GET', '/logout', 'App\Controllers\UserController::logOut', 'user-logout']
    ]
);

/* -------------
--- 403 ---
--------------*/
$current_route_name = $router->match()['name'];
$current_user_role = $_SESSION['role'] ?? null;
Acl::checkAcl($current_user_role, $current_route_name);

/* -------------
--- 404 ---
--------------*/

// If $match === false, we invoke the 404 error controller
$match = $router->match();
// Use alto-dispatcher dependencie to dispatch the request
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
$dispatcher->dispatch();

