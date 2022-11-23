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

namespace app;

use \app\library\HTTPRequest;
use \app\library\HTTPResponse;
use \app\library\Config;

/**
 * The Kernel is responsible for setting up all
 * the packs that make up the app and providing
 * them with the app configuration.
 */
class Kernel
{
    protected $request;
    protected $response;
    protected $config;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->request = new HTTPRequest();
        $this->response = new HTTPResponse();
        $this->config = new Config($this);
    }

    /**
     * Initializes the full path of the app and
     * executes the main method of the kernel.
     *
     * @return controller
     */
    public function run()
    {
        $this->getAppPath();

        return $this->getController();
    }

    /**
     * @return Config
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * Checks whether the path uses an API.
     *
     * @return string The API path
     */
    public function isAPI($requestURI, $var, $path, $lastVar)
    {
        $pos = strpos($requestURI, $var);
        if ($pos !== false) {
            $isAPI = explode("?", $requestURI);
            $path = $isAPI[0];
        } else {
            $path == $requestURI ? $path = $path : $path = $path."/".end($lastVar);
        }

        return $path;
    }

    /**
     * Places the full path of the app in the session
     * var "_appPath" if it does not exist.
     */
    public function getAppPath()
    {
        if (!isset($_SESSION['_appPath'])) {
            $appPath = explode("/login", $this->request->requestURI());
            $_SESSION['_appPath'] = $appPath[0];
        }

        $isSlash = substr($_SESSION['_appPath'], -1);
        if ($isSlash == "/") {
            $_SESSION['_appPath'] = substr($_SESSION['_appPath'], 0, -1);
        }
    }

    /**
     * Get the packs, controllers, and requirements (arguments).
     *
     * @return \library\Controller()
     */
    public function getController()
    {
        $router = new Router;
        $appConfig = new \app\config\AppConfig('routes');
        foreach ($appConfig->appRoutes() as $pack) {
            $vars = [];
            if ($pack["requirements"]) {
                $vars = explode('||', $pack["requirements"]);
                $lastVar = explode("/", $this->request->requestURI());
                $pack["path"] == $this->request->requestURI() ?
                    $pack["path"] = $pack["path"] :
                    $pack["path"] = $pack["path"]."/".end($lastVar)
                ;
            }

            // Add the route to the router.
            $router->addRoute(new library\Route($pack["path"], $pack["controller"], $pack["requirements"], $vars));
        }

        try {
            $matchedRoute = $router->getRoute($this->request->requestURI());
        } catch (\RuntimeException $e) {
            if ($e->getCode() == Router::NO_ROUTE) {
                // If no route matches, the requested page does not exist.
                $this->response->redirect404();
            }
        }

        if (!empty($matchedRoute)) {
            $module = explode(":", $matchedRoute->controller());
            $requirements = explode(":", $matchedRoute->requirements());
            if (count($requirements) - 1 >= 1) {
                $vars = "";
                foreach ($requirements as $value) {
                    $vars .= $value."||";
                }
            } else {
                $vars = "";
            }

            $controllerClass = new library\Controller('src\\'.$module[0].'\\Controller\\'.$module[1].'Controller:'.$module[2].';'.$vars);

            return $controllerClass->call();
        } else {
            $controllerClass = new library\Controller('app\error\error:index');

            return $controllerClass->call();
        }
    }
}
