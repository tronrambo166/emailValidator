<?php

/**
 * This file is part of Berevi Collection applications.
 *
 * (c) Alan Da Silva
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or on Codecanyon
 *
 * @see https://codecanyon.net/licenses/terms/regular
 */

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../app/Autoloader.php';

$BRVFramLoader = new Autoloader('app', __DIR__.'/../');
$BRVFramLoader->register();

$BRVFramLoader2 = new Autoloader('src', __DIR__.'/../');
$BRVFramLoader2->register();

require __DIR__.'/../vendor/autoload.php';

$kernel = 'app\Kernel';

$app = new $kernel;

$controller = $app->run();

$action = explode(":", $controller);

$requirements = explode(";", $action[1]);

$route = new $action[0]($app->run()); 

empty($requirements[1]) ?
    $route->indexAction($requirements[0], null) :
    $route->indexAction($requirements[0], $requirements[1])
;
